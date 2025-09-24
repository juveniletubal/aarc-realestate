<?php
error_reporting(0);
ini_set('display_errors', 0);

require_once '../../classes/Database.php';

// Read DataTables parameters
$draw = intval($_POST['draw']);
$row = intval($_POST['start']);
$rowperpage = intval($_POST['length']); // rows per page
$searchValue = $_POST['search']['value'] ?? '';
$columnIndex = $_POST['order'][0]['column'] ?? 5; // Default to created column
$columnName = $_POST['columns'][$columnIndex]['data'] ?? 'updated_at';
$columnSortOrder = $_POST['order'][0]['dir'] ?? 'desc';

// Validate column name to prevent SQL injection
$allowedColumns = ['firstname', 'lastname', 'contact', 'email', 'role', 'updated_at', 'is_active', 'id'];
if (!in_array($columnName, $allowedColumns)) {
    $columnName = 'updated_at';
}

try {
    // Total records
    $stmt = $pdo->query("SELECT COUNT(*) AS allcount FROM users WHERE is_deleted = 0");
    $records = $stmt->fetch();
    $totalRecords = $records['allcount'];

    // Build search conditions
    $searchQuery = "";
    $params = [];

    if ($searchValue != '') {
        $searchQuery = " AND (firstname LIKE :search OR lastname LIKE :search OR role LIKE :search OR email LIKE :search)";
        $params[':search'] = "%$searchValue%";
    }

    // Total with filter
    $stmt = $pdo->prepare("SELECT COUNT(*) AS allcount FROM users WHERE is_deleted = 0 $searchQuery");
    $stmt->execute($params);
    $records = $stmt->fetch();
    $totalRecordwithFilter = $records['allcount'];

    // Fetch records
    $sql = "SELECT id, firstname, lastname, contact, email, role, updated_at, is_active
            FROM users 
            WHERE is_deleted = 0 $searchQuery
            ORDER BY $columnName $columnSortOrder 
            LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($sql);

    // Bind search parameters
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }

    // Bind pagination parameters
    $stmt->bindValue(':limit', $rowperpage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $row, PDO::PARAM_INT);
    $stmt->execute();

    $dataRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the data for display
    foreach ($dataRecords as &$record) {

        $record['fullname'] = $record['lastname'] . ', ' . $record['firstname'];

        $record['contact'];

        $record['email'];

        switch ($record['role']) {
            case 'admin':
                $record['role'] = '<span class="badge badge-pill badge-dark">Admin</span>';
                break;
            case 'staff':
                $record['role'] = '<span class="badge badge-pill badge-dark">Staff</span>';
                break;
            case 'agent':
                $record['role'] = '<span class="badge badge-pill badge-dark">Agent</span>';
                break;
            default:
                $record['role'] = '<span class="badge badge-pill badge-dark">Client</span>';
                break;
        }

        $record['updated_at'] = date('Y-m-d h:i A', strtotime($record['updated_at']));

        // $record['image'] = !empty($record['profile_image']) ? $record['profile_image'] : null;

        $record['status'] = $record['is_active'] == 1
            ? '<span class="badge badge-pill badge-success">Online</span>'
            : '<span class="badge badge-pill badge-danger">Offline</span>';
    }

    // Response
    $response = array(
        "draw" => $draw,
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $dataRecords
    );

    header('Content-Type: application/json');
    echo json_encode($response);
} catch (Exception $e) {
    // Log the error instead of showing it
    error_log("DataTables error: " . $e->getMessage());

    // Return valid JSON error response
    $response = array(
        "draw" => $draw,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => []
    );

    header('Content-Type: application/json');
    echo json_encode($response);
}
