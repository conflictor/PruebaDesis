<?php
/**
 * Devuelve las sucursales (branches) asociadas a una bodega específica.
 * Requiere un parámetro GET `warehouse_id`.
 */
header('Content-Type: application/json');
require '../db/connection.php';

// VALIDACIÓN SI NO EXISTE BODEGA
if (!isset($_GET['warehouse_id'])) {
    echo json_encode(['success' => false, 'message' => 'ID de bodega no proporcionado.']);
    exit;
}

$warehouse_id = intval($_GET['warehouse_id']);

try {
    $stmt = $pdo->prepare("SELECT id, name FROM branches WHERE warehouse_id = ? ORDER BY name");
    $stmt->execute([$warehouse_id]);
    $branches = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'data' => $branches]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al cargar sucursales: ' . $e->getMessage()]);
}
