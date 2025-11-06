<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Tentukan aturan 'path_gambar' secara terpisah
        // 'sometimes' berarti hanya validasi jika ada, 'nullable' berarti boleh kosong
        // 'image' berarti harus file gambar
        $imageRule = 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048'; // 2MB Max

        // Jika ini request 'store' (Create), gambar boleh kosong (nullable)
        // Jika ini request 'update' (Update), gambar juga boleh kosong
        // (jika user tidak ingin mengubah gambar)
        if ($this->isMethod('POST')) {
            // Aturan untuk Create
        }
        
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            // Aturan untuk Update
        }

        return [
            'id_kategori' => 'required|exists:kategori_produks,id',
            'nama_produk' => 'required|string|max:255',
            'harga_produk' => 'required|numeric|min:0',
            'stok_produk' => 'required|integer|min:0',
            'ukuran_baju' => 'nullable|string|max:255', 
            
            // [PERUBAHAN]
            // Kita ganti 'path_gambar' dari 'string' menjadi 'image'
            // Kita gunakan 'path_gambar' sebagai NAMA input filenya
            'path_gambar' => $imageRule,
        ];
    }
}