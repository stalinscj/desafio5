<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'worker_id'   => 'required|integer|exists:users,id',
            'deadline'    => 'required|date|after:yesterday',
            'description' => 'required|max:1000',
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated()
    {
        $validatedData = parent::validated();

        $validatedData['author_id'] = auth()->id();

        return $validatedData;
    }
}
