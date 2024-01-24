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

        $sort = \Request::get('sort');
        $perpage = \Request::get('perpage');
        $search = \Request::get('search');

         $store = Store::orderBy('id',$sort)
         // ຄົ້ນຫາຂໍ້ມູນໃນ ພິວດຽວ
         //  ->where('name','LIKE',"%{$search}%") 

         // ຄົ້ນຫາຫຼາຍ ພິວພ້ອມກັນ
         ->where(
            function($query) use ($search){
                $query->where('name','LIKE',"%{$search}%")
                ->orWhere('price_buy','LIKE',"%{$search}%");
            }
         )
         ->paginate($perpage)
         ->toArray();

        return array_reverse($store);

        // $store = Store::orderBy('id','asc')->get();
        // return $store;

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

    public function edit($id){
        $store = Store::find($id);
        return $store;
    }

    public function update($id,Request $request){
        try {

            $store = Store::find($id);
            $store->update([
                'name' => $request->name,
                // 'image' => ,
                'amount' => $request->amount,
                'price_buy' => $request->price_buy,
                'price_sell' => $request->price_sell,
            ]);
      

            $success = true;
            $message = 'ອັບເດດຂໍ້ມູນ ສຳເລັດ!';

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

    public function delete($id){

        try {

            $store = Store::find($id);
            $store->delete();
      
            $success = true;
            $message = 'ລຶບຂໍ້ມູນ ສຳເລັດ!';

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
