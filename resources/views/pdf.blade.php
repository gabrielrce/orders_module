<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
            color: #aaa;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        p {
            font-size: 14px;
            line-height: 1.5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header>
        <h1 style="margin: 0;">Orden #{{ $order->id }}</h1>
        <p style="text-align: left;margin: 0;">Cliente: {{ $order->customer->name }}</p>
    </header>

    <main>
        <table class="table">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Dirección de envío</th>
                    <th>SubTotal</th> 
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderProducts as $orderProduct)
                    <tr>
                        <td>{{ $orderProduct->product_id }}</td>
                        <td>{{ $order->shippingAddress->short_name }}</td>
                        <td>${{ $orderProduct->subtotal }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-end"><strong>Total:</strong></td>
                    <td>${{ $order->total }}</td>
                </tr>
            </tfoot>
        </table>
    </main>
    
    <footer>
        <p>&copy; {{ date('Y') }} Tu Empresa. Todos los derechos reservados.</p>
    </footer>
</body>
</html>