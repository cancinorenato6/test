<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['clientId','fname', 'mname', 'lname', 'address', 'contactno', 'image_path'];

}


