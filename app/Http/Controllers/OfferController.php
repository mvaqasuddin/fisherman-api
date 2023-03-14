<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Validator;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offer = Offer::where('lang' , $request->lang)->with('categories')->get();
        return response()->json(['data'=> $offer , 'status' =>'200']);
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
        $offer = $request->all();
        $offerUpdate = $request->except('_id','slug');


        $checkData  = Offer::where('slug',$request->slug)->where('lang',$request->lang)->first();
        if($checkData){

            $offerAdd = $checkData->update($offerUpdate);

        }else{

            $offerAdd = offer::create($offer);
        }
        if($offerAdd){

            return response()->json(['message'=>'Data has been Saved','status'=>200]);

        }else{

            return response()->json(['message'=>'Data has not been Saved' ,'status'=>404]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , $offer)
    {

        
        $data = Offer::where('slug',$offer)->where('lang', $request->lang)->with('categories')->first();
        if($data){

            return response()->json(['data'=> $data , 'status' =>'200']);

        }else{

            return response()->json(['message'=> 'No Data Found' , 'status' =>'200']);

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $offer)
    {
        $input = $request->except('_id' , 'slug');

        $offer = Offer::where('slug',$offer)->where('lang', $request->lang)->update($input);


        if($offer){

            return response()->json(['message'=>'Data has been Saved','status'=>200]);

        }else{

            return response()->json(['message'=>'Data has not been Saved' ,'status'=>404]);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request , $offer)
    {
     
       $data = Offer::where('slug', $offer)->where('lang', $request->lang)->delete();
      

        if($data){

            return response()->json(['message'=>'Data has been deleted','status'=>200]);

        }else{
            return response()->json(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }


    public function premium(Request $request){
        $data = Offer::where('is_premium', 1)->where('lang', $request->lang)->get();
        if($data){

            return response()->json(['data'=> $data , 'status' =>'200']);

        }else{

            return response()->json(['message'=> 'No Data Found' , 'status' =>'200']);

        }
    }
}
