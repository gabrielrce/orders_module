let number = 1;

let order = { products: [] };

function updatePrice() {
    const selectedOption = $('#productos option:selected');
    const price = selectedOption.data('price');
    $('#productPrice').val(price.toFixed(2));
}

function handleSelectChange(_data) {
    $.ajax({
        url: '/api/customer/getAddresses/' + $(_data).val(),
        method: 'GET',
        success: function(data) {
            $('#direccionEnvio').empty();

            data.forEach(function(address) {
                $('#direccionEnvio').append('<option value="' + address.id + '">' + address.short_name + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function updateDisplay(increment) {
    if(number > 0) {
        if (increment) {
            number++;
        } else {
            if (number > 1) number--;
        }
        $('#numberDisplay').text(number);
    }
}

function addProduct() {
    order.customer_id = $('#empresa').val();
    order.send_address = $('#direccionEnvio').val();

    const productId = $('#productos').val();
    const productName = $('#productos option:selected').text();
    const quantity = number;

    const productOption = $('#productos option[value="' + productId + '"]');
    const pricePerUnit = productOption.data('price');

    const subtotal = quantity * pricePerUnit;
    const existingProduct = order.products.find(product => product.productId == productId);

    if (existingProduct) {
        existingProduct.quantity += quantity;
        existingProduct.subtotal += subtotal;
    } else {
        order.products.push({
            productId: productId,
            productName: productName,
            quantity: quantity,
            subtotal: subtotal
        });
    }
    displayOrder();
}

function displayOrder() {
    const tableBody = document.getElementById('orderTableBody');
    tableBody.innerHTML = '';

    let total = 0;

    order.products.sort((a, b) => a.productId - b.productId);
    order.products.forEach((product, index) => {
        const productOption = $('#productos option[value="' + product.productId + '"]');
        const pricePerUnit = productOption.data('price');

        const subtotal = product.quantity * pricePerUnit;
        total += subtotal;

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${product.productId}</td>
            <td>${product.productName}</td>
            <td>${product.quantity}</td>
            <td>${subtotal.toFixed(2)}</td> <!-- Mostrar subtotal -->
            <td>
                <button class="btn btn-danger btn-sm" onclick="removeProduct(${index})"><i class="fa-solid fa-trash"></i></button>
            </td>
        `;
        tableBody.appendChild(row);
    });

    $('#totalAmount').text(total.toFixed(2));
}

function removeProduct(index) {
    order.products.splice(index, 1);
    displayOrder();
}

function addOrder() {
    if(order.products.length) {
        order.total = $('#totalAmount').text(); 
        $.ajax({
            url: '/api/customer/addOrder',
            method: 'POST',
            data: order,
            success: function(data) {
                console.log(data);
            },
            error: function(xhr, status, error) {
                alert('Error:', error);
            }
        });
    } else {
        alert("La orden está vacía.");
    }
}