<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mailWedding extends Mailable
{
    use Queueable, SerializesModels;
     public $userdetail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
       $this->userDetail= $data;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('prism.marketing786@gmail.com')->subject('Fishermans Cove Resort')->markdown('emails.wedding')->with('userDetail', $this->userDetail);
    }
}
