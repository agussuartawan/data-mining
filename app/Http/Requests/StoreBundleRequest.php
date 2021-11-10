<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBundleRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'support' => 'required|numeric',
            'confidence' => 'required|numeric',
            'filelist' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'support.required' => 'Nilai support tidak boleh kosong.',
            'support.numeric' => 'Nilai support harus berupa angka.',
            'confidence.required' => 'Nilai confidence tidak boleh kosong.',
            'confidence.numeric' => 'Nilai confidence harus berupa angka.',
            'filelist.required' => 'Mohon pilih data transaksi terlebih dahulu.'
        ];
    }
}
