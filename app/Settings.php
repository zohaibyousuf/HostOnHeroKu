<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable =[

        "site_title", "site_logo", "mail_host", "port", "mail_address", "mail_name", "username", "password", "encryption", "currency"
    ];
}
