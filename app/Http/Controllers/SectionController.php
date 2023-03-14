<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
       
        $sections = Section::where('lang',$request->lang)->get();
        return response()->json(['data'=>$sections,'status'=>200]);

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

        $creatSection = $request->all();
        $sectionUpdate = $request->except('_id','slug');


        $checkData  = Section::where('lang' , $creatSection['lang'])->where('slug' , $creatSection['slug'])->first();
        if($checkData){

            $sectionAdd = $checkData->update($sectionUpdate);

        }else{

            $sectionAdd = Section::create($creatSection);
        }
        if($sectionAdd){

            return response()->json(['message'=>'Data has been Saved','status'=>200]);

        }else{

            return response()->json(['message'=>'Data has not been Saved' ,'status'=>404]);

        }
        
  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show( $section )
    {
        $section = Section::where('_id','=', $section)->first();
        return response()->json(['data' => $section , 'status' => 200]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data  = Section::where('_id',$id)->delete();
          if($data){

            return response()->json(['message'=>'Data has been deleted','status'=>200]);

        }else{
            return response()->json(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
        
    }

    public function all_sections(Request $request , $id , $lang){
        
        $section = Section::where('page_id','=', $id)->where('lang',$lang)->get();
        
        if($section){

            return response()->json(['data' => $section , 'status' => 200]);
        
        }else{
        
            return response()->json(['status'=>404,'message'=>'Error , While fetching data']);
        
        }
    }


}
