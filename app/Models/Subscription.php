<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'status',
    ];

    public function transaction()
    {
        return $this->hasOne(Transactions::class, 'id', 'transation_id');
    }
}
