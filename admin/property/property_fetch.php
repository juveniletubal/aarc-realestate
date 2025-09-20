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
$columnName = $_POST['columns'][$columnIndex]['data'] ?? 'created';
$columnSortOrder = $_POST['order'][0]['dir'] ?? 'desc';

// Validate column name to prevent SQL injection
$allowedColumns = ['title', 'lot_area', 'price', 'location', 'property_type', 'created', 'id'];
if (!in_array($columnName, $allowedColumns)) {
    $columnName = 'created';
}

try {
    // Total records
    $stmt = $pdo->query("SELECT COUNT(*) AS allcount FROM properties WHERE is_deleted = 0");
    $records = $stmt->fetch();
    $totalRecords = $records['allcount'];

    // Build search conditions
    $searchQuery = "";
    $params = [];

    if ($searchValue != '') {
        $searchQuery = " AND (title LIKE :search OR location LIKE :search OR property_type LIKE :search)";
        $params[':search'] = "%$searchValue%";
    }

    // Total with filter
    $stmt = $pdo->prepare("SELECT COUNT(*) AS allcount FROM properties WHERE is_deleted = 0 $searchQuery");
    $stmt->execute($params);
    $records = $stmt->fetch();
    $totalRecordwithFilter = $records['allcount'];

    // Fetch records
    $sql = "SELECT id, title, description, lot_area, price, location, status, property_type, created, images 
            FROM properties 
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

    $propertyRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the data for display
    foreach ($propertyRecords as &$record) {
        // Format price
        $record['price'] = number_format($record['price'], 2);

        // Format date
        $record['created'] = date('Y-m-d h:i A', strtotime($record['created']));

        // Format lot area
        if (empty($record['lot_area'])) {
            $record['lot_area'] = 'N/A';
        } else {
            $record['lot_area'] .= ' sqm';
        }

        // Ensure location is not empty
        if (empty($record['location'])) {
            $record['location'] = 'N/A';
        }

        // Convert images from comma-separated to array
        $record['images'] = !empty($record['images']) ? explode(',', $record['images']) : [];

        // Format status with badge
        switch ($record['status']) {
            case 'available':
                $record['status'] = '<span class="badge badge-pill badge-success">Available</span>';
                break;
            case 'reserved':
                $record['status'] = '<span class="badge badge-pill badge-warning">Reserved</span>';
                break;
            case 'sold':
                $record['status'] = '<span class="badge badge-pill badge-danger">Sold</span>';
                break;
            default:
                $record['status'] = '<span class="badge badge-pill badge-secondary">Unknown</span>';
                break;
        }
    }

    // Response
    $response = array(
        "draw" => $draw,
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $propertyRecords
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
