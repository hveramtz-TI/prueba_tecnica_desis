// Lógica principal para el registro de productos

document.addEventListener('DOMContentLoaded', function() {
    cargarOpciones();
    document.getElementById('bodega').addEventListener('change', function() {
        cargarSelect('sucursal', 'api/listar_sucursales.php?bodega_id=' + this.value, true);
    });
    document.getElementById('guardar').addEventListener('click', validarFormulario);
});

function cargarOpciones() {
    cargarSelect('bodega', 'api/listar_bodegas.php', true);
    cargarSelect('sucursal', '', true, true); // vacío al inicio
    cargarSelect('moneda', 'api/listar_monedas.php', true);
}

function cargarSelect(id, url, blanco = false, vacio = false) {
    const select = document.getElementById(id);
    select.innerHTML = '';
    if (blanco) {
        const opt = document.createElement('option');
        opt.value = '';
        opt.textContent = '';
        select.appendChild(opt);
    }
    if (vacio || !url) return;
    fetch(url)
        .then(res => res.json())
        .then(data => {
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.nombre;
                select.appendChild(option);
            });
        });
}

async function validarFormulario() {
    const codigo = document.getElementById('codigo').value.trim();
    const nombre = document.getElementById('nombre').value.trim();
    const bodega = document.getElementById('bodega').value;
    const sucursal = document.getElementById('sucursal').value;
    const moneda = document.getElementById('moneda').value;
    const precio = document.getElementById('precio').value.trim();
    const materiales = Array.from(document.querySelectorAll('input[name="material[]"]:checked'));
    const descripcion = document.getElementById('descripcion').value.trim();

    // 1. Código del Producto
    if (!codigo) {
        alert("El código del producto no puede estar en blanco.");
        return;
    }
    if (codigo.length < 5 || codigo.length > 15) {
        alert("El código del producto debe tener entre 5 y 15 caracteres.");
        return;
    }
    // Debe contener al menos una letra y un número, solo letras y números
    if (!/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{5,15}$/.test(codigo)) {
        alert("El código del producto debe contener letras y números");
        return;
    }
    // Unicidad
    const unico = await verificarCodigoUnico(codigo);
    if (!unico) {
        alert("El código del producto ya está registrado.");
        return;
    }

    // 2. Nombre del Producto
    if (!nombre) {
        alert("El nombre del producto no puede estar en blanco.");
        return;
    }
    if (nombre.length < 2 || nombre.length > 50) {
        alert("El nombre del producto debe tener entre 2 y 50 caracteres.");
        return;
    }

    // 3. Precio del Producto
    if (!precio) {
        alert("El precio del producto no puede estar en blanco.");
        return;
    }
    if (!/^\d+(\.\d{1,2})?$/.test(precio) || parseFloat(precio) <= 0) {
        alert("El precio del producto debe ser un número positivo con hasta dos decimales.");
        return;
    }

    // 4. Material del Producto
    if (materiales.length < 2) {
        alert("Debe seleccionar al menos dos materiales para el producto.");
        return;
    }

    // 5. Bodega
    if (!bodega) {
        alert("Debe seleccionar una bodega.");
        return;
    }

    // 6. Sucursal
    if (!sucursal) {
        alert("Debe seleccionar una sucursal para la bodega seleccionada.");
        return;
    }

    // 7. Moneda
    if (!moneda) {
        alert("Debe seleccionar una moneda para el producto.");
        return;
    }

    // 8. Descripción del Producto
    if (!descripcion) {
        alert("La descripción del producto no puede estar en blanco.");
        return;
    }
    if (descripcion.length < 10 || descripcion.length > 1000) {
        alert("La descripción del producto debe tener entre 10 y 1000 caracteres.");
        return;
    }

    guardarProducto();
}

async function verificarCodigoUnico(codigo) {
    // Llama a un endpoint PHP que verifique si el código existe
    const res = await fetch('api/verificar_codigo.php?codigo=' + encodeURIComponent(codigo));
    const data = await res.json();
    return data.unico;
}

function guardarProducto() {
    const form = document.getElementById('formProducto');
    const formData = new FormData(form);
    fetch('api/guardar_producto.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.mensaje);
        if(data.exito) form.reset();
        cargarOpciones(); // recargar selects
    });
}
