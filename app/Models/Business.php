<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
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

    public function country()
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

    public function reviews()
    {
        return $this->hasMany(ReviewAndRating::class, 'business_id', 'id')->where('review_type', 'business');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'business_id', 'id');
    }
    
    public function businessCredits()
    {
        return $this->hasMany(BusinessCredit::class, 'business_id', 'id');
    }

    public function businessSetting()
    {
        return $this->hasOne(BusinessSetting::class, 'business_id', 'id');
    }

    // ***************************
    // for dashboard calculation start
    // ***************************

    public function bookings()
    {
        return $this->hasMany(AppointmentBooking::class, 'business_id', 'id');
    }
    
    public function professionals()
    {
        return $this->hasMany(Appointmenter::class, 'business_id', 'id');
    }
    
    // ***************************
    // for dashboard calculation end
    // ***************************


    /**
     * Scope a query to only include businesses within a certain distance.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  float  $latitude
     * @param  float  $longitude
     * @param  float  $distance  The radius in kilometers
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithinDistance(Builder $query, $latitude, $longitude, $distance = 5)
    {
        return $query
            ->where('latitude', '!=', null)
            ->where('longitude', '!=', null)
            ->selectRaw(
                "6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))) AS distance",
                [(float)$latitude, (float)$longitude, (float)$latitude]
            )
            ->having('distance', '<=', $distance)
            ->orderBy('distance');
    }
}
