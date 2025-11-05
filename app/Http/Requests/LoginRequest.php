<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Izinkan semua orang (termasuk tamu) untuk mencoba login
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
            'nama' => 'required|string',
            'password' => 'required|string',
        ];
    }

    /**
     * (Opsional) Pesan error kustom.
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ];
    }
}