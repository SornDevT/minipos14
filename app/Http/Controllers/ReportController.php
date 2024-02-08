<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transection;

class ReportController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:api');
    }

    public function created_report(Request $request){


        $month_type = $request->month_type;
        $dmy = $request->dmy;

        $m = explode("-",$dmy)[1];
        $y = explode("-",$dmy)[0];

        $sum_income = 0;
        $sum_expense = 0;

        $labels = [];
        $income = [];
        $expense = [];

        if($month_type == "m"){

            // ຊອກຫາວັນທີ່ສຸດທ້າຍຂອງເດືອນ
            $last_day = date("t",strtotime($dmy));
            // return $last_day;
            for($i=1; $i<= $last_day; $i++){
                array_push($labels,"ວັນທີ່ ".$i);
            }

            // return $labels;
            // ບວກລາຍຮັບທັງໝົດ
            $sum_income = Transection::whereMonth("created_at",$m)
            ->whereYear("created_at",$y)
            ->where("tran_type","income")
            ->sum("price");

            // ເພີ່ມລາຍການ ລາຍຮັບ
            for($i=1; $i<= $last_day; $i++){
                $inc = Transection::whereMonth("created_at",$m)
                ->whereYear("created_at",$y)
                ->whereDay("created_at",$i)
                ->where("tran_type","income")
                ->sum("price");
                array_push($income,$inc);
            }

            // ບວກລາຍຈ່າຍທັງໝົດ
            $sum_expense = Transection::whereMonth("created_at",$m)
            ->whereYear("created_at",$y)
            ->where("tran_type","expense")
            ->sum("price");

            // ເພີ່ມລາຍການ ລາຍຈ່າຍ
            for($i=1; $i<= $last_day; $i++){
                $exp = Transection::whereMonth("created_at",$m)
                ->whereYear("created_at",$y)
                ->whereDay("created_at",$i)
                ->where("tran_type","expense")
                ->sum("price");
                array_push($expense,$exp);
            }


        } else if($month_type == "y"){

              // ຊອກຫາວັນທີ່ສຸດທ້າຍຂອງເດືອນ
              $last_day = date("t",strtotime($dmy));
              // return $last_day;
              for($i=1; $i<= 12; $i++){
                  array_push($labels,"ເດືອນ ".$i);
              }
  
              // return $labels;
              // ບວກລາຍຮັບທັງໝົດ
              $sum_income = Transection::whereYear("created_at",$y)
              ->where("tran_type","income")
              ->sum("price");
  
              // ເພີ່ມລາຍການ ລາຍຮັບ
              for($i=1; $i<= $last_day; $i++){
                  $inc = Transection::whereYear("created_at",$y)
                  ->whereDay("created_at",$i)
                  ->where("tran_type","income")
                  ->sum("price");
                  array_push($income,$inc);
              }
  
              // ບວກລາຍຈ່າຍທັງໝົດ
              $sum_expense = Transection::whereYear("created_at",$y)
              ->where("tran_type","expense")
              ->sum("price");
  
              // ເພີ່ມລາຍການ ລາຍຈ່າຍ
              for($i=1; $i<= $last_day; $i++){
                  $exp = Transection::whereYear("created_at",$y)
                  ->whereDay("created_at",$i)
                  ->where("tran_type","expense")
                  ->sum("price");
                  array_push($expense,$exp);
              }


        }


        $respons =[
            "labels" => $labels,
            "income" => $income,
            "expense" => $expense,
            "sum_income" => $sum_income,
            "sum_expense" => $sum_expense,
        ];

        return response()->json($respons);

    }
}
