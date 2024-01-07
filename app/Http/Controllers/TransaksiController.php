<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $key = $request->date;
        $url = "http://127.0.0.1:8000/api/transaksi";

        // Jika tanggal disediakan, tambahkan sebagai parameter query pada URL
        if ($key) {
            $url .= "?date=$key";
        }

        $client = new Client();
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $transaksi = $contentArray['data'];

        return view('transaksi.index', compact('transaksi'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $client = new Client();
        $url = "http://127.0.0.1:8000/api/product";
        $response = $client->request('GET',$url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content,true);
        $transaksi = $contentArray['data'];
        return view('transaksi.create',compact('transaksi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $parameter = [
            'name' => $request->name,
            'jumlah' => $request->jumlah,
            'product_id' => $request->product_id,
        ];

        $client = new Client();
        $url = "http://127.0.0.1:8000/api/transaksi";
        $response = $client->request('POST',$url,[
            'headers'=>['Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);

        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content,true);
        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to('/transaksi/create')->withErrors($error)->withInput();
        }else{
            return redirect()->to('/transaksi')->with('success','Berhasil menambahkan data');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = new Client();
        $url = "http://127.0.0.1:8000/api/transaksi/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $errors = $contentArray['message'];
            return redirect()->to('/transaksi/edit')->withErrors($errors)->withInput();
        } else {
            // Fetch all transactions for dropdown
            $responses = $client->request('GET','http://127.0.0.1:8000/api/product');
            $contents = $responses->getBody()->getContents();
            $contentArrays = json_decode($contents,true);
            $transaksi = $contentArrays['data'];
            $products = $contentArray['data']; // Data for the specific ID

            return view('transaksi.edit', compact('transaksi', 'products'));
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $parameter = [
            'name' => $request->name,
            'jumlah' => $request->jumlah,
            'product_id' => $request->product_id
        ];

        $client = new Client();
        $url = "http://127.0.0.1:8000/api/transaksi/$id";
        $response = $client->request('PUT',$url,[
            'headers'=>['Content-type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);

        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content,true);
        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to('/transaksi/edit')->withErrors($error)->withInput();
        }else{
            return redirect()->to('/transaksi')->with('success','Berhasil melakukan update data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = new Client();
        $url = "http://127.0.0.1:8000/api/transaksi/$id";
        $response = $client->request('DELETE',$url);

        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content,true);
        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->to('/transaksi')->withErrors($error)->withInput();
        }else{
            return redirect()->to('/transaksi')->with('success','Berhasil melakukan hapus data');
        }
    }
}
