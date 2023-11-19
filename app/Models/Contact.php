<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = ['firstName','lastName','phone','email','photo','address'];

    public function ContactGroup(){
        return $this->belongsTo(ContactGroup::class);
    }
}
