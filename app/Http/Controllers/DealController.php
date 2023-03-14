<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;
use App\Mail\mailClient;
use App\Mail\mailUser;

use Validator;
use Mail;
class DealController extends Controller
{
  
    public function index(Request $request)
    {
        
        $deal = Deal::get();
        return response()->json(['data'=> $deal , 'status' =>'200']);
    }

  
    public function store(Request $request)
    {
        
        $userDetail = $request->all();
        $userEmail  = $request->email;
        $create = Deal::create($userDetail);
        $clientEmail = 'Seychelles.Marketing@fishermanscove-resort.com';
        //$clientEmail = 'reservations@fishermanscove-resort.com';
        $mailClient = Mail::to($clientEmail)->send(new mailClient($userDetail));
        $mailUser = Mail::to($userEmail)->send(new mailUser($userDetail));
        return response()->json('Your query has been submitted successfully',200);

       
    }


   
   


}
