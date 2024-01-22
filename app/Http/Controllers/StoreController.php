<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function index(){

        // ດຶງຂໍ້ມູນຈາກຕາຕະລາງ ສົ່ງໄປສະແດງຜົນ

        $store = Store::orderBy('id','asc')->get();
        return $store;

    }

    public function add(Request $request){
        try {

            // ເພີ່ມຂໍ້ມູນລໄງຕາຕະລາງ
            $store = new Store([
                'name' => $request->name,
                'amount' => $request->amount,
                'price_buy' => $request->price_buy,
                'price_sell' => $request->price_sell
            ]);
            $store->save();

            $success = true;
            $message = 'ບັນທຶກຂໍ້ມູນ ສຳເລັດ!';

        } catch (\Illuminate\Database\QueryException $ex) {
            //throw $th;
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];
        
        return response()->json($response);
    }
}
