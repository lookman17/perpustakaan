<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BukuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kode_buku' => 'required|min:4|max:4',
            'nama_buku' => 'required|min:10|max:40',
            'penerbit_buku' => 'required|min:10|max:40',
            'penulis_buku' => 'required|min:10|max:40',
            'tahun_terbit' => 'nullable|digits:4'
        ];
    }
}