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

    public function contry()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id')->select('id', 'sortname', 'name', 'phonecode');
    }
    
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id')->select('id', 'name', 'country_id');
    }
    
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id')->select('id', 'name', 'state_id');
    }
}
