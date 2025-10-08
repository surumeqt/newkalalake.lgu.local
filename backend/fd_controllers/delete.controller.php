<?php
require_once __DIR__ . '/../models/resident.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $resident_id = $_POST['resident_id'];

    $model = new ResidentModel();
    $deleted = $model->deleteResident($resident_id);

    if ($deleted) {
        header("Location: /frontdesk/fd_app.php?status=deleted");
        exit();
    } else {
        echo "Failed to delete resident.";
    }
}
