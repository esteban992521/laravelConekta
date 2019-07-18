<?php

namespace App\Http\Controllers;

use Conekta\Order;
use Conekta\Conekta;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function payment(Request $request){
        Conekta::setApiKey(config('conekta.secret_key'));
        Conekta::setApiVersion("2.0.0");
        $tokencard = $request->conektaTokenId;
        try {

            $items = [
                ['name' => 'Product 1', 'unit_price' => number_format(300.00,2, '', ''), 'quantity' => 2,],
                ['name' => 'Product 2', 'unit_price' => number_format(999.99, 2, '', ''), 'quantity' => 1,],
            ];
            $customer = [
                'name'  => 'Hugo Esteban Obregon Ramirez',
                'email' => 'esteban992521@gmail.com',
                'phone' => '553141743802',
            ];
            /** Solo requerido para productos fisicos */
            $contact_ship = [
                'address' => [
                    'street1'     => 'street name, number' ,
                    'postal_code' => '28860',
                    'country'     => 'MX',
                ],
            ];
            $shipping = [
                [
                    'amount' => 100, 
                    'carrier' => 'FEDEX',
                ],
            ];
            /*********************************************/
            $metadata = [
                'reference' => '12345678',
                'more_info' => 'esteban992521',
            ];
            $info_charge = [
                [
                    'payment_method' => [ 
                        'type' => 'card',
                        'token_id' => $tokencard,
                    ],
                ],
            ];

            $info_order = [
                'line_items'        => $items,
                //'shipping_lines'    => $shipping,
                'currency'          => 'MXN',
                'customer_info'     => $customer,
                //'shipping_contact'  => $contact_ship,
                'metadata'          => $metadata,
                'charges'           => $info_charge,
            ];

            $order = Order::create($info_order);
            dd($order);
        } catch (\Conekta\ProcessingError $error) {
            echo $error->getMessage();
        }catch (\Conekta\ParameterValidationError $error){
            echo $error->getMessage().' parameter';
        } catch (\Conekta\Handler $error){
            echo $error->getMessage();
        }

        
    }
}
