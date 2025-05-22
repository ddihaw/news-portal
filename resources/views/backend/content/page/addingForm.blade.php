@extends('backend.layout.main')
@section('content')
    <div class="container-fluid">
        <h1>Halaman Baru</h1>

        <div>
            <div>
                <form action="{{ route('page.addingProcess') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Judul Halaman</label>
                        <input type="text" name="pageTitle" value="{{ old('pageTitle') }}"
                            class="form-control @error('pageTitle') is-invalid @enderror" id="pageTitle"
                            placeholder="Masukan judul halaman">
                        @error('pageTitle')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konten</label>
                        <textarea name="pageContent" id="editor"
                            class="form-control @error('pageContent') is-invalid @enderror"
                            id="pageContent">{{ old('pageContent') }}</textarea>
                        @error('pageContent')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('page.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection