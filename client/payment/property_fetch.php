<?php
error_reporting(0);
ini_set('display_errors', 0);
require_once '../../classes/Database.php';

$userId = $_POST['user_id'] ?? '';

// DataTables parameters
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

    $baseQuery = "
        FROM clients c
        JOIN users u ON c.user_id = u.id AND u.is_deleted = 0
        JOIN properties prop ON c.property_id = prop.id AND prop.is_deleted = 0
        JOIN (
            SELECT client_id, property_id, MAX(id) AS latest_payment_id
            FROM payments
            WHERE is_deleted = 0
            GROUP BY client_id, property_id
        ) latest ON latest.client_id = c.id AND latest.property_id = c.property_id
        JOIN payments p ON p.id = latest.latest_payment_id
        WHERE p.is_deleted = 0
    ";


    if (!empty($userId)) {
        $baseQuery .= " AND c.user_id = :user_id";
        $params[':user_id'] = $userId;
    }

    $searchQuery = "";
    if (!empty($searchValue)) {
        $searchQuery = " AND (
            u.firstname LIKE :search
            OR u.lastname LIKE :search
            OR prop.lot_are LIKE :search
            OR prop.location LIKE :search
            OR prop.property_type LIKE :search
        )";
        $params[':search'] = "%$searchValue%";
    }

    $stmt = $pdo->query("SELECT COUNT(*) AS allcount FROM payments WHERE is_deleted = 0 GROUP BY client_id, property_id");
    $totalRecords = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT COUNT(*) AS allcount $baseQuery $searchQuery");
    $stmt->execute($params);
    $totalRecordwithFilter = $stmt->fetchColumn();

    $sql = "
        SELECT 
            p.id,
            p.amount_paid,
            p.payment_date,
            p.updated_at,
            c.first_payment_date,
            c.balance,
            prop.status AS property_status,
            CONCAT(u.firstname, ' ', u.lastname) AS fullname,
            CONCAT('Lot #', prop.lot, ', Block ', prop.block) AS property_title,
            prop.location,
            prop.property_type,
            prop.lot_area,
            prop.price,
            c.payment_terms,
            CASE 
                WHEN c.balance = 0 THEN 'Fully Paid'
                WHEN c.balance != 0 THEN 'Ongoing'
                WHEN prop.status = 'reserved' THEN 'On Process'
                ELSE 'N/A'
            END AS payment_status
        $baseQuery
        $searchQuery
        ORDER BY $columnName $columnSortOrder
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $pdo->prepare($sql);

    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }

    $stmt->bindValue(':limit', $rowperpage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $row, PDO::PARAM_INT);
    $stmt->execute();

    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($records as &$record) {
        $priceNumeric = floatval($record['price']);

        $record['price'] = '₱' . number_format($priceNumeric, 2);

        $record['balance'] = '₱' . number_format($record['balance'], 2);
        $record['first_payment_date'] = date('m-d-Y', strtotime($record['first_payment_date']));

        if (empty($record['lot_area'])) {
            $record['lot_area'] = 'N/A';
        } else {
            $record['lot_area'] .= ' sqm';
        }


        $terms = strtolower(trim($record['payment_terms']));

        if ($terms === 'spot_cash') {
            $record['monthly_payment'] = 'Spot Cash';
        } elseif (is_numeric($terms) && $terms > 0) {
            $monthlyPayment = $priceNumeric / intval($terms);
            $record['monthly_payment'] = '₱' . number_format($monthlyPayment, 2);
        } else {
            $record['monthly_payment'] = 'N/A';
        }


        if ($record['payment_status'] === 'Fully Paid') {
            $record['payment_status'] = '<span class="badge badge-pill badge-success">Fully Paid</span>';
        } elseif ($record['payment_status'] === 'Ongoing') {
            $record['payment_status'] = '<span class="badge badge-pill badge-warning">Ongoing</span>';
        } elseif ($record['payment_status'] === 'On Process') {
            $record['payment_status'] = '<span class="badge badge-pill badge-info">Ongoing</span>';
        } else {
            $record['payment_status'] = '<span class="badge badge-pill badge-secondary">N/A</span>';
        }

        switch ($record['payment_terms']) {
            case 'spot_cash':
                $record['payment_terms'] = 'Spot Cash';
                break;
            case '3':
                $record['payment_terms'] = '3 Months';
                break;
            case '6':
                $record['payment_terms'] = '6 Months';
                break;
            case '12':
                $record['payment_terms'] = '12 Months';
                break;
            case '24':
                $record['payment_terms'] = '24 Months';
                break;
            case '36':
                $record['payment_terms'] = '36 Months';
                break;
            case '48':
                $record['payment_terms'] = '48 Months';
                break;
            case '60':
                $record['payment_terms'] = '60 Months';
                break;
            case '72':
                $record['payment_terms'] = '72 Months';
                break;
            default:
                $record['payment_terms'] = 'Unknown';
                break;
        }
    }

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
