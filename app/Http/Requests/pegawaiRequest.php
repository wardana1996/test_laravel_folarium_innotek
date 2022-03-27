<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class pegawaiRequest extends FormRequest
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
            'nama' => ['required', Rule::unique('pegawai')->ignore($this->id)],
            'email' => ['required', Rule::unique('pegawai')->ignore($this->id)],
            'alamat' => ['required', Rule::unique('pegawai')->ignore($this->id)],
            'jabatan_id' => 'required',
        ];
    }
}
