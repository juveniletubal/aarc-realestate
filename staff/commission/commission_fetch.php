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
$allowedColumns = ['firstname', 'lastname', 'role', 'percent', 'term', 'updated_at', 'id'];
if (!in_array($columnName, $allowedColumns)) {
    $columnName = 'updated_at';
}

try {
    // Total records
    $stmt = $pdo->query("SELECT COUNT(*) AS allcount FROM commissions WHERE is_deleted = 0");
    $records = $stmt->fetch();
    $totalRecords = $records['allcount'];

    // Build search conditions
    $searchQuery = "";
    $params = [];

    if ($searchValue != '') {
        $searchQuery = " AND (firstname LIKE :search OR lastname LIKE :search OR role LIKE :search OR percent LIKE :search)";
        $params[':search'] = "%$searchValue%";
    }

    // Total with filter
    $stmt = $pdo->prepare("SELECT COUNT(*) AS allcount FROM commissions WHERE is_deleted = 0 $searchQuery");
    $stmt->execute($params);
    $records = $stmt->fetch();
    $totalRecordwithFilter = $records['allcount'];

    // Fetch records
    $sql = "
        SELECT 
            com.id,
            com.com_ref,
            GROUP_CONCAT(CONCAT(u.firstname, ' ', u.lastname) SEPARATOR ' / ') AS names,
            GROUP_CONCAT(CONCAT(com.role, ' (', com.percent, '%)') SEPARATOR ' / ') AS roles,
            MAX(com.term) AS term,
            com.updated_at
        FROM commissions com
        JOIN users u ON com.user_id = u.id 
        WHERE com.is_deleted = 0
        AND u.is_deleted = 0
        $searchQuery
        GROUP BY com.com_ref
        ORDER BY $columnName $columnSortOrder 
        LIMIT :limit OFFSET :offset
    ";

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

        // Capitalize each name properly (Firstname Lastname)
        $names = explode(' / ', $record['names']);
        $roles = explode(' / ', $record['roles']);

        $formattedNames = [];
        $formattedRoles = [];

        foreach ($names as $i => $name) {
            $role = $roles[$i] ?? '';
            // Extract short role label (Dir, Man, Dow)
            $short = '';
            if (stripos($role, 'director') !== false) $short = 'Dir';
            elseif (stripos($role, 'manager') !== false) $short = 'Man';
            elseif (stripos($role, 'downline') !== false) $short = 'Dow';

            // Capitalize name
            $name = ucwords(strtolower($name));

            $formattedNames[] = trim("$name ($short)");
            $formattedRoles[] = ucwords(strtolower($role));
        }

        $record['names'] = implode(' / ', $formattedNames);
        $record['roles'] = implode(' / ', $formattedRoles);
        $record['updated_at'] = date('Y-m-d h:i A', strtotime($record['updated_at']));

        switch ($record['term']) {
            case 'spot_cash':
                $record['term'] = 'Spot Cash';
                break;
            case '3':
                $record['term'] = '3 Months';
                break;
            case '6':
                $record['term'] = '6 Months';
                break;
            case '12':
                $record['term'] = '12 Months (1 Year)';
                break;
            case '24':
                $record['term'] = '24 Months (2 Year)';
                break;
            case '36':
                $record['term'] = '36 Months (3 Year)';
                break;
            case '48':
                $record['term'] = '48 Months (4 Year)';
                break;
            case '60':
                $record['term'] = '60 Months (5 Year)';
                break;
            case '72':
                $record['term'] = '72 Months (6 Year)';
                break;
            default:
                $record['term'] = 'Unknown';
                break;
        }
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
