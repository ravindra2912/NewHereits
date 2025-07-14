<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessSetting extends Model
{
    //

    protected $fillable = [
        'business_id',
        'is_appointment_system',
        'is_appointment_with_department',
    ];


    //+++++++++++++++ For api responce ================
    public function getBusinessSettingObject(): array
    {
        $data = [
            'is_appointment_system' => $this->is_appointment_system == '1' ? true : false,
            'is_appointment_with_department' => $this->is_appointment_with_department == '1' ? true : false,
        ];

        return $data;
    }
}
