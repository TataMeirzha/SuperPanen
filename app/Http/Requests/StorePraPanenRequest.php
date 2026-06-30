<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePraPanenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kategori_tanaman' => 'required|string',
            'nama_tanaman' => 'required|string',
            'jumlah_bibit' => 'required|numeric|min:0',
            'satuan_bibit' => 'required|in:kg,ton',
            'tanggal_tanam' => 'required|date',
            'musim' => 'required|in:hujan,kemarau,pancaroba',
        ];
    }
}