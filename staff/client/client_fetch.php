<?php
error_reporting(0);
ini_set('display_errors', 0);

require_once '../../classes/Database.php';

// Read DataTables parameters
$draw = intval($_POST['draw']);
$row = intval($_POST['start']);
$rowperpage = intval($_POST['length']);
$searchValue = $_POST['search']['value'] ?? '';
$columnIndex = $_POST['order'][0]['column'] ?? 7;
$columnName = $_POST['columns'][$columnIndex]['data'] ?? 'updated_at';
$columnSortOrder = $_POST['order'][0]['dir'] ?? 'desc';

// Allowed columns (must match alias in SELECT)
$allowedColumns = [
    'firstname',
    'lastname',
    'contact',
    'property_id',
    'total_price',
    'balance',
    'payment_terms',
    'agent_name',
    'updated_at',
    'clientid'
];
if (!in_array($columnName, $allowedColumns)) {
    $columnName = 'updated_at';
}

try {
    // Total records
    $stmt = $pdo->query("
        SELECT COUNT(*) AS allcount 
        FROM clients c
        JOIN users u ON c.user_id = u.id
        WHERE u.is_deleted = 0 AND u.role = 'client'
    ");
    $records = $stmt->fetch();
    $totalRecords = $records['allcount'];

    // Search filter
    $searchQuery = "";
    $params = [];
    if ($searchValue != '') {
        $searchQuery = " AND (u.firstname LIKE :search 
                           OR u.lastname LIKE :search 
                           OR u.contact LIKE :search 
                           OR p.title LIKE :search 
                           OR a.firstname LIKE :search 
                           OR a.lastname LIKE :search)";
        $params[':search'] = "%$searchValue%";
    }

    // Total with filter
    $stmt = $pdo->prepare("
        SELECT COUNT(*) AS allcount
        FROM clients c
        JOIN users u ON c.user_id = u.id
        LEFT JOIN properties p ON c.property_id = p.id
        LEFT JOIN users a ON c.assigned_agent = a.id
        WHERE u.is_deleted = 0 AND u.role = 'client'
        $searchQuery
    ");
    $stmt->execute($params);
    $records = $stmt->fetch();
    $totalRecordwithFilter = $records['allcount'];

    // Fetch records
    $sql = "
        SELECT 
            c.id,
            u.firstname,
            u.lastname,
            u.contact,
            u.role AS client_role,
            c.property_id,
            p.title AS property_title,
            c.total_price,
            c.balance,
            c.payment_terms,
            c.assigned_agent,
            CONCAT(a.firstname, ' ', a.lastname) AS agent_name,
            a.role AS agent_role,
            c.updated_at
        FROM clients c
        JOIN users u ON c.user_id = u.id AND u.is_deleted = 0 AND u.role = 'client'
        LEFT JOIN properties p ON c.property_id = p.id
        LEFT JOIN users a ON c.assigned_agent = a.id AND a.is_deleted = 0 AND (a.role = 'agent' OR a.role = 'staff')
        WHERE 1=1 $searchQuery
        ORDER BY $columnName $columnSortOrder
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $pdo->prepare($sql);

    // Bind search parameters
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }

    // Bind pagination
    $stmt->bindValue(':limit', $rowperpage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $row, PDO::PARAM_INT);
    $stmt->execute();

    $clientRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the data
    foreach ($clientRecords as &$record) {
        $record['fullname'] = $record['firstname'] . ' ' . $record['lastname'];

        // Format price and balance
        $record['total_price'] = '₱' . number_format($record['total_price'], 2);
        $record['balance'] = '₱' . number_format($record['balance'], 2);

        // Format date
        $record['updated_at'] = date('Y-m-d h:i A', strtotime($record['updated_at']));

        // Property title fallback
        if (empty($record['property_title'])) {
            $record['property_title'] = 'N/A';
        }

        // Agent name fallback
        if (empty($record['agent_name'])) {
            $record['agent_name'] = 'Unassigned';
        }

        switch ($record['payment_terms']) {
            case 'monthly':
                $record['payment_terms'] = 'Monthly';
                break;
            case 'quarterly':
                $record['payment_terms'] = 'Quarterly';
                break;
            default:
                $record['payment_terms'] = 'Spot Cash';
                break;
        }
    }

    // Response
    $response = [
        "draw" => $draw,
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $clientRecords
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
} catch (Exception $e) {
    error_log("DataTables error: " . $e->getMessage());

    $response = [
        "draw" => $draw,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => []
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
