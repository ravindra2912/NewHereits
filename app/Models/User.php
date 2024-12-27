<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getBusinessDetails()
    {
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }
    
    public function getBusinesses()
    {
        return $this->hasMany(Business::class, 'owner_id', 'id');
    }

     //+++++++++++++++ For api responce ================
     public function apiObject(): array
     {
         $data = [
             'id' => $this->id,
             'first_name' => $this->first_name,
             'last_name' => $this->last_name,
             'profile' => getImage($this->profile),
             'email' => $this->email,
             'contact' => (int)$this->contact,
             'dob' => $this->dob,
             'gender' => $this->gender
         ];
         
         return $data;
     }
}
