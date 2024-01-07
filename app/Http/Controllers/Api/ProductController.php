<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::orderBy('id','asc')->get();
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
            'harga' => 'required',
        ];
        $validate = Validator::make($request->all(),$rules);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukkan data',
                'data' => $validate->errors(),
            ]);
        }

        $DataProduct = new Product();
        $DataProduct->name = $request->name;
        $DataProduct->harga = $request->harga;

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
        $data = Product::find($id);
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
        $DataProduct = Product::find($id);

        if (empty($DataProduct)) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ],404);
        }

        $rules = [
            'name' => 'required',
            'harga' => 'required',
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
        $DataProduct->harga = $request->harga;

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
        $DataProduct = Product::find($id);

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
