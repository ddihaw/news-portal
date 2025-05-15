@extends('backend.layout.main')
@section('content')
<div class="container-fluid">
    <h1>Edit Kategori</h1>

    <div>
        <div>
            <form action="{{ route('category.modifyProcess') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="nameCategory" value="{{ $category->nameCategory }}"
                        class="form-control @error('nameCategory') is-invalid @enderror" id="nameCategory"
                        placeholder="Masukan nama kategori">
                    @error('nameCategory')
                    <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                    @enderror
                </div>
                <input type="hidden" name="idCategory" value="{{ $category->idCategory }}">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('category.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection