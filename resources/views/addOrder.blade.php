<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Módulo de Pedidos</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    </head>
    <body style="background-color: #30495B;">
        <!-- Sección de Inofrmacion -->
        <div class="container col-sm-12 card text-bg-secondary mb-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Formulario de Pedido</h1>
                <a href="{{ route('orders') }}" class="btn btn-success">Ir a Órdenes</a>
            </div>
            <form id="orderForm">
                <!-- Fila para la selección de empresa y dirección de envío -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="empresa" class="form-label">Empresa</label>
                        <select class="form-select" id="empresa" onchange="handleSelectChange(this)" required>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="direccionEnvio" class="form-label">Dirección de Envío</label>
                        <select class="form-select" id="direccionEnvio" required>
                            @foreach ($customerShippingAddresses as $shippingAddress)
                                <option value="{{ $shippingAddress->id }}">{{ $shippingAddress->short_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
        
                <!-- Fila para productos y cantidad -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="productos" class="form-label">Productos</label>
                        <select class="form-select" id="productos" required onchange="updatePrice()">
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="productos" class="form-label">Precio por unidad</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="productPrice" value="{{ $products[0]->price }}" readonly disabled>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-dark" id="decreaseButton" onclick="updateDisplay(false)">-</button>
                                <span id="numberDisplay" class="mx-3">1</span>
                                <button type="button" class="btn btn-dark" id="increaseButton" onclick="updateDisplay(true)">+</button>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Fila para el botón de añadir producto -->
                <div class="d-flex justify-content-end mt-3 mb-3">
                    <button type="button" class="btn btn-primary" onclick="addProduct()">Añadir Producto</button>
                </div>
            </form>
        </div>
        

        <!-- Sección de Orden -->
        <div class="container col-sm-12 card text-bg-secondary mb-3">
            <div class="d-flex align-items-center mb-4">
                <h2 class="me-3">Órden</h2>
                <button type="button" class="btn btn-success" onclick="addOrder()"><i class="fa-solid fa-download"></i></button>
            </div>
            <table class="table table-striped table-secondary">
                <thead>
                    <tr>
                        <th>ID del Producto</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="orderTableBody">
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td id="totalAmount">0</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
    </body>
    
</html>