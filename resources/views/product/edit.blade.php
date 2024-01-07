@extends ('layouts.template')

@section('container')
<form action="{{ route('product.update', $products['id']) }}" method="post" class="card p-5">
    @csrf
    @method('PUT')

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
            <input type="text" class="form-control" id="name" name="name" value="{{ isset($products['name'])?$products['name']:old('name') }}">
        </div>
    </div>

    <div class="mb-3 row">
        <label for="harga" class="col-sm-2 col-form-label">Harga:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="harga" name="harga" value="{{ isset($products['harga'])?$products['harga']:old('harga') }}">
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Update</button>
</form>
@endsection
