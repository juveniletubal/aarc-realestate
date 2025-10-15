<?php
error_reporting(0);
ini_set('display_errors', 0);
require_once '../../classes/Database.php';

$userId = $_POST['userId'] ?? '';

// Read DataTables parameters
$draw = intval($_POST['draw']);
$row = intval($_POST['start']);
$rowperpage = intval($_POST['length']);
$searchValue = $_POST['search']['value'] ?? '';
$columnIndex = $_POST['order'][0]['column'] ?? 3;
$columnName = $_POST['columns'][$columnIndex]['data'] ?? 'p.updated_at';
$columnSortOrder = $_POST['order'][0]['dir'] ?? 'desc';

// Allowed columns
$allowedColumns = ['fullname', 'amount_paid', 'payment_date', 'updated_at', 'id'];
if (!in_array($columnName, $allowedColumns)) {
    $columnName = 'p.updated_at';
}

try {
    $params = [];

    // Base query
    $baseQuery = "
        FROM payments p
        JOIN clients c ON p.client_id = c.id AND c.is_deleted = 0
        JOIN users u ON c.user_id = u.id AND u.is_deleted = 0
        LEFT JOIN users staff ON c.assigned_staff = staff.id AND staff.is_deleted = 0
        LEFT JOIN properties prop ON c.property_id = prop.id AND prop.is_deleted = 0
        WHERE p.is_deleted = 0
    ";

    // Filter by user ID (if provided)
    if (!empty($userId)) {
        $baseQuery .= " AND u.id = :user_id";
        $params[':user_id'] = $userId;
    }

    // Search filter
    $searchQuery = "";
    if ($searchValue != '') {
        $searchQuery = " AND (u.firstname LIKE :search 
                           OR u.lastname LIKE :search 
                           OR p.amount_paid LIKE :search 
                           OR p.payment_date LIKE :search)";
        $params[':search'] = "%$searchValue%";
    }

    // Total records (no filter)
    $stmt = $pdo->query("SELECT COUNT(*) AS allcount FROM payments p WHERE p.is_deleted = 0");
    $totalRecords = $stmt->fetchColumn();

    // Total with filters
    $stmt = $pdo->prepare("SELECT COUNT(*) AS allcount $baseQuery $searchQuery");
    $stmt->execute($params);
    $totalRecordwithFilter = $stmt->fetchColumn();

    // Fetch records
    $sql = "
        SELECT 
            p.id,
            p.amount_paid,
            p.payment_date,
            p.updated_at,
            c.first_payment_date,
            CONCAT(staff.firstname, ' ', staff.lastname) AS staff_name,
            CONCAT('Lot ', prop.lot, ' / Block ', prop.block, ' (', prop.location, ')') AS property_title
        $baseQuery
        $searchQuery
        ORDER BY $columnName $columnSortOrder
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $pdo->prepare($sql);

    // Bind dynamic filters
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }

    // Bind limit & offset
    $stmt->bindValue(':limit', $rowperpage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $row, PDO::PARAM_INT);
    $stmt->execute();

    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format data
    foreach ($records as &$record) {
        $record['amount_paid'] = '₱' . number_format($record['amount_paid'], 2);

        $formattedDate = date('m-d-Y', strtotime($record['payment_date']));
        if (
            !empty($record['first_payment_date']) &&
            date('Y-m-d', strtotime($record['payment_date'])) === date('Y-m-d', strtotime($record['first_payment_date']))
        ) {
            $record['payment_date'] = "$formattedDate <span class='badge badge-pill badge-dark'>First Payment</span>";
        } else {
            $record['payment_date'] = $formattedDate;
        }

        $record['updated_at'] = date('Y-m-d h:i A', strtotime($record['updated_at']));
    }

    // Response
    $response = [
        "draw" => $draw,
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $records
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
} catch (Exception $e) {
    error_log("DataTables error: " . $e->getMessage());
    echo json_encode([
        "draw" => $draw,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => [],
        "error" => $e->getMessage()
    ]);
}
