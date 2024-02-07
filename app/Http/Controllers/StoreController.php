<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Transection;

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

            // return $request->file('image');

            // echo $request;
            $upload_path = "assets/img";

            if($request->file('image')){

                // ສ້າງຊື່ຮູບພາບໃໝ່ ແລ້ວອ່ານຄ່າ ປະເພດຂອງຮູບ
                $generate_new_name_img = time().".".$request->image->getClientOriginalExtension();

                // ທຳການອັບໂຫຼດ
                $request->image->move(public_path($upload_path),$generate_new_name_img);

            } else {
                $generate_new_name_img = '';
            }

            // ເພີ່ມຂໍ້ມູນລໄງຕາຕະລາງ
            $store = new Store([
                'name' => $request->name,
                'image' => $generate_new_name_img,
                'amount' => $request->amount,
                'price_buy' => $request->price_buy,
                'price_sell' => $request->price_sell
            ]);
            $store->save();

            $product_id = $store->id; ///ດຶງ id ທີ່ບັນທຶກໄປລ່າສຸດ


            // ບັນທຶກ ການຊື້ສິນຄ້າ

            $number='';
            $read_tran = Transection::all()->sortByDesc('id')->take(1)->toArray();
            foreach($read_tran as $new){
                $number = $new['tran_id'];
            }

            if($number!=''){
                $number1 = str_replace("INC","",$number); // INC00001 = 00001
                $number2 = str_replace("EXP","",$number1);
                $number3 = (int)$number2+1; // 1+1 = 2
                $length = 5;
                $number = substr(str_repeat(0,$length).$number3, - $length); //00002
            } else {
                $number3 = 1;
                $length = 5;
                $number = substr(str_repeat(0,$length).$number3, - $length); //00001
            }


             // ເພີ່ມຂໍ້ມູນລົງຕາຕະລາງ
            $tran = new Transection([
                'tran_id' => "EXP".$number,
                'tran_type' => "expense",
                'product_id' =>$product_id,
                'amount' => $request->amount,
                'price' => $request->amount*$request->price_buy,
                'tran_detail' => "ຊື້ສິນຄ້າໃໝ່ ".$request->name,

            ]);
            $tran->save();


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


            $upload_path = "assets/img";
            $store = Store::find($id);

            if($request->file('image')){

                // ລຶບຮູບພາບເກົ່າ
                if($store->image){
                    if(file_exists($upload_path."/".$store->image)){
                        unlink($upload_path."/".$store->image); // ລຶບໄຟລ໌ເກົ່າອອກ
                    }
                }
                // ອັບໂຫຼດຮູບໃໝ່
                // ສ້າງຊື່ຮູບພາບໃໝ່ ແລ້ວອ່ານຄ່າ ປະເພດຂອງຮູບ
                $generate_new_name_img = time().".".$request->image->getClientOriginalExtension();

                // ທຳການອັບໂຫຼດ
                $request->image->move(public_path($upload_path),$generate_new_name_img);

                
                $store->update([
                    'name' => $request->name,
                    'image' => $generate_new_name_img,
                    'amount' => $request->amount,
                    'price_buy' => $request->price_buy,
                    'price_sell' => $request->price_sell,
                ]);

            } else {
                
                if($request->image){ // ກໍລະນີບໍ່ມີການປ່ຽນແປງຮູບພາບ

                    $store->update([
                        'name' => $request->name,
                        // 'image' => $generate_new_name_img,
                        'amount' => $request->amount,
                        'price_buy' => $request->price_buy,
                        'price_sell' => $request->price_sell,
                    ]);

                } else { // ກໍລະນີ ຮູບພາບຖຶກລຶບ 

                    // ລຶບຮູບພາບເກົ່າ
                    if($store->image){
                        if(file_exists($upload_path."/".$store->image)){
                            unlink($upload_path."/".$store->image); // ລຶບໄຟລ໌ເກົ່າອອກ
                        }
                    }

                    $store->update([
                        'name' => $request->name,
                        'image' => '',
                        'amount' => $request->amount,
                        'price_buy' => $request->price_buy,
                        'price_sell' => $request->price_sell,
                    ]);

                }

            }


           
      

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
