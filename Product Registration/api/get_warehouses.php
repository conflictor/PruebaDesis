<?php
/**
 * Devuelve una lista de bodegas (warehouses) en formato JSON.
 * Realiza una consulta a la tabla `warehouses` y devuelve los resultados como un arreglo JSON.
 */
header('Content-Type: application/json');

require '../db/connection.php';

try {
    $stmt = $pdo->query("SELECT id, name FROM warehouses ORDER BY name");
    $warehouses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'data' => $warehouses]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al cargar bodegas: ' . $e->getMessage()]);
}
