<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    public function shortenMessage(){
        if(strlen($this->message)>15){
            return substr($this->message, 0,14).'...';
        }else{
            return $this->message;
        }
    }
}
