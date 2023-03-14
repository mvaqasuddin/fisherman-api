<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = Category::where('lang' , $request->lang)->get();

        return response()->json(['data'=> $category , 'status' =>'200']);
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
        $category = $request->all();

        $check = Category::where('lang' , $category['lang'])->where('name' , $category['name'])->first();

        if(!empty($check) ){

            return response()->json(['message'=>'category Alraedy Exist','status'=> 404]);

        }else{

            $categoryAdd = Category::create($category);
            if($categoryAdd){
    
                return response()->json(['message'=>'Data has been Saved','status'=>200]);
    
            }else{
    
                return response()->json(['message'=>'Data has not been Saved' ,'status'=>404]);
    
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request ,$category)
    {
        
        $data = Category::where('slug',$category)->where('lang', $request->lang)->first();
        
        if($data){
            return response()->json(['data'=> $data , 'status' =>'200']);
        }else{
            
            return response()->json(['message'=> 'No Data Found' , 'status' =>'200']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $category)
    {
            $input = $request->except('_id' , 'slug');

            $category = Category::where('slug',$category)->where('lang', $request->lang)->update($input);


            if($category){

                return response()->json(['message'=>'Data has been Saved','status'=>200]);

            }else{

                return response()->json(['message'=>'Data has not been Saved' ,'status'=>404]);

            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request , $category)
    {
        $blog = Category::where('slug',$category)->where('lang', $request->lang)->delete();

        if($blog){

            return response()->json(['message'=>'Data has been deleted','status'=>200]);

        }else{
            return response()->json(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }
}
