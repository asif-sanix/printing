<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Client\ClientCollection;
use App\Models\Client;
use App\Models\ClientPlate;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
   
    public function index(Request $request){
       
        if ($request->ajax()) {
            $datas = Client::orderBy('created_at', 'desc')->select(DB::raw('CONCAT(first_name, " ", last_name) AS name'),'id', 'email','company_name','mobile','media_id','first_name','last_name', 'color')->with('media');
            $totaldata = $datas->count();

            $search = $request->search['value'];

            if ($search) {
                $datas->where('first_name', 'like', '%'.$search.'%');
                $datas->orWhere('last_name', 'like', '%'.$search.'%');
                $datas->orWhere('full_name', 'like', '%'.$search.'%');
                $datas->orWhere('company_name', 'like', '%'.$search.'%');
                $datas->orWhere('email', 'like', '%'.$search.'%');
                $datas->orWhere('mobile', 'like', '%'.$search.'%');
            }

            $request->merge(['recordsTotal' => $datas->count(), 'length' => $request->length]);
            $datas = $datas->limit($request->length)->offset($request->start)->get();

            return response()->json(new ClientCollection($datas));
            
           
        }
        return view('admin.client.list');
    }

    public function create(){
        return view('admin.client.create');
    }



    public function store(Request $request) {
        $array = ['primary', 'secondary', 'success', 'info', 'warning', 'danger'];
        $random = Arr::random($array);

        $this->validate($request,[
            'first_name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255',
            'mobile_no'=>'required',   
            'gst'=>'required',   
            'city'=>'required',   
            'pincode'=>'required',   
            'company_name'=>'required',  
        ]);

        $client = new Client;
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->full_name = $request->first_name . " " .$request->last_name;
        $client->name_init = Str::upper(Str::limit($request->first_name, 1,'').Str::limit($request->last_name, 1,''));
        $client->email = $request->email;
        $client->mobile = $request->mobile_no;
        $client->address = $request->address;
        $client->state = $request->state;
        $client->city = $request->city;
        $client->pincode = $request->pincode;
        $client->gst = $request->gst;
        $client->company_name = $request->company_name;


        $client->color = $random;
        $client->media_id = $request->file;

        if($client->save()){ 
            return redirect()->route('admin.client.index')->with(['class'=>'success','message'=>'Client Created successfully.']);
        }

        return redirect()->back()->with(['class'=>'error','message'=>'Whoops, looks like something went wrong ! Try again ...']);
    }


    public function edit($id){
        $client = Client::find($id);
        return view('admin.client.edit', compact('client'));
    }


    public function update(Request $request, $id) {
         $this->validate($request,[
            'first_name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255',
            'mobile_no'=>'required',   
            'gst'=>'required',   
            'city'=>'required',   
            'pincode'=>'required',   
            'company_name'=>'required',   
            'email' => [
                'required',
                Rule::unique('clients')->ignore($id),
            ], 
        ]);

        $client = Client::find($id);
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->full_name = $request->first_name . " " .$request->last_name;
        $client->name_init = Str::upper(Str::limit($request->first_name, 1,'').Str::limit($request->last_name, 1,''));
        $client->email = $request->email;
        $client->mobile = $request->mobile_no;
        $client->address = $request->address;
        $client->state = $request->state;
        $client->city = $request->city;
        $client->pincode = $request->pincode;
        $client->gst = $request->gst;
        $client->company_name = $request->company_name;

        if($client->save()){ 
            return redirect()->route('admin.client.index')->with(['class'=>'success','message'=>'Client Created successfully.']);
        }

        return redirect()->back()->with(['class'=>'error','message'=>'Whoops, looks like something went wrong ! Try again ...']);
    }


    public function show($id){
        $client = Client::where('id', $id)->with(['plates'=>function($query){
            $query->with(['jobType']);
        }])->first();
        return view('admin.client.view', compact('client'));
    }


    public function destroy($id)
    {
       
        $client = Client::find($id);
        if($client->delete()){
            
            return response()->json(['message'=>'Clent deleted successfully ...', 'class'=>'success']);  
        }
        return response()->json(['message'=>'Whoops, looks like something went wrong ! Try again ...', 'class'=>'error']);
    }

    
}
