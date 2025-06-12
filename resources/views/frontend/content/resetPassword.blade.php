@extends('frontend.layout.main')
@section('content')
    <section class="py-5"></section>
    <div class="container px-5">
        <h1>Reset Password</h1>

        @if (session()->has('pesan'))
            <div class="alert alert-{{ session()->get('pesan')[0] }}">
                {{ session()->get('pesan')[1] }}
            </div>
        @endif

        <div>
            <div>
                <form action="{{ route('user.resetPasswordProcess') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Password Lama</label>
                        <input type="password" name="oldPassword" value="{{ old('oldPassword') }}"
                            class="form-control @error('oldPassword') is-invalid @enderror" id="oldPassword"
                            placeholder="Masukan password lama">
                        @error('oldPassword')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="newPassword" value="{{ old('newPassword') }}"
                            class="form-control @error('newPassword') is-invalid @enderror" id="newPassword"
                            placeholder="Masukan password baru">
                        @error('newPassword')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="confirmNewPassword" value="{{ old('confirmNewPassword') }}"
                            class="form-control @error('confirmNewPassword') is-invalid @enderror" id="confirmNewPassword"
                            placeholder="Konfirmasi password baru">
                        @error('confirmNewPassword')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ session('previous_url', route('landing.index')) }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
    </section>
@endsection