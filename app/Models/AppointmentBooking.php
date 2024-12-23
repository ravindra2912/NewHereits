<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentBooking extends Model
{
    use SoftDeletes;

    public function department()
    {
        return $this->belongsTo(AppointmentDepartment::class, 'department_id', 'id')->select('id', 'department_name', 'department_image');
    }
    
    public function appontmenter()
    {
        return $this->belongsTo(Appointmenter::class, 'appointmenter_id', 'id')->select('id', 'appointmenter_name', 'appointmenter_image');
    }
}
