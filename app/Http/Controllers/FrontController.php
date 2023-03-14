<?php

namespace App\Http\Controllers;

use App\Models\Common;
use App\Models\Dining;
use App\Models\Faq;
use App\Models\Offer;
use App\Models\Page;
use App\Models\Room;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    
    public function get_header_data(Request $request){

        $data  = Common::select('_id','type','lang','menuItems','second','contact')->where('lang' , $request->lang)->whereIn('type',['header','footer'])->get();
        return response()->json(['data'=>$data],200);
    }


    public function get_premium_offers(Request $request){
        
         $data = Offer::select('_id','post_name','post_url','route','slug','short_description','thumbnailPreview','banner_imgPreview')->where('is_premium', 1)->where('lang', $request->lang)->get();    
         return response()->json(['data'=>$data],200);

    }
    
        public function get_rooms_list(Request $request){
        
         $data = Room::select('_id','post_name','post_url','room_type','route','slug','short_description','short_description','thumbnailPreview')->where('lang', $request->lang)->get();    
         return response()->json(['data'=>$data],200);

    }
    
    public function get_single_room(Request $request , $slug){
        
        $room = Room::select('banner_imgPreview' , 'banner_text' , 'images_list', 'lang','meta_description', 'meta_title', 'post_content', 'post_name', 'post_url', 'room_type', 'slug', 'thumbnailPreview')->where('slug', $slug)->where('lang',$request->lang)->first();
        $faqs = Faq::select('question','answer','page', 'innerpage','lang', '_id')->where('page','rooms')->where('innerpage' , $slug)->where('lang', $request->lang)->get();
        $related = Room::select('thumbnailPreview', '_id' , 'slug', 'post_name','lang')->where('slug','!=',$slug)->where('lang',$request->lang)->take(3)->get();
        
        return response()->json([
            'room'=>$room,
            'faqs' =>$faqs,
            'related'=>$related,
            ] , 200);
        
    }
    
        public function get_dining_list(Request $request){
             
            $data = Dining::select('_id','post_name','post_url','room_type','route','slug','short_description','short_description','thumbnailPreview','lang')->where('lang', $request->lang)->get();    
            return response()->json(['data'=>$data], 200);

        }

        public function get_single_dining(Request $request , $slug){
        
        $dining = Dining::select('banner_imgPreview' , 'banner_text' , 'images_list', 'lang','meta_description', 'meta_title','section_opening_hours','section_dress_code','post_content', 'post_name', 'post_url', 'room_type', 'slug', 'thumbnailPreview')->where('slug', $slug)->where('lang',$request->lang)->first();
        $faqs = Faq::select('question','answer','page', 'innerpage','lang', '_id')->where('page','dining')->where('innerpage' , $slug)->where('lang', $request->lang)->get();
        $related = Dining::select('thumbnailPreview', '_id' , 'slug', 'post_name','lang')->where('slug','!=',$slug)->where('lang',$request->lang)->take(3)->get();
        
        return response()->json([
            'dining'=>$dining,
            'faqs' =>$faqs,
            'related'=>$related,
            ] , 200);
        
    }


    public function get_offer_listing(Request $request) {
        $data = Offer::select('_id','post_name','slug','thumbnailPreview','short_description','lang','is_premium')->where('lang', $request->lang)->where('is_premium' , 0)->get();    
        return response()->json(['data'=>$data], 200);
    }

    public function get_single_offer(Request $request , $slug){
        
        $offer = Offer::select('banner_imgPreview' , 'banner_text' , 'images_list', 'lang','meta_description', 'meta_title','section_opening_hours','section_dress_code','post_content', 'post_name', 'post_url', 'room_type', 'slug', 'thumbnailPreview','short_description')->where('slug', $slug)->where('lang',$request->lang)->first();
                
        return response()->json(['offer'=>$offer] , 200);
        
    }
    

    public function get_pages_list(){
        $data = Page::select('slug')->get();    
        return response()->json(['data'=>$data],200);

    }

    
}
