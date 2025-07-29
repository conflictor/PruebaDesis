<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Desis Formulario de Producto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Formulario de Producto</h1>

<form id="productForm">

    <div class="row">
        <div class="col-50">
            <label for="product_code">Código</label>
            <input type="text" id="product_code" name="product_code">
        </div>
        <div class="col-50">
            <label for="product_name">Nombre</label>
            <input type="text" id="product_name" name="product_name">
        </div>
    </div>

    <div class="row">
        <div class="col-50">
            <label for="warehouse">Bodega</label>
            <select id="warehouse" name="warehouse">
                <option value=""></option>
            </select>
        </div>
        <div class="col-50">
            <label for="branch">Sucursal</label>
            <select id="branch" name="branch">
                <option value=""></option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-50">
            <label for="currency">Moneda:</label>
            <select id="currency" name="currency">
                <option value=""></option>
            </select>
        </div>
        <div class="col-50">
            <label for="price">Precio:</label>
            <input type="text" id="price" name="price">
        </div>
    </div>
    <fieldset>
        <legend>Material del Producto:</legend>
    </fieldset>
    <div class="row">
        <div class="col-20"><label><input type="checkbox" name="materials[]" value="Plástico"> Plástico</label></div>
        <div class="col-20"><label><input type="checkbox" name="materials[]" value="Metal"> Metal</label></div>
        <div class="col-20"><label><input type="checkbox" name="materials[]" value="Madera"> Madera</label></div>
        <div class="col-20"><label><input type="checkbox" name="materials[]" value="Vidrio"> Vidrio</label></div>
        <div class="col-20"><label><input type="checkbox" name="materials[]" value="Textil"> Textil</label></div>
    </div>
    <br>

    <div class="row col-100">
        <label for="description">Descripción</label>
        <textarea id="description" name="description" rows="4"></textarea>
    </div>

    <button type="button" onclick="saveProduct()">Guardar Producto</button>

</form>


<script src="script.js"></script>
</body>
</html>
