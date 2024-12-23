<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessSetting extends Model
{
    //


    //+++++++++++++++ For api responce ================
    public function getBusinessSettingObject(): array
    {
        $data = [
            'is_appointment_system' => $this->is_appointment_system == '1'? true : false,
            'is_appointment_book_with_time_slote' => $this->is_appointment_book_with_time_slote == '1'? true : false,
            'is_appointment_with_department' => $this->is_appointment_with_department == '1'? true : false,
        ];
        
        return $data;
    }
}
