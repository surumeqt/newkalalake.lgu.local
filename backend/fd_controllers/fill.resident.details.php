<?php
header('Content-Type: application/json');
require_once '../models/resident.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = $_POST['name'];
    
    $model = new ResidentModel();
    $resident = $model->findByFullName($name);

    if ($resident) {
        echo json_encode([
            'found' => true,
            'age' => $resident['age'],
            'address' => $resident['address'],
            'birthday' => $resident['birthday']
        ]);
    } else {
        echo json_encode(['found' => false]);
    }
}
