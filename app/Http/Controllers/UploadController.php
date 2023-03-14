<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use BunnyCDN\Storage\BunnyCDNStorage;
use Corbpie\BunnyCdn\BunnyAPI;


class UploadController extends Controller
{
    public $bunnyCDNStorage ;
    public $storageZone = 'fisherman';
    public $directory = '/fisherman/images';
    public $access_key = 'd8c39adc-6270-4043-93e6ac0d1539-1c82-447f';
    //public $bunny ;

    public function __construct()
    {

       $this->bunnyCDNStorage = new BunnyCDNStorage($this->storageZone, $this->access_key, "sg");
    }

    public function upload_media(Request $request)
    {   

        
        $validator = Validator::make($request->all(), [
          
            'images' => 'required',

           
        ]);

        if( ! $validator->fails()){

        $data = $request['data'];
        
            
        $images = $request->file('images');
      
        $files = [];
        
        if($data && $images)
         {  
           
             $i =0 ;
            foreach($data as $d)
            {   
                $d = json_decode($d , true);
                 
                $type = $d['is360'] === false ?  'false' : 'true'; 
                $folder = $type === 'image' ? 'images' : '360';
                $without_ext_name= $this->slugify(preg_replace('/\..+$/', '', $images[$i]->getClientOriginalName()));
            
                $name = $without_ext_name .'-'. time().rand(1,100).'.'.$images[$i]->extension();
                $files[$i]['url'] = $name;
                $files[$i]['avatar'] =  $name ;
                $files[$i]['alt_tag'] = $d['alt_text'];  
                $files[$i]['type'] = $type;  

                if($this->bunnyCDNStorage->uploadFile($images[$i]->getPathName() , $this->storageZone."/images/{$name}")){
                    
                $isUploaded = Upload::create(['url'=> $name, 'is360' => $type , 'avatar' => $files[$i]['avatar'] , 'url' =>$files[$i]['url'] ,'alt_tag' => $files[$i]['alt_tag'] ]);
                    
                echo json_encode(['message' =>'media has uploaded.' , 'status' =>200]);
                
                }else{
        
                   return $errors = ['message'=>'server issue','status'=>404 ,'image_name'=>$file->getClientOrignalName()];
                }

                $i ++;
            }
         }else{
              echo json_encode(['message' =>'files are not uploaded' , 'status' =>404]);
             
         }

        }
        else{

            echo json_encode(['message'=>$validator->errors(),'status'=>404]);

        }

    }
    
    
    public function get_all_images(){
        
        $data = Upload::orderBy('_id','desc')->get();
        echo json_encode(['data'=>$data ,'status'=>200]);
    }

   

    public function delete_images($id){

    $data = Upload::select('name')->where('_id',$id)->first();
        
        if(Upload::where('_id',$id)->delete()){
            
            
            if(! $this->bunnyCDNStorage->deleteObject( '/fisherman/images/'.$data->name))
            {
                echo json_encode(['message' => 'Bucket error' , 'status' => 404]);
            }
             
            echo json_encode(['message'=>'Data has been deleted','status'=>200]);
        
        }else{
            echo json_encode(['message'=>'Data has not been deleted' ,'status'=>404]);
        }

    }
    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
       // $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            echo 'n-a';
        }

        return $text;
    }

}
