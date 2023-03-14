<?php

namespace App\Http\Controllers;

use App\Models\Widget;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $widget = Widget::where('lang' , $request->lang)->get();
        echo json_encode(['data'=> $widget , 'status' =>'200']);
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
        $widget = $request->all();

        $check = Widget::where('lang' , $widget['lang'])->where('slug' , $widget['slug'])->first();

        if(!empty($check) ){

            echo json_encode(['message'=>'widget Alraedy Exist','status'=> 404]);

        }else{

            $widgetAdd = Widget::create($widget);
            if($widgetAdd){
    
                echo json_encode(['message'=>'Data has been Saved','status'=>200]);
    
            }else{
    
                echo json_encode(['message'=>'Data has not been Saved' ,'status'=>404]);
    
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function show(Widget $widget)
    {
        if($widget){

            $data = $widget->where('lang', $request->lang)->first();

            echo json_encode(['data'=> $data , 'status' =>'200']);
        }else{
            
            echo json_encode(['message'=> 'No Data Found' , 'status' =>'200']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function edit(Widget $widget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Widget $widget)
    {
       
            $input = $request->except('_id');

            $widget = $widget->where('lang', $request->lang)->update($input);


            if($widget){

                echo json_encode(['message'=>'Data has been Saved','status'=>200]);

            }else{

                echo json_encode(['message'=>'Data has not been Saved' ,'status'=>404]);

            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Widget $widget)
    {
         $widget = $widget->where('lang', $request->lang)->delete();

        if($widget){

            echo json_encode(['message'=>'Data has been deleted','status'=>200]);

        }else{
            echo json_encode(['message'=>'Data has not been deleted' ,'status'=>404]);
        }



        
    }
}
