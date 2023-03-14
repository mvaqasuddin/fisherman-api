<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $blog = Blog::where('lang' , $request->lang)->get();
        return response()->json(['data'=> $blog , 'status' =>'200']);
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
        
        $blog = $request->all();
        $blogUpdate = $request->except('_id','slug');

        $check = Blog::where('lang' , $blog['lang'])->where('slug' , $blog['slug'])->first();

        $checkData  = Blog::where('slug',$request->slug)->where('lang',$request->lang)->first();
        if($checkData){

            $blogAdd = $checkData->update($blogUpdate);

        }else{

            $blogAdd = Blog::create($blog);
        }
        if($blogAdd){

            return response()->json(['message'=>'Data has been Saved','status'=>200]);

        }else{

            return response()->json(['message'=>'Data has not been Saved' ,'status'=>404]);

        }

       


       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , $blog)
    {   
       

        $data = Blog::where('slug',$blog)->where('lang', $request->lang)->first();
        if($data){
            return response()->json(['data'=> $data , 'status' =>'200']);
        }else{
            
            return response()->json(['message'=> 'No Data Found' , 'status' =>'200']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $blog)
    {
        
        $input = $request->except('_id' , 'slug');
       
        $data = Blog::where('slug',$blog)->where('lang', $request->lang)->update($input);

        if($data){
           

            return response()->json(['message'=>'Data has been Saved','status'=>200]);

        }else{
           

            return response()->json(['message'=>'Data has not been Saved' ,'status'=>404]);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,$blog)
    {
       
        $blog =  Blog::where('slug',$blog)->where('lang', $request->lang)->delete();
        

        if($blog){

            return response()->json(['message'=>'Data has been deleted','status'=>200]);

        }else{
            return response()->json(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }


}
