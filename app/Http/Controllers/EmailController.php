<?php

namespace App\Http\Controllers;
use App\Models\Subscriber;
use App\Models\ContactQuery;
use App\Models\WeddingBooking;
use App\Mail\mailSubscriber;
use App\Mail\mailContactUs;
use App\Mail\mailWedding;
use Mail;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    
    public function subscribe(Request $req){
        
        $email  = $req->email;
        $check = new Subscriber();
        $check->email = $email;
        if($check->save()){

            Mail::to('reservations@fishermanscove-resort.com')->send(new mailSubscriber($email));
            echo json_encode(['status'=>1,'message'=>'You have subscribed successfully']);
             
            if (Mail::failures()) {
             echo json_encode(['status'=>0,'message'=>'Server not responding , sorry for inconvience']);
     
         }
        }

    }



     public function contactform(Request $req){

        $userDetail = [
            "fName" => $req->fName,
            "lName" => $req->lName,
            "email" => $req->email,
            "subject" => $req->subject,
            "message" => $req->message,
        ];
        
       $query = new ContactQuery();
       $check =$query->insert($userDetail);

        if($check){

            //Mail::to('reservations@fishermanscove-resort.com')->send(new mailContactUs($userDetail));
            Mail::to('reservations@fishermanscove-resort.com')->send(new mailContactUs($userDetail));
            echo json_encode(['status'=>1,'message'=>'Your request has been submitted , our team will contact you shortly']);
        
            if (Mail::failures()) {
             echo json_encode(['status'=>0,'message'=>'Server not responding , sorry for inconvience']);
     
         }
        }
        
    }


    public function bookwedding(Request $req){

        $userDetail = $req->all();
        
        $check = WeddingBooking::create($userDetail);
        if($check){
            // reservations@fishermanscove-resort.com
            Mail::to('reservations@fishermanscove-resort.com')->send(new mailWedding($userDetail));
                echo json_encode(['status'=>1,'message'=>'Your request has been submitted , our team will contact you shortly']);
            
               if (Mail::failures()) {
                    echo json_encode(['status'=>0,'message'=>'Server not responding , sorry for inconvience']);
         
                }
        }
           
    }
}
