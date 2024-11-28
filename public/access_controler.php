<?php
session_start();

// Verifica si el usuario tiene el rol de administrador
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["error" => "Acceso denegado. Solo administradores."]);
    exit();
}

// Ruta al archivo JSON
$filePath = __DIR__ . '/admin.json';

// Verifica si el archivo existe y lo devuelve
if (file_exists($filePath)) {
    header('Content-Type: application/json');
    readfile($filePath);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Archivo no encontrado."]);
}
?>
