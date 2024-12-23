<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes;

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id')->select('id', 'first_name', 'last_name', 'email', 'contact');
    }
    
    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id', 'id')->select('id', 'name', 'image');
    }
}
