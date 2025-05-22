@extends('backend.layout.main')
@section('content')
    <div class="container-fluid">
        <h1>Edit Halaman</h1>

        <div>
            <div>
                <form action="{{ route('page.modifyProcess') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="pageTitle" value="{{ $page->pageTitle }}"
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
                            id="pageContent">{{ $page->pageContent }}</textarea>
                        @error('pageContent')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="isActive" class="form-control @error('isActive') is-invalid @enderror">
                            <option value="1" {{ $page->isActive == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ $page->isActive == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('isActive')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <input type="hidden" name="idPage" value="{{ $page->idPage }}">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('page.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection