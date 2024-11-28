<?php
session_start();

// Simulación de roles (para pruebas)
// $_SESSION['role'] = 'admin'; // Descomenta esta línea para probar con admin
// $_SESSION['role'] = 'user';  // Descomenta esta línea para probar con user

// Obtener el archivo solicitado
$requestUri = $_SERVER['REQUEST_URI'];
$fileName = basename($requestUri);

// Configurar permisos para cada archivo
$permissions = [
    'users.json' => 'user',  // Todos los usuarios pueden acceder
    'admin.json' => 'admin', // Solo administradores
];

// Verificar si el archivo solicitado tiene permisos definidos
if (!array_key_exists($fileName, $permissions)) {
    http_response_code(404);
    echo "Archivo no encontrado.";
    exit();
}

// Verificar permisos del usuario
$requiredRole = $permissions[$fileName];
$userRole = $_SESSION['role'] ?? null;

if ($requiredRole === 'admin' && $userRole !== 'admin') {
    http_response_code(403);
    echo "Acceso denegado. Necesitas permisos de administrador.";
    exit();
}

// Mostrar el contenido del archivo
$filePath = __DIR__ . '/' . $fileName;
if (file_exists($filePath)) {
    header('Content-Type: application/json');
    readfile($filePath);
} else {
    http_response_code(404);
    echo "Archivo no encontrado.";
}
?>
