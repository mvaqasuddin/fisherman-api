<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $page = Page::all();
        return response()->json(['data'=> $page , 'status' =>'200']);
   
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

        $creatPage = $request->all();
        $pageUpdate = $request->except('_id','slug');


        $checkData  = Page::where('slug' , $creatPage['slug'])->first();
        if($checkData){

            $pageAdd = $checkData->update($pageUpdate);

        }else{

            $pageAdd = Page::create($creatPage);
        }
        if($pageAdd){

            return response()->json(['message'=>'Data has been Saved','status'=>200]);

        }else{

            return response()->json(['message'=>'Data has not been Saved' ,'status'=>404]);

        }



      
 

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , $page)
    {
        $data = Page::where('slug',$page)->first();
        if($data){
            return response()->json(['data'=> $data , 'status' =>'200']);
        }else{
            
            return response()->json(['message'=> 'No Data Found' , 'status' =>'200']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $page)
    {
        
            $input = $request->except('_id' , 'slug');

            $creatPage = Page::where('slug',$page)->where('lang', $request->lang)->update($input);

            if($creatPage){

                echo json_encode(['message'=>'Data has been Saved','status'=>200]);

            }else{

                echo json_encode(['message'=>'Data has not been Saved' ,'status'=>404]);

            }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,$page)
    {
        
      
        $data =  Page::where('slug',$page)->delete();
        if($data){

            echo json_encode(['message'=>'Data has been deleted','status'=>200]);

        }else{
            echo json_encode(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }
}
