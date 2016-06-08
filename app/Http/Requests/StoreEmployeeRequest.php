<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreEmployeeRequest extends Request {

  

    public function rules() {
        return [ 'Fname' => 'required', 'price' => 'required', 'typebooks_id' => 'required', 'image' => 'mimes:jpeg,jpg,png',];
    }

    public function messages() {
        return [ 'Fname.required' => 'กรุณากรอกชือหนงัสือ', 'price.required' => 'กรุณากรอกราคา', 'typebooks_id.required' => 'กรุณาเลือกหมวดหนงัสือ', 'image.mimes' => 'กรุณาเลือกไฟล์ภาพนามสกลุ jpeg,jpg,png',];
    }

}
