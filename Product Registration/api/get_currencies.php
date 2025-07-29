<?php
header('Content-Type: application/json');
require '../db/connection.php';

try {
    $stmt = $pdo->query("SELECT id, name FROM currencies ORDER BY name");
    $currencies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'data' => $currencies]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al cargar monedas: ' . $e->getMessage()]);
}
