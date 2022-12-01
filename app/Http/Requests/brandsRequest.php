<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class brandsRequest extends FormRequest
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
            'ad'=>'required|min:3|max:14',
            'foto'=>'required',
            
        ];
    }

    public function messages()
    {
        return [
            'ad.required'=>'Ad daxil etmediniz',
            'ad.min'=>'Ad minimum 3 simvol olmalidir',
            'ad.max'=>'Ad maksimum 14 simvol olmalidir',
            'foto.required'=>'Foto daxil etmediniz',
            
            
        ];
    }
}
