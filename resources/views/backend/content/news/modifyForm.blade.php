@extends('backend.layout.main')
@section('content')
    <div class="container-fluid">
        <h1>Edit Artikel</h1>
        @php
            $prefix = Auth::user()->role;
            $status = Auth::user()->status;
            $statusList = ['Sedang Ditinjau', 'Revisi Diperlukan', 'Terpublikasi', 'Ditolak'];
        @endphp

        <div>
            <div>
                <form action="{{ url($prefix . '/news/modifyProcess') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="newsTitle" value="{{ $news->newsTitle }}"
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
                                @php
                                    $selected = ($row->idCategory == $news->idCategory) ? 'selected' : '';
                                @endphp
                                <option value="{{ $row->idCategory }}" {{ $selected }}>{{ $row->nameCategory }}</option>
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
                            onerror="this.onerror=null;this.src='{{ route('storage', $news->newsImage) }}';" src="" alt=""
                            width="15%">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konten</label>
                        <textarea name="newsContent" id="editor"
                            class="form-control @error('newsContent') is-invalid @enderror"
                            id="newsContent">{{ $news->newsContent }}</textarea>
                        @error('newsContent')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan Editor</label>
                        @if ($prefix == 'editor')
                            <textarea name="editorNotes" class="form-control @error('editorNotes') is-invalid @enderror"
                                id="editorNotes" placeholder="Tulis catatan Anda di sini"
                                rows="4">{{ old('editorNotes', $news->editorNotes) }}</textarea>
                        @else
                            <textarea name="editorNotes" class="form-control @error('editorNotes') is-invalid @enderror"
                                id="editorNotes" rows="4" readonly>{{ old('editorNotes', $news->editorNotes) }}</textarea>
                        @endif
                        @error('editorNotes')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        @if ($prefix == 'editor' || $prefix == 'admin')
                            <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
                                <option value="">Pilih Status</option>
                                @foreach ($statusList as $option)
                                    <option value="{{ $option }}" {{ old('status', $news->status ?? '') == $option ? 'selected' : '' }}>{{ ucfirst($option) }}</option>
                                @endforeach
                            </select>
                        @else
                            <select class="form-control" disabled>
                                <option>{{ ucfirst($news->status) }}</option>
                            </select>
                            <input type="hidden" name="role" value="{{ $news->status }}">
                        @endif
                        @error('status')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{ $message }}</span>
                        @enderror
                    </div>

                    <input type="hidden" name="idNews" value="{{ $news->idNews }}">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ url($prefix . '/news') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection