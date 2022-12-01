<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class aktivRequest extends FormRequest
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
                'body'=>'required|min:5|max:255',
                'title'=>'required|min:5|max:15',
                'email'=>'required|email',
                
                
            ];
       
    }

    public function messages()
    {
        return [
            'body.required'=>'Mesaj daxil etmediniz',
            'body.min'=>'Mesaj minimum 5 simvol olmalidir',
            'body.max'=>'mesaj maksimum 255 simvol olmalidir',
            'title.required'=>'Title daxil etmediniz',
            'title.min'=>'Title minimum 5 simvol olmalidir',
            'title.max'=>'Title maksimum 255 simvol olmalidir',
            'email.required'=>'Email duzgun yazilmamishdir',
            
            
        ];
    }
}
