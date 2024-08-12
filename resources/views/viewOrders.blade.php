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
        <div class="container col-sm-12 card text-bg-secondary mb-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Listado de Pedidos</h1>
                <a href="{{ route('addOrder') }}" class="btn btn-success">Crear nueva órden</a>
            </div>
            <table class="table table-striped table-secondary">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Dirección de envío</th>
                        <th>Total</th> 
                        <th></th> 
                    </tr>
                </thead>
                <tbody id="orderTableBody">
                    @foreach ($orderProducts as $order)
                    <tr>
                        <td>{{ $order->customer->name }}</td>
                        <td>{{ $order->shippingAddress->short_name }}</td>
                        <td>{{ $order->total }}</td>
                        <td>
                            <button type="button" onclick="downloadXML({{ $order->id }})" class="btn btn-success"><i class="fa-solid fa-code"></i></button>
                            <button type="button" onclick="downloadPDF({{ $order->id }})" class="btn btn-primary"><i class="fa-solid fa-file-pdf"></i></button>
                            <button type="button" onclick="deleteOrder({{ $order->id }})" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <script src="{{ asset('js/app2.js') }}"></script>
    </body>
    
</html>