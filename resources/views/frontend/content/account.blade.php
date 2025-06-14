@extends('frontend.layout.main')
@section('content')
    <section class="py-5">
        <div class="container px-5 px-md-5 mt-5 mb-5">
            <h1>Edit Data Pengguna</h1>
            @php
                $user = Auth::user();
                $role = $user->role;
                $roles = ['admin', 'editor', 'author', 'user'];
            @endphp

            @if (session()->has('pesan'))
                <div class="alert alert-{{ session('pesan')[0] }}">
                    {{ session('pesan')[1] }}
                </div>
            @endif

            <div>
                <div>
                    <form action="{{ route('user.accountSave') }}" method="post" id="editForm"
                        onsubmit="return handleSubmit(event)">
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

                        <div class="mb-3">
                            <label class="form-label">Level</label>
                            @if ($role == 'admin')
                                <select name="role" class="form-control @error('role') is-invalid @enderror" id="role">
                                    <option value="">Pilih Role</option>
                                    @foreach ($roles as $option)
                                        <option value="{{ $option }}" {{ old('role', $users->role ?? '') == $option ? 'selected' : '' }}>{{ ucfirst($option) }}</option>
                                    @endforeach
                                </select>
                            @else
                                <select class="form-control" disabled>
                                    <option>{{ ucfirst($users->role) }}</option>
                                </select>
                                <input type="hidden" name="role" value="{{ $users->role }}">
                            @endif
                            @error('role')
                                <span style="color: red; font-weight: 600; font-size: 9pt;">{{ $message }}</span>
                            @enderror
                        </div>

                        <input type="hidden" name="id" value="{{ $users->id }}">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ session('previous_url', route('landing.index')) }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Logout</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Anda mengubah level Anda sendiri dari <strong>admin</strong>. Sistem akan otomatis logout setelah
                    menyimpan perubahan. Lanjutkan?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" onclick="submitEditForm()">Lanjutkan & Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleSubmit(event) {
            const currentUserId = '{{ Auth::id() }}';
            const currentUserRole = '{{ Auth::user()->role }}';
            const editedUserId = '{{ $users->id }}';
            const selectedRole = document.getElementById('role')?.value ?? '{{ $users->role }}';

            if (currentUserRole === 'admin' && currentUserId == editedUserId && selectedRole !== 'admin') {
                event.preventDefault();
                $('#logoutModal').modal('show');
                return false;
            }

            return true;
        }

        function submitEditForm() {
            document.getElementById('editForm').submit();
        }
    </script>

@endsection