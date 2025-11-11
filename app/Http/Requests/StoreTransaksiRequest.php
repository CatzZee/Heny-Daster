<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransaksiRequest extends FormRequest
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
            'nama_pembeli' => 'required|string|max:255', // <-- (BARU)
            'metode_pembayaran' => 'required|string|in:Tunai,Qris,Transfer',
            'total_harga' => 'required|numeric|min:0',
            'jumlah_bayar' => 'required|numeric|min:' . $this->input('total_harga'),
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|integer|exists:produks,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric',
        ];
    }
}
