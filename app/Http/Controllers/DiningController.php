<?php

namespace App\Http\Controllers;

use App\Models\Dining;
use Illuminate\Http\Request;

class DiningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dining = Dining::where('lang' , $request->lang)->get();
        return response()->json(['data'=> $dining , 'status' =>'200']);
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

        $dining = $request->all();
        $diningUpdate = $request->except('_id','slug');

        $check = Dining::where('lang' , $dining['lang'])->where('slug' , $dining['slug'])->first();

        $checkData  = Dining::where('slug',$request->slug)->where('lang',$request->lang)->first();
        if($checkData){

            $diningAdd = $checkData->update($diningUpdate);

        }else{

            $diningAdd = Dining::create($dining);
        }
        if($diningAdd){

            return response()->json(['message'=>'Data has been Saved','status'=>200]);

        }else{

            return response()->json(['message'=>'Data has not been Saved' ,'status'=>404]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dining  $dining
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , $dining)
    {
        $data = Dining::where('slug',$dining)->where('lang', $request->lang)->first();
        if($data){
            return response()->json(['data'=> $data , 'status' =>'200']);
        }else{
            
            return response()->json(['message'=> 'No Data Found' , 'status' =>'200']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dining  $dining
     * @return \Illuminate\Http\Response
     */
    public function edit(Dining $dining)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dining  $dining
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dining $dining)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dining  $dining
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,$dining)
    {
       
        $dining =  Dining::where('slug',$dining)->where('lang', $request->lang)->delete();
        

        if($dining){

            return response()->json(['message'=>'Data has been deleted','status'=>200]);

        }else{
            return response()->json(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }
}
