<?php

namespace App\Http\Controllers;

use App\Models\GalleryPage;
use App\Models\GalleryCategory;
use App\Models\Section;

use Illuminate\Http\Request;

class GalleryPageController extends Controller
{
      public function gallery_category_images(Request $request){
          
          GalleryPage::create([ 'category_id' => $request->category_id , 'category_list' => $request->images_list, 'lang' => $request->lang ]);
            
    }
    public function get_gallery_category_images(Request $request , $id){
        

        $gallery =  GalleryPage::where('category_id' ,$id)->where('lang',$request->lang)->first();
        
        return $gallery;
        
    }
    
    public function get_front_gallery_data(Request $request){
        
        
        $categories = GalleryCategory::select(['_id','name','route'])->where('lang',$request->lang)->get();
        
        $sections = Section::select(['banner','meta','route','lang'])->where('page_id' , '6297121cc333da05c64f27d2')->where('lang',$request->lang)->get();
       
        $gallery =  GalleryPage::select(['category_id','category_list','lang'])->where('lang',$request->lang)->get();
        
        
        return response()->json(['category'=> $categories , 'gallery'=> $gallery , 'sections' => $sections ],200);
        
    }
}
