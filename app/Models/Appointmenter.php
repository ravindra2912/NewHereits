<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointmenter extends Model
{
    use SoftDeletes;

    public function department()
    {
        return $this->belongsTo(AppointmentDepartment::class, 'department_id', 'id')->select('id', 'department_name', 'department_image');
    }
    
    public function businessSetting()
    {
        return $this->belongsTo(BusinessSetting::class, 'business_id', 'business_id');
    }
}
