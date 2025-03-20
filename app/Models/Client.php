<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['cliendId','fname', 'mname', 'lname', 'address', 'contactno'];

}
