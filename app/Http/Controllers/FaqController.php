<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $Faq = Faq::where('lang' , $request->lang)->get();
        return response()->json(['data'=> $Faq , 'status' =>'200']);
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
        $faq = $request->all();
        $faqUpdate = $request->except('_id','slug');

        $checkData  = Faq::where('slug',$request->slug)->where('lang', $request->lang)->first();
        if($checkData){

            $faqAdd = $checkData->update($faqUpdate);

        }else{

            $faqAdd = Faq::create($faq);
        }
        $data = Faq::all();
        if($faqAdd){

            return response()->json(['message'=>'Data has been Saved', 'data' => $data,'status'=>200]);

        }else{

            return response()->json(['message'=>'Data has not been Saved' ,'status'=>404]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Request  $request , $faq)
    {
        $data = Faq::where('slug',$faq)->where('lang', $request->lang)->first();
        if($data){
            return response()->json(['data'=> $data , 'status' =>'200']);
        }else{
            
            return response()->json(['message'=> 'No Data Found' , 'status' =>'200']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request , $faq)
    {
       
        $faq =  Faq::where('slug',$faq)->where('lang', $request->lang)->delete();
        
        if($faq){

            return response()->json(['message'=>'Data has been deleted','status'=>200]);

        }else{
            return response()->json(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }

     public function all(){
         $faq =  Faq::all();
        
        if($faq){

            return response()->json(['message'=>'Data retrived SUccesfully' , 'data'=> $faq,'status'=>200]);

        }else{
            return response()->json(['message'=>'No data Found' ,'status'=>404]);
        }

     }
}
