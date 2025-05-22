@extends('backend.layout.main')
@section('content')
    <div class="container-fluid">
        <h1>Edit Data Pengguna</h1>

        <div>
            <div>
                <form action="{{ route('user.modifyProcess') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" value="{{ $users->name }}"
                            class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Masukan nama pengguna">
                        @error('name')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ $users->email }}"
                            class="form-control @error('email') is-invalid @enderror" id="email"
                            placeholder="Masukan email pengguna">
                        @error('email')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <input type="hidden" name="id" value="{{ $users->id }}">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection