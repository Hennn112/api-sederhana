@extends ('layouts.template')

@section('container')
<form action="{{ route('transaksi.store') }}" method="POST" class="card p-5">
    @csrf

    @if(Session::get('success'))
    <div class="alert alert-success"> {{ Session::get('success') }} </div>
    @endif
    @if ($errors->any())
    <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif
    <div class="mb-3 row">
        <label for="name" class="col-sm-2 col-form-label">Nama:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
        </div>
    </div>

    <div class="mb-3 row">
        <label for="jumlah" class="col-sm-2 col-form-label">Jumlah:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah') }}">
        </div>
    </div>

    <div class="form-group">
        <label for="exampleFormControlInput1">Menu</label>
        <select name="product_id" class="form-control" style="width: 480px" placeholder="Rapat Rutin">
            @foreach ($transaksi as $data)
                    <option value="{{ $data['id'] }}" class="form">{{ $data['name'] }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Beli</button>
</form>
@endsection
