<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditRequest extends FormRequest
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
            'client_id' => 'required|min:1|max:11',
            'product_id' => 'required|min:1|max:11',
            'muddet' => 'required|min:1|max:3',
            'faiz' => 'required|min:1|max:3',
            'depozit' => 'required|min:1|max:3',



        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => 'Müştəri seçmədiniz',
            'product_id.required' => 'Məhsul seçmədiniz',
            'muddet.required' => 'Məhsul seçmədiniz',
            'faiz.required' => 'Faiz seçmədiniz',
            'depozit.required' => 'Depozit daxil etmədiniz',




        ];
    }
}
