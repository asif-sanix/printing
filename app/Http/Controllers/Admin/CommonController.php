<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carton;
use App\Models\Category;
use App\Models\Client;
use App\Models\DyeDetails;
use App\Models\PaperQuality;
use App\Models\PaperType;
use App\Models\Product;
use App\Models\PurchaseOrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CommonController extends Controller{


    public function poItems(Request $request){
        if ($request->ajax()) {
            $items = PurchaseOrderItem::where('purchase_order_id', $request->id)->get(); 
             return view('admin.commons.po-items', compact('items'));
        }
        return response()->json('oops');
    }


    public function productSingle(Request $request){
        if ($request->ajax()) {
            $results = Product::where('id', $request->id)->with(['unit'])->first(); 
            return response()->json(['datas'=>$results, 'error'=>false]);
        }
        return response()->json('oops');
    }


    public function categorySingle(Request $request){
        if ($request->ajax()) {
            $results = Category::where('id', $request->id)->first(); 
             return response()->json(['datas'=>$results, 'error'=>false]);
        }
        return response()->json('oops');
    }





    public function cartonName(Request $request){
        if ($request->ajax()) {
            // if($request->client_id == null || $request->client_id == ''){
            //     return response()->json(['error' => 'Choose client']);
            // }

            $page = $request->page;
            $resultCount = 5;

            $offset = ($page - 1) * $resultCount;

            $name = Carton::where('carton_name', 'LIKE', '%' . $request->term . '%')
                    ->where('client_id', $request->client_id)
                    ->orderBy('created_at', 'asc')
                    ->skip($offset)
                    ->take($resultCount)
                    ->selectRaw('id, carton_name as text')
                    ->get();

            $count = Carton::where('carton_name', 'LIKE', '%' . $request->term . '%')
                    ->where('client_id', $request->client_id)
                    ->orderBy('created_at', 'asc')
                    ->selectRaw('id, carton_name as text')
                    ->count();
            $endCount = $offset + $resultCount;
            $morePages = $count > $endCount;

            $results = [
                "results" => $name,
                "pagination" => [
                    "more" => $morePages
                ]
            ];

            return response()->json($results);
        }

        return response()->json('oops');
    }





    public function dyeDetails(Request $request){
        if ($request->ajax()) {

            $page = $request->page;
            $resultCount = 5;

            $offset = ($page - 1) * $resultCount;

            $name = DyeDetails::where('dye_no', 'LIKE', '%' . $request->term . '%')
                    ->where('carton_size', $request->carton_size)
                    ->orderBy('created_at', 'asc')
                    ->skip($offset)
                    ->take($resultCount)
                    ->selectRaw('id, CONCAT(dye_no, " | ", dye_lock, " | ", ups, " | ", sheet_size) AS text')
                    ->get();

            $count = DyeDetails::where('dye_no', 'LIKE', '%' . $request->term . '%')
                    ->where('carton_size', $request->carton_size)
                    ->orderBy('created_at', 'asc')
                    ->selectRaw('id, CONCAT(dye_no, " | ", dye_lock, " | ", ups, " | ", sheet_size) AS text')
                    ->count();
            $endCount = $offset + $resultCount;
            $morePages = $count > $endCount;

            $results = [
                "results" => $name,
                "pagination" => [
                    "more" => $morePages
                ]
            ];

            return response()->json($results);
        }

        return response()->json('oops');
    }



    public function cartonNameSigngle(Request $request, $id){
        if ($request->ajax()) {
            $results = Carton::where('id', $request->id)->latest()->first(); 
            if($results != ''){
                return response()->json(['datas'=>$results, 'error'=>false]);
            }
            return response()->json(['datas'=>'', 'error'=>true]);
        }
        return response()->json('oops');
    }


    

   public function productList(Request $request){
    if ($request->ajax()) {
        $page = $request->page;
        $resultCount = 5;

        $offset = ($page - 1) * $resultCount;

        $paper_type = $request->paper_type;
        $term = $request->term;

        if ($paper_type != '') {
            $query = Product::where('products.code', 'LIKE', '%' . $term . '%')
                        ->where('product_type_id', $paper_type)
                        ->join('categories', 'products.category_id', '=', 'categories.id')
                        ->orderBy('products.created_at', 'asc');

            $name = $query->skip($offset)
                        ->take($resultCount)
                        ->selectRaw('products.id, CONCAT(products.code, " (", products.name, ", ", categories.name, ")") as text, products.id as product_id')
                        ->get();

            $count = $query->count();
        } else {
            $query = Product::where('products.code', 'LIKE', '%' . $term . '%')
                        ->join('categories', 'products.category_id', '=', 'categories.id')
                        ->orderBy('products.created_at', 'asc');

            $name = $query->skip($offset)
                        ->take($resultCount)
                        ->selectRaw('products.id, CONCAT(products.code, " (", products.name, ", ", categories.name, ")") as text, products.id as product_id')
                        ->get();

            $count = $query->count();
        }

        $endCount = $offset + $resultCount;
        $morePages = $count > $endCount;

        $results = [
            "results" => $name,
            "pagination" => [
                "more" => $morePages
            ]
        ];

        return response()->json($results);
    }

    return response()->json('oops');
}











    public function paperQuality(Request $request){
        if ($request->ajax()) {
            $page = $request->page;
            $resultCount = 5;
    
            $offset = ($page - 1) * $resultCount;
    
            $quality = PaperQuality::where('quality', 'LIKE', '%' . $request->term. '%')
                                    ->orderBy('created_at', 'asc')
                                    ->skip($offset)
                                    ->take($resultCount)
                                    ->selectRaw('id, quality as text')
                                    ->get();
    
            $count = Count(PaperQuality::where('quality', 'LIKE', '%' . $request->term. '%')
                                    ->orderBy('created_at', 'asc')
                                    ->selectRaw('id, quality as text')
                                    ->get());
    
            $endCount = $offset + $resultCount;
            $morePages = $count > $endCount;
    
            $results = array(
                  "results" => $quality,
                  "pagination" => array(
                      "more" => $morePages
                  )
              );
    
            return response()->json($results);
        }
        return response()->json('oops');
    }




    public function paperType(Request $request){
        if ($request->ajax()) {
            $page = $request->page;
            $resultCount = 5;
    
            $offset = ($page - 1) * $resultCount;
    
            $type = PaperType::where('type', 'LIKE', '%' . $request->term. '%')
                                    ->orderBy('created_at', 'asc')
                                    ->skip($offset)
                                    ->take($resultCount)
                                    ->selectRaw('id, type as text')
                                    ->get();
    
            $count = Count(PaperType::where('type', 'LIKE', '%' . $request->term. '%')
                                    ->orderBy('created_at', 'asc')
                                    ->selectRaw('id, type as text')
                                    ->get());
    
            $endCount = $offset + $resultCount;
            $morePages = $count > $endCount;
    
            $results = array(
                  "results" => $type,
                  "pagination" => array(
                      "more" => $morePages
                  )
              );
    
            return response()->json($results);
        }
        return response()->json('oops');
    }




    public function checkGST($gstinNumber){
        $response = Http::get("http://sheet.gstincheck.co.in/check/90e81dc57aced51487e38e59c5816f03/{$gstinNumber}");
        if ($response->successful()) {
            return $response->json();
        } else {
            return response()->json(['error' => 'Failed to fetch GSTIN information'], $response->status());
        }
    }

    public function client(Request $request){
        if ($request->ajax()) {
            $page = $request->page;
            $resultCount = 5;
    
            $offset = ($page - 1) * $resultCount;
    
            $name = Client::orderBy('company_name', 'asc')->where('company_name', 'LIKE', '%' . $request->term. '%')
                                    ->orderBy('created_at', 'asc')
                                    ->skip($offset)
                                    ->take($resultCount)
                                    ->selectRaw('id, company_name as text')
                                    ->get();
    
            $count = Count(Client::orderBy('company_name', 'asc')->where('company_name', 'LIKE', '%' . $request->term. '%')
                                    ->orderBy('created_at', 'asc')
                                    ->selectRaw('id, company_name as text')
                                    ->get());
    
            $endCount = $offset + $resultCount;
            $morePages = $count > $endCount;
    
            $results = array(
                  "results" => $name,
                  "pagination" => array(
                      "more" => $morePages
                  )
              );
    
            return response()->json($results);
        }
        return response()->json('oops');
    }



}


