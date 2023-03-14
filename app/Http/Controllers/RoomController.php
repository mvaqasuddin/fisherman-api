<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $room = Room::where('lang' , $request->lang)->get();
        return response()->json(['data'=> $room , 'status' =>'200']);
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

        $room = $request->all();
        $roomUpdate = $request->except('_id','slug');

        $check = Room::where('lang' , $room['lang'])->where('slug' , $room['slug'])->first();

        $checkData  = Room::where('slug',$request->slug)->where('lang',$request->lang)->first();
        if($checkData){

            $roomAdd = $checkData->update($roomUpdate);

        }else{

            $roomAdd = Room::create($room);
        }
        if($roomAdd){

            return response()->json(['message'=>'Data has been Saved','status'=>200]);

        }else{

            return response()->json(['message'=>'Data has not been Saved' ,'status'=>404]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , $room)
    {
        $data = Room::where('slug',$room)->where('lang', $request->lang)->first();
        if($data){
            return response()->json(['data'=> $data , 'status' =>'200']);
        }else{
            
            return response()->json(['message'=> 'No Data Found' , 'status' =>'200']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $room)
    {
        
        $input = $request->except('_id' , 'slug');
       
        $data = Room::where('slug',$room)->where('lang', $request->lang)->update($input);

        if($data){
           

            return response()->json(['message'=>'Data has been Saved','status'=>200]);

        }else{
           

            return response()->json(['message'=>'Data has not been Saved' ,'status'=>404]);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request ,$room)
    {
       
        $room =  Room::where('slug',$room)->where('lang', $request->lang)->delete();
        

        if($room){

            return response()->json(['message'=>'Data has been deleted','status'=>200]);

        }else{
            return response()->json(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }

}
