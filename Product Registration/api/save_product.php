<?php
header('Content-Type: application/json');

require '../db/connection.php';

// Validación de campos obligatorios
if (
    empty($_POST['product_code']) ||
    empty($_POST['product_name']) ||
    empty($_POST['warehouse']) ||
    empty($_POST['branch']) ||
    empty($_POST['currency']) ||
    empty($_POST['price']) ||
    empty($_POST['description']) ||
    empty($_POST['materials'])
) {
    echo json_encode(['success' => false, 'message' => 'Faltan campos obligatorios.']);
    exit;
}

$code = $_POST['product_code'];
$name = $_POST['product_name'];
$warehouse = $_POST['warehouse'];
$branch = $_POST['branch'];
$currency = $_POST['currency'];
$price = $_POST['price'];
$description = $_POST['description'];
$materials = $_POST['materials'];

// Verificar código
$stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE product_code = ?");
$stmt->execute([$code]);
if ($stmt->fetchColumn() > 0) {
    echo json_encode(['success' => false, 'message' => 'El código del producto ya está registrado.']);
    exit;
}

// Guardar producto
try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO products 
        (product_code, product_name, warehouse_id, branch_id, currency_id, price, description)
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $code, $name, $warehouse, $branch, $currency, $price, $description
    ]);

    $product_id = $pdo->lastInsertId();

    // Insertar materiales asociados
    $materialStmt = $pdo->prepare("INSERT INTO product_materials (product_id, material_name) VALUES (?, ?)");
    foreach ($materials as $material) {
        $materialStmt->execute([$product_id, $material]);
    }

    $pdo->commit();

    echo json_encode(['success' => true, 'message' => 'Producto guardado exitosamente.']);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Error al guardar: ' . $e->getMessage()]);
}
