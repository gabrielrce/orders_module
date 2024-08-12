<?php

namespace App\Http\Controllers;

use App\Models\OrderProducts;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function addOrder(Request $request)
    {
        $status = 200;

        $input = $request->validate([
            'customer_id' => 'required|integer',
            'send_address' => 'required|string',
            'products' => 'required|array',
        ]);

        $order = new Orders();
        $order->customer_id = $input['customer_id'];
        $order->customer_shipping_address_id = $input['send_address'];
        $order->total = $request->total;
        $order->save();

        foreach ($request->products as $product) {
            $orderProduct = new OrderProducts();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $product['productId'];
            $orderProduct->quantity = $product['quantity'];
            $orderProduct->subtotal = $product['subtotal'];
            $orderProduct->save();
        }

        return response()->json([
            'message' => 'success',
            'status' => $status,
        ], $status);
    }

    public function getAddresses($id)
    {
        $addresses = DB::table('CustomerShippingAddresses')->where('customer_id', $id)->get();
        return response()->json($addresses);
    }

    public function generateXMLReport(array $data, \SimpleXMLElement $xml)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (isset($value['@attributes'])) {
                    $subnode = $xml->addChild($key);
                    foreach ($value['@attributes'] as $attrKey => $attrValue) {
                        $subnode->addAttribute($attrKey, $attrValue);
                    }
                    unset($value['@attributes']); // Eliminar atributos para no añadirlos como hijos
                } else {
                    $subnode = $xml->addChild($key);
                }
                self::generateXMLReport($value, $subnode);
            } else {
                $value = htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');
                $xml->addChild($key, $value);
            }
        }
        return $xml;
    }

    public function downloadXML($id)
    {
        $order = Orders::with(['customer', 'shippingAddress', 'orderProducts'])->where('id', $id)->first();

        $xmlFiles = [];

        foreach ($order->orderProducts as $index => $product) {
            $product = Products::find($product->product_id);
            $xml = [
                'Customer' => [
                    'Number' => $order->customer->id,
                    'Name' => $order->customer->name,
                    'Addresses' => [
                        'Address' => [
                            '@attributes' => [
                                'Code' => $order->shippingAddress->id,
                                'Description' => $order->shippingAddress->short_name,
                                'PostalCode' => $order->shippingAddress->postal_code,
                                'Address1' => $order->shippingAddress->address,
                            ],
                        ],
                    ],
                ],
                'Article' => [
                    'Number' => $product->id,
                    'Description' => $product->description,
                    'SalesPrice' => $product->price,
                ],
                'Order' => [
                    'Transaction' => '0',
                    'OrderNumber' => $order->id,
                    'PartNumber' => $index + 1,
                    'OrderedQuantity' => $product->quantity,
                    'DueDate' => $order->created_at,
                ],
            ];

            $simpleXMLElement = new \SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\" ?> <DRDataTransfer></DRDataTransfer>");
            $xmlFiles[] = [
                'filename' => 'order_' . $product->id . '.xml', // Nombre del archivo
                'content' => $this->generateXMLReport($xml, $simpleXMLElement)->asXML(),
            ];
        }

        return response()->json($xmlFiles);
    }

    public function generatePDF($id)
    {
        $order = Orders::with(['customer', 'shippingAddress', 'orderProducts'])->where('id', $id)->first();
        $pdf = app('dompdf.wrapper')->loadView('pdf', compact('order'));

        return $pdf->download('order_' . $id . '.pdf');
    }

    public function softDelete($id)
    {
        $order = Orders::find($id);
        $order->active = 0;
        $order->save();

        return response()->json([
            'message' => 'success',
            'status' => 200,
        ], 200);
    }
}
