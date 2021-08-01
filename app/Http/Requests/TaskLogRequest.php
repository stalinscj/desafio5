<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskLogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment' => 'required|max:1000'
        ];
    }
}
