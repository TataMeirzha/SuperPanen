<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PraPanen;
use App\Http\Requests\StorePraPanenRequest;
use App\Http\Resources\PraPanenResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PraPanenApiController extends Controller
{
    // GET ALL + Filtering & Pagination
    public function index(Request $request)
    {
        $query = PraPanen::where('user_id', Auth::id());

        if ($request->has('tanaman')) {
            $query->where('nama_tanaman', 'like', '%' . $request->tanaman . '%');
        }

        if ($request->has('start_date')) {
            $query->whereDate('tanggal_tanam', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->whereDate('tanggal_tanam', '<=', $request->end_date);
        }

        $data = $query->paginate(10);
        return PraPanenResource::collection($data);
    }

    // POST - Create
    public function store(StorePraPanenRequest $request)
    {
        $jumlahKg = $request->satuan_bibit === 'ton'
            ? $request->jumlah_bibit * 1000
            : $request->jumlah_bibit;

        $luasLahan = round($jumlahKg * 0.02, 2);
        $estimasiModal = $luasLahan * 5000000;

        $praPanen = PraPanen::create([
            'user_id' => Auth::id(),
            'kategori_tanaman' => $request->kategori_tanaman,
            'nama_tanaman' => $request->nama_tanaman,
            'jumlah_bibit' => $request->jumlah_bibit,
            'satuan_bibit' => $request->satuan_bibit,
            'tanggal_tanam' => $request->tanggal_tanam,
            'musim' => $request->musim,
            'kecamatan' => Auth::user()->kecamatan,
            'kabupaten' => Auth::user()->kabupaten,
            'luas_lahan_rekomendasi' => $luasLahan,
            'estimasi_modal' => $estimasiModal,
            'status' => 'aktif',
        ]);

        return (new PraPanenResource($praPanen))
            ->additional(['message' => 'Data pra panen berhasil dicatat'])
            ->response()
            ->setStatusCode(201);
    }

    // GET BY ID
    public function show($id)
    {
        try {
            $praPanen = PraPanen::where('user_id', Auth::id())->findOrFail($id);
            return new PraPanenResource($praPanen);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Resource tidak ditemukan',
                'message' => 'Data pra panen dengan ID ' . $id . ' tidak ada.',
            ], 404);
        }
    }

    // PUT/PATCH - Update
    public function update(StorePraPanenRequest $request, $id)
    {
        try {
            $praPanen = PraPanen::where('user_id', Auth::id())->findOrFail($id);
            $praPanen->update($request->validated());
            return new PraPanenResource($praPanen);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Resource tidak ditemukan',
                'message' => 'Data pra panen dengan ID ' . $id . ' tidak ada.',
            ], 404);
        }
    }

    // DELETE
    public function destroy($id)
    {
        try {
            $praPanen = PraPanen::where('user_id', Auth::id())->findOrFail($id);
            $praPanen->delete();
            return response()->json([
                'message' => 'Data pra panen berhasil dihapus',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Resource tidak ditemukan',
                'message' => 'Data pra panen dengan ID ' . $id . ' tidak ada.',
            ], 404);
        }
    }
}