<?php

namespace App\Http\Controllers;

use App\Models\Common;
use App\Models\Room;
use App\Models\Blog;
use App\Models\Dining;
use App\Models\Page;
use App\Models\Subscriber;
use App\Models\WeddingBooking;
use App\Models\Todo;
use App\Models\PopUp;
use App\Models\Offer;
use Illuminate\Http\Request;
use DB;

class CommonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data  = Common::where('lang' , $request->lang)->get();
        return response()->json(['data'=> $data , 'status' =>'200']);

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
        $common = $request->all();
        $commonUpdate = $request->except('_id');


        $checkData  = Common::where('type',$request->type)->where('lang',$request->lang)->first();
        if($checkData){

            $commonAdd = $checkData->update($commonUpdate);

        }else{

            $commonAdd = Common::create($common);
        }
        if($commonAdd){

            return response()->json(['message'=>'Data has been Saved','status'=>200]);

        }else{

            return response()->json(['message'=>'Data has not been Saved' ,'status'=>404]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Common  $common
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request ,$common)
    {   
        $data = Common::where('type',$common)->where('lang', $request->lang)->first();
        if($data){
            return response()->json(['data'=> $data , 'status' =>'200']);
        }else{
            
            return response()->json(['message'=> 'No Data Found' , 'status' =>'200']);
        }
    }

  
    public function destroy(Request $request ,$common)
    {
       
        $common =  Common::where('type',$common)->where('lang', $request->lang)->delete();
        

        if($common){

            return response()->json(['message'=>'Data has been deleted','status'=>200]);

        }else{
            return response()->json(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }


    public function dropDown(){

        $compiled = [];
        $room = Room::select('_id','post_name','slug','lang')->get();
        $roomGroup = $room->groupBy('slug');
            
        $i =0;
        foreach($roomGroup as $key => $data){
           
           foreach($data as $sub){
               if($sub->lang == 'de'){
                   $compiled[$i]['name_de'] = $sub->post_name;
               }elseif($sub->lang == 'fr'){
                   $compiled[$i]['name_fr'] = $sub->post_name;
               }elseif($sub->lang == 'ru'){
                   $compiled[$i]['name_ru'] = $sub->post_name;
               }else{
                   $compiled[$i]['post_name'] = $sub->post_name;
               }
               
               $compiled[$i]['slug'] = $sub->slug;
           }
           
           
         $i++;  
        
        }
   
    
        $dining = Dining::select('_id','post_name','slug','lang')->get();
        $diningGroup = $dining->groupBy('slug');
        $compiled_dining = [];
         $c =0;
        foreach($diningGroup as $keyDining => $dataDining){
           
           foreach($dataDining as $subDining){
            //   dd($subDining);
               if($subDining->lang == 'de'){
                   $compiled_dining[$c]['name_de'] = $subDining->post_name;
               }elseif($subDining->lang == 'fr'){
                   $compiled_dining[$c]['name_fr'] = $subDining->post_name;
               }elseif($subDining->lang == 'ru'){
                   $compiled_dining[$c]['name_ru'] = $subDining->post_name;
               }else{
                   $compiled_dining[$c]['post_name'] = $subDining->post_name;
               }
               
               $compiled_dining[$c]['slug'] = $subDining->slug;
           }
           
           
         $c++;  
        
        }
        
        
        
        $page = Page::select('_id' ,'name_fr','name_de', 'name_ru','slug' , 'name')->get();

         
        $common = [$compiled,$compiled_dining, $page];
        if($common){

            return response()->json(['data'=>$common,'status'=>200]);

        }else{
            return response()->json(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }
    
    
public function dashboard_apis(){ 
    
    $sub = Subscriber::all();
    $wed = WeddingBooking::all();
    $todo = Todo::all(); 
    $post = DB::table('posts') ->whereIn('category_id',[1,2,3,5]) ->orderByDesc('updated_at') ->limit(4) ->get();
    foreach($post as $p){ 
        $p->thumbnail = asset('images/'.$p->thumbnail); 
        
    } 
    $emails = Subscriber::count(); 
    $contacts = WeddingBooking::count();
    $offers = new Offer(); 
    $offers = $offers->where('category_id',5)->where(['lang' => "en" ])->count();
    $allOffers = Offer::all();
    $dining = Dining::all()->count(); 
    
    $data = [ 'subscribers' => $sub, 'weddings' =>$wed, 'recent_activities' => $post , 'Todo_lists' =>$todo , 'subscribers_count' => $emails, 'contacts_count' =>$contacts, 'allOffer' =>$allOffers ,'offers_count' =>$offers , 'dining'=>$dining ]; 
    return  $data; 
    
}


    public function createPopUp(Request $request){
        
        
            $popUp = [
              'link'=> $request->link,
              'image' => $request->image
            ];
         $create = PopUp::where('_id',$request->_id)->update($popUp);
       if($create){
    
            return response()->json(['data'=>'Pop Up added Successfully','status'=>200]);
    
        }else{
            return response()->json(['message'=>'Data has not been saved' ,'status'=>404]);
        }
    }
    
    
    
    
    public function getPopUp($id){
        
        $popUp = PopUp::where('_id',$id)->first();
        if($popUp){
    
            return response()->json(['data'=>$popUp,'status'=>200]);
    
        }else{
            return response()->json(['message'=>'No Data Found' ,'status'=>404]);
        }
        
    }

}
