@extends ('layouts.template')
@section('container')
<form action="{{ route('product.store') }}" method="POST" class="card p-5">
    @csrf
    @if ($errors->any())
    <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif
    <div class="mb-3 row">
        <label for="name" class="col-sm-2 col-form-label">Nama :</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
        </div>
    </div>

    <div class="mb-3 row">
        <label for="harga" class="col-sm-2 col-form-label">Harga :</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="harga" name="harga" value="{{ old('harga') }}">
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Beli</button>
</form>
@endsection
