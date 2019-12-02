<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Item;
use App\Models\PurchaseItem;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Purchase $purchase)
    {
        return $purchase::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = 1;
        $purchase = $request->all();

        // COMPANY
        $purchase['company']['cnpj'] = str_replace("/", "", str_replace("-", "", str_replace(".", "", $purchase['company']['cnpj'])));
        $company = Company::where('cnpj', $purchase['company']['cnpj'])->first();
        if(!$company){
            $company = Company::create([
                'company_name' => $purchase['company']['company_name'],
                'trade_name' => $purchase['company']['company_name'],
                'cnpj' => $purchase['company']['cnpj']
            ]);
        }
        $purchase['company']['id'] = $company->id;


        // ITENS
        foreach($purchase['itens'] as $key => $data){
            $item = Item::where('sefaz_id', $data['item']['sefaz_id'])->first();
            if(!$item){
                $item = Item::create([
                    'description' => $data['item']['description'],
                    'sefaz_id' => $data['item']['sefaz_id']
                ]);
            }
            $purchase['itens'][$key]['item_id'] = $item->id;
        }


        $purchase = DB::transaction(function() use ($purchase, $user_id) {
            $newPurchase = Purchase::create([
                'number' => 1,
                'bought_at' => $purchase['bought_at'],
                'amount' => $purchase['amount'],
                'access_key' => $purchase['access_key'],
                'user_id' => $user_id,
                'company_id' => $purchase['company']['id']
            ]);
            foreach($purchase['itens'] as $item){
                PurchaseItem::create([
                    'purchase_id' => $newPurchase->id,
                    'quantity' => $item['quantity'],
                    'unitary_value' => $item['unitary_value'],
                    'amount' => $item['amount'],
                    'item_id' => $item['item_id'],
                ]);
            }
            return $newPurchase;
        });
        if(!$purchase){
            return response()->json(
                ["error" => 'Error in register'],
            404);
        }
        return ['msg' => 'success'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
