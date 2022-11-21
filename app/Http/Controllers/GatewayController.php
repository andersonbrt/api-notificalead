<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gateway;

class GatewayController extends Controller
{
    /**
     * lista todos os dados recebidos em formato JSON.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        $array = $request->all();
        if (empty($array)) {
            $array = ['response' => 200, 'msg' => 'Nada recebido.'];
        }
        return $array;
    }
}
