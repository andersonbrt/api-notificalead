<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Purchase;


class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return Purchase::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $array = ['error' => ''];
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:purchases,email',
            'phone' => 'required',
            'cpf_cnpj' => 'required',
            'status' => 'required|boolean'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $array['error'] = $validator->getMessageBag();
            return $array;
        }

        $purchase = new Purchase();
        $purchase->name = $request->input('name');
        $purchase->email = $request->input('email');
        $purchase->phone = $request->input('phone');
        $purchase->cpf_cnpj = $request->input('cpf_cnpj');
        $purchase->status = $request->input('status');
        $purchase->save();

        return $array;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $array = ['error' => ''];
        $purchase = Purchase::find($id);
        if ($purchase) {
            $array['purchase'] = $purchase;
        } else {
            $array['error'] = 'id ' . $id . ' is not exist to purchase';
        }
        return $array;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $array = ['error' => ''];
        $rules = [
            'name' => 'min:3',
            'email' => 'email',
            'status' => 'boolean'

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $array['error'] = $validator->getMessageBag();
            return $array;
        }
        $purchase = Purchase::find($id);
        if ($purchase) {

            if ($request->input('name')) {
                $purchase->name = $request->input('name');
            }
            if ($request->input('email')) {
                $purchase->email = $request->input('email');
            }
            if ($request->input('phone')) {
                $purchase->phone = $request->input('phone');
            }
            if ($request->input('cpf_cnpj')) {
                $purchase->cpf_cnpj = $request->input('cpf_cnpj');
            }
            if ($request->input('status') !== NULL) {
                $purchase->status = $request->input('status');
            }
            $purchase->save();
        } else {
            $array['error'] = 'id ' . $id . ' is not exist to purchase';
        }
        return $array;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $array = ['error' => ''];
        $purchase = Purchase::find($id);
        if ($purchase) {
            $purchase->delete();
        } else {
            $array['error'] = 'id ' . $id . ' is not exist to purchase';
        }
        return $array;
    }
}
