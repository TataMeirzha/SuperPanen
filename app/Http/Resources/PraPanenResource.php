<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PraPanenResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kategori_tanaman' => $this->kategori_tanaman,
            'nama_tanaman' => $this->nama_tanaman,
            'jumlah_bibit' => $this->jumlah_bibit,
            'satuan_bibit' => $this->satuan_bibit,
            'tanggal_tanam' => $this->tanggal_tanam,
            'musim' => $this->musim,
            'kecamatan' => $this->kecamatan,
            'kabupaten' => $this->kabupaten,
            'luas_lahan_rekomendasi' => $this->luas_lahan_rekomendasi,
            'estimasi_modal' => $this->estimasi_modal,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}