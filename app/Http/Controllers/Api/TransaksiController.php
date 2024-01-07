<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $key = $request->date;
        $data = Transaksi::with('transaksi')->where('created_at','LIKE',"%$key%")->get();
        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $data,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'jumlah' => 'required',
            'product_id' => 'required'
        ];

        $validate = Validator::make($request->all(),$rules);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukkan data',
                'data' => $validate->errors(),
            ]);
        }

        $DataProduct = new Transaksi();
        $DataProduct->name = $request->name;
        $DataProduct->jumlah = $request->jumlah;
        $DataProduct->product_id = $request->product_id;

        $post = $DataProduct->save();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil memasukkan data',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Transaksi::with('transaksi')->find($id);
        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => $data,
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',

            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $DataProduct = Transaksi::with('transaksi')->find($id);

        if (empty($DataProduct)) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ],404);
        }

        $rules = [
            'name' => 'required',
            'jumlah' => 'required',
            'product_id' => 'required',
        ];

        $validate = Validator::make($request->all(),$rules);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal melakukan update data',
                'data' => $validate->errors(),
            ]);
        }

        $DataProduct->name = $request->name;
        $DataProduct->product_id = $request->jumlah;
        $DataProduct->product_id = $request->product_id;

        $post = $DataProduct->save();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil melakukan update data',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $DataProduct = Transaksi::find($id);

        if (empty($DataProduct)) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ],404);
        }

        $post = $DataProduct->delete();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil menghapus data',
        ]);
    }
}
