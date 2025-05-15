@extends('backend.layout.main')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <h1 class="h3 mb-2 text-gray-800">Kategori Berita</h1>
            </div>
            <div class="col-lg-6 text-right">
                <a href="{{ route('category.adding') }}" class="btn btn-md btn-primary"><i class="fa fa-plus"></i>
                    Kategori Baru
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
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($category as $row)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $row->nameCategory }}</td>
                                    <td>
                                        <a href="{{ route('category.modify', $row->idCategory) }}"
                                            class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit</a>
                                        <a href="{{ route('category.delete', $row->idCategory) }}"
                                            onclick="return confirm('Hapus Kategori?')" class="btn btn-sm btn-danger"><i
                                                class="fa fa-trash"></i> Hapus</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection