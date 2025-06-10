<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessCredit extends Model
{
    use SoftDeletes;

    public function transaction()
    {
        return $this->hasOne(Transactions::class, 'id', 'transation_id');
    }
}
