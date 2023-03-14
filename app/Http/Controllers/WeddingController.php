<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use Illuminate\Http\Request;

class WeddingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $wedding = Wedding::where('lang' , $request->lang)->get();
         return response()->json(['data'=> $wedding , 'status' =>'200']);
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
        $wedding = $request->all();
        $weddingUpdate = $request->except('_id','slug');

        
        $checkData  = Wedding::where('slug',$request->slug)->where('lang',$request->lang)->first();
        if($checkData){

            $weddingAdd = $checkData->update($weddingUpdate);

        }else{

            $weddingAdd = Wedding::create($wedding);
        }

        if($weddingAdd){

            return response()->json(['message'=>'Data has been Saved','status'=>200]);

        }else{

            return response()->json(['message'=>'Data has not been Saved' ,'status'=>404]);

        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wedding  $wedding
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request ,  $wedding)
    {
      
        
        $data = Wedding::where('slug',$wedding)->where('lang', $request->lang)->first();
        if($data){

             return response()->json(['data'=> $data , 'status' =>'200']);
        }else{
            
             return response()->json(['message'=> 'No Data Found' , 'status' =>'200']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wedding  $wedding
     * @return \Illuminate\Http\Response
     */
    public function edit(Wedding $wedding)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wedding  $wedding
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $wedding)
    {
        $input = $request->except('_id' , 'slug');

        $wedding = Wedding::where('slug',$wedding)->where('lang', $request->lang)->update($input);


        if($wedding){

             return response()->json(['message'=>'Data has been Saved','status'=>200]);

        }else{

             return response()->json(['message'=>'Data has not been Saved' ,'status'=>404]);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wedding  $wedding
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $wedding)
    {
        $wedding = Wedding::where('slug',$wedding)->where('lang', $request->lang)->delete();

        if($wedding){

             return response()->json(['message'=>'Data has been deleted','status'=>200]);

        }else{
             return response()->json(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }
}
