<?php

namespace App\Http\Controllers;

use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = new Client();
        $url = "http://127.0.0.1:8000/api/product";
        $response = $client->request('GET',$url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content,true);
        $product = $contentArray['data'];
        return view('product.index',compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $parameter = [
            'name' => $request->name,
            'harga' => $request->harga,
        ];

        $client = new Client();
        $url = "http://127.0.0.1:8000/api/product";
        $response = $client->request('POST',$url,[
            'headers'=>['Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);

        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content,true);
        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to('/product/show')->withErrors($error)->withInput();
        }else{
            return redirect()->to('/product')->with('success','Berhasil menambahkan data');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return view('product.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = new Client();
        $url = "http://127.0.0.1:8000/api/product/$id";
        $response = $client->request('GET',$url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content,true);
        if ($contentArray['status'] != true) {
            $errors = $contentArray['message'];
            return redirect()->to('/product/edit')->withErrors($errors)->withInput();
        }else{
            $products = $contentArray['data'];
            return view('product.edit',compact('products'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $parameter = [
            'name' => $request->name,
            'harga' => $request->harga,
        ];

        $client = new Client();
        $url = "http://127.0.0.1:8000/api/product/$id";
        $response = $client->request('PUT',$url,[
            'headers'=>['Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);

        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content,true);
        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to('/product/show')->withErrors($error)->withInput();
        }else{
            return redirect()->to('/product')->with('success','Berhasil melakukan update data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = new Client();
        $url = "http://127.0.0.1:8000/api/product/$id";
        $response = $client->request('DELETE',$url);

        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content,true);
        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to('/product/show')->withErrors($error)->withInput();
        }else{
            return redirect()->to('/product')->with('success','Berhasil melakukan hapus data');
        }
    }
}
