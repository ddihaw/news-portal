@extends('backend.layout.main')
@section('content')
    <div class="container-fluid">
        <h1>Kategori Baru</h1>

        @if (session()->has('pesan'))
            <div class="alert alert-{{ session()->get('pesan')[0] }}">
                {{ session()->get('pesan')[1] }}
            </div>
        @endif

        <div>
            <div>
                <form action="{{ route('dashboard.resetPasswordProcess') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Password Lama</label>
                        <input type="text" name="oldPassword" value="{{ old('oldPassword') }}"
                            class="form-control @error('oldPassword') is-invalid @enderror" id="oldPassword"
                            placeholder="Masukan password lama">
                        @error('oldPassword')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="text" name="newPassword" value="{{ old('newPassword') }}"
                            class="form-control @error('newPassword') is-invalid @enderror" id="newPassword"
                            placeholder="Masukan password baru">
                        @error('newPassword')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="text" name="confirmNewPassword" value="{{ old('confirmNewPassword') }}"
                            class="form-control @error('confirmNewPassword') is-invalid @enderror" id="confirmNewPassword"
                            placeholder="Konfirmasi password baru">
                        @error('confirmNewPassword')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection