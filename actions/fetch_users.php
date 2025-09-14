<?php
require "../classes/Database.php";

// Read DataTables parameters
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length'];
$columnIndex = $_POST['order'][0]['column'];
$columnName = $_POST['columns'][$columnIndex]['data'];
$columnSortOrder = $_POST['order'][0]['dir'];
$searchValue = $_POST['search']['value'];

$table = "users_tbl";

## Total records
$stmt = $pdo->query("SELECT COUNT(*) AS cnt FROM $table");
$totalRecords = $stmt->fetch()['cnt'];

## Filtered records
$searchQuery = "";
$params = [];

if ($searchValue != '') {
    $searchQuery = " WHERE (name LIKE :name OR email LIKE :email OR role LIKE :role)";
    $params = [
        ':name' => "%$searchValue%",
        ':email' => "%$searchValue%",
        ':role' => "%$searchValue%"
    ];
}

$stmt = $pdo->prepare("SELECT COUNT(*) AS cnt FROM $table $searchQuery");
$stmt->execute($params);
$totalRecordwithFilter = $stmt->fetch()['cnt'];

## Fetch records
$sql = "SELECT id, name, email, role, status, created 
        FROM $table 
        $searchQuery 
        ORDER BY $columnName $columnSortOrder 
        LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val);
}
$stmt->bindValue(':limit', (int)$rowperpage, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$row, PDO::PARAM_INT);
$stmt->execute();

$data = [];
while ($row = $stmt->fetch()) {
    $statusBadge = $row['status'] == 0
        ? '<span class="badge badge-success">Active</span>'
        : '<span class="badge badge-warning">Pending</span>';

    $actions = '
        <div class="form-button-action">
            <button type="button" class="btn btn-link btn-primary btn-lg editBtn" data-id="' . $row['id'] . '">
                <i class="fa fa-edit"></i>
            </button>
            <button type="button" class="btn btn-link btn-danger deleteBtn" data-id="' . $row['id'] . '">
                <i class="fa fa-times"></i>
            </button>
        </div>';

    $data[] = [
        "id" => $row['id'],
        "name" => htmlspecialchars($row['name']),
        "email" => htmlspecialchars($row['email']),
        "role" => htmlspecialchars($row['role']),
        "status" => $statusBadge,
        "created" => $row['created'],
        "action" => $actions
    ];
}

## Response
$response = [
    "draw" => intval($draw),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalRecordwithFilter,
    "data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);
