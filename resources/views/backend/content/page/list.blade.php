@extends('backend.layout.main')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <h1 class="h3 mb-2 text-gray-800">Daftar Halaman</h1>
            </div>
            <div class="col-lg-6 text-right">
                <a href="{{ route('page.adding') }}" class="btn btn-md btn-primary"><i class="fa fa-plus"></i>
                    Halaman Baru
                </a>
            </div>
        </div>

        @if (session()->has('pesan'))
            <div class="alert alert-{{ session()->get('pesan')[0] }}">
                {{ session()->get('pesan')[1] }}
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($page as $row)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $row->pageTitle }}</td>
                                    <td>{{ ($row->isActive == 1) ? "Aktif" : "Tidak Aktif"}}</td>
                                    <td>
                                        <a href="{{ route('page.modify', $row->idPage) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href="{{ route('page.delete', $row->idPage) }}"
                                            onclick="return confirm('Hapus Halaman?')" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('auth.logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>

@endsection