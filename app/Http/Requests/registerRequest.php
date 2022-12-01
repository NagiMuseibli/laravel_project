<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class registerRequest extends FormRequest
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
                'soyad'=>'required|min:3|max:14',
                'tel'=>'required|min:3|max:14',
                'password'=>'required|min:3|max:30',
                'email'=>'required|email',
                
                
            ];
       
    }

    public function messages()
    {
        return [
            'ad.required'=>'Ad daxil etmediniz',
            'ad.min'=>'Ad minimum 3 simvol olmalidir',
            'ad.max'=>'Ad maksimum 14 simvol olmalidir',
            'soyad.required'=>'Soyad daxil etmediniz',
            'soyad.min'=>'Soyad minimum 3 simvol olmalidir',
            'soyad.max'=>'Soyad maksimum 14 simvol olmalidir',
            'tel.required'=>'Telefon nomresi daxil etmediniz',
            'tel.min'=>'Telefon nomresi minimum 3 simvol olmalidir',
            'tel.max'=>'telefon nomresi maksimum 14 simvol olmalidir',
            'password.required'=>'Parol  daxil etmediniz',
            'password.min'=>'Parol minimum 3 simvol olmalidir',
            'password.max'=>'Parol maksimum 30 simvol olmalidir',
            'email.required'=>'Email duzgun yazilmamishdir',
            
            
        ];
    }
}
