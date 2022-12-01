<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class documentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'=>'required|min:3|max:14',
            'scan'=>'required',
            
        ];
    }

    public function messages()
    {
        return [
            'title.required'=>'Title daxil etmediniz',
            'title.min'=>'Title minimum 3 simvol olmalidir',
            'title.max'=>'Title maksimum 14 simvol olmalidir',
            'scan.required'=>'Foto daxil etmediniz',
            
            
        ];
    }
}
