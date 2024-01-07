@extends ('layouts.template')

@section('container')

    @if(Session::get('success'))
        <div class="alert alert-success"> {{ Session::get('success') }} </div>
    @endif
    @if(Session::get('deleted'))
        <div class="alert alert-warning"> {{ Session::get('deleted') }} </div>
    @endif

    <form class="d-flex" style="width: 350px; display:flex; margin-bottom:-35px;" action="" method="get">
        <input class="form-control me-2" name="date" type="date" placeholder="Search" aria-label="Search">
        <button class="btn btn-success me-2" type="submit">Search</button>
    </form>

    <a href="{{ route('product.show') }}">
        <button type="button" class="btn btn-secondary my-2 float-end">Tambah Menu</button>
    </a>

    <a href="{{ route('transaksi.create') }}">
        <button type="button" class="btn btn-secondary my-2 float-end">Beli</button>
    </a>

    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Menu</th>
                <th>Tanggal Pembelian</th>
                <th>jumlah</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
    <tbody>
    @foreach ($transaksi as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item['name'] }}</td>
        @foreach ($item['transaksi'] as $data)
        <td>{{ $data['name'] }}</td>
        @endforeach
        <td>{{ \Carbon\Carbon::parse($item['created_at'])->translatedFormat('d F Y') }}</>
        <td>{{ $item['jumlah'] }}</td>
            <td class="d-flex justify-content-center">
                <a href="{{ route('transaksi.edit', $item['id']) }}" class="btn btn-primary me-3">Edit</a>
                <!-- Modal -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$item['id']}}">
                        Hapus
                    </button>
                </td>
            </tr>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal-{{$item['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Konfrimasi Kalo Mau Hapus!!</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin akan menghapus?
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('transaksi.delete', $item['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </tbody>
</table>
@endsection
