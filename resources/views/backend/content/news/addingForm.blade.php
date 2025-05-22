@extends('backend.layout.main')
@section('content')
    <div class="container-fluid">
        <h1>Artikel Baru</h1>

        <div>
            <div>
                <form action="{{ route('news.addingProcess') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="newsTitle" value="{{ old('newsTitle') }}"
                            class="form-control @error('newsTitle') is-invalid @enderror" id="newsTitle"
                            placeholder="Masukan judul berita">
                        @error('newsTitle')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="idCategory" class="form-control @error('idCategory') is-invalid @enderror"
                            id="idCategory">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $row)
                                <option value="{{ $row->idCategory }}">{{ $row->nameCategory }}</option>
                            @endforeach
                        </select>
                        @error('idCategory')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <input type="file" name="newsImage" value="{{ old('newsImage') }}"
                            class="form-control @error('newsImage') is-invalid @enderror" id="newsImage" accept="image/*"
                            onchange="showPreview(this, 'picPreview')">
                        @error('newsImage')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                        <p></p>
                        <img id="picPreview"
                            onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg';"
                            src="" alt="" width="15%">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konten</label>
                        <textarea name="newsContent" id="editor"
                            class="form-control @error('newsContent') is-invalid @enderror"
                            id="newsContent">{{ old('newsContent') }}</textarea>
                        @error('newsContent')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('news.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection