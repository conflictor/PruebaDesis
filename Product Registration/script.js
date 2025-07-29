/**
 * Guarda un nuevo producto en la base de datos a través de una solicitud AJAX.
 * Toma los valores del formulario y los envía al backend para ser insertados.
 * Muestra mensajes de éxito o error según la respuesta del servidor.
 */
function saveProduct() {
    const code = document.getElementById('product_code').value.trim();
    const name = document.getElementById('product_name').value.trim();
    const warehouse = document.getElementById('warehouse').value;
    const branch = document.getElementById('branch').value;
    const currency = document.getElementById('currency').value;
    const price = document.getElementById('price').value.trim();
    const description = document.getElementById('description').value.trim();

    const materials = Array.from(document.querySelectorAll('input[name="materials[]"]:checked'));

    //VALIDACIONES
    // Array para almacenar errores
    let errors = [];

    //Código
    if (code === "") {
        errors.push("El código del producto no puede estar en blanco.");
    } else if (!/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]{5,15}$/.test(code)) {
        errors.push("- El código debe contener letras y números, sin símbolos, entre 5 y 15 caracteres.");
    }

    //Nombre
    if (name === "") {
        errors.push("- El nombre del producto no puede estar en blanco.");
    } else if (name.length < 2 || name.length > 50) {
        errors.push("- El nombre del producto debe tener entre 2 y 50 caracteres.");
    }

    //Bodega
    if (warehouse === "") {
        errors.push("- Debe seleccionar una bodega.");
    }

    //Sucursal
    if (branch === "") {
        errors.push("- Debe seleccionar una sucursal para la bodega seleccionada.");
    }

    //Moneda
    if (currency === "") {
        errors.push("- Debe seleccionar una moneda para el producto.");
    }

    //Precio
    if (price === "") {
        errors.push("El precio del producto no puede estar en blanco.");
    } else if (!/^\d+(\.\d{1,2})?$/.test(price)) {
        errors.push("- El precio del producto debe ser un número positivo con hasta dos decimales.");
    }

    //Materiales
    if (materials.length < 2) {
        errors.push("- Debe seleccionar al menos dos materiales para el producto.");
    }

    //Descripción
    if (description === "") {
        errors.push("La descripción del producto no puede estar en blanco.");
    } else if (description.length < 10 || description.length > 1000) {
        errors.push("- La descripción del producto debe tener entre 10 y 1000 caracteres.");
    }

    if (errors.length > 0) {
        alert(errors.join('\n'));
        return;
    }
    alert("Validación exitosa. Ahora puedes enviar los datos.");

    const form = document.getElementById('productForm');
    const formData = new FormData(form);

    fetch('api/save_product.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                form.reset();
            }
        })
        .catch(error => {
            alert('Ocurrió un error al guardar el producto.');
            console.error(error);
        });
}

/**
 * Carga la lista de bodegas (warehouses) desde el servidor mediante AJAX.
 * Llena el elemento select correspondiente con las opciones recibidas.
 */
function loadWarehouses() {
    fetch('api/get_warehouses.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById('warehouse');
                data.data.forEach(w => {
                    const option = document.createElement('option');
                    option.value = w.id;
                    option.textContent = w.name;
                    select.appendChild(option);
                });
            } else {
                alert('Error al cargar bodegas');
            }
        })
        .catch(error => {
            alert('Error de conexión al cargar bodegas');
            console.error(error);
        });
}

/**
 * Carga la lista de monedas (currencies) disponibles desde el servidor.
 * Inserta las opciones en el campo select de monedas del formulario.
 */
function loadCurrencies() {
    fetch('api/get_currencies.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById('currency');
                data.data.forEach(c => {
                    const option = document.createElement('option');
                    option.value = c.id;
                    option.textContent = c.name;
                    select.appendChild(option);
                });
            } else {
                alert('Error al cargar monedas');
            }
        })
        .catch(error => {
            alert('Error de conexión al cargar monedas');
            console.error(error);
        });
}

/**
 * Carga las sucursales (branches) asociadas a una bodega específica.
 *
 * @param {number} warehouseId - El ID de la bodega seleccionada.
 * Llena el campo select de sucursales basado en la bodega elegida.
 */
function loadBranches(warehouseId) {
    const branchSelect = document.getElementById('branch');
    branchSelect.innerHTML = '<option value="">Seleccione una sucursal</option>';

    if (!warehouseId) return;

    fetch(`api/get_branches.php?warehouse_id=${warehouseId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                data.data.forEach(b => {
                    const option = document.createElement('option');
                    option.value = b.id;
                    option.textContent = b.name;
                    branchSelect.appendChild(option);
                });
            } else {
                alert('Error al cargar sucursales');
            }
        })
        .catch(error => {
            alert('Error de conexión al cargar sucursales');
            console.error(error);
        });
}



window.addEventListener('DOMContentLoaded', () => {
    loadWarehouses();
    loadCurrencies();

    document.getElementById('warehouse').addEventListener('change', (e) => {
        loadBranches(e.target.value);
    });
});

