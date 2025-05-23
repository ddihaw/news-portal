@extends('backend.layout.main')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <h1 class="h3 mb-2 text-gray-800">Daftar Artikel Berita</h1>
            </div>
            <div class="col-lg-6 text-right">
                <a href="{{ route('news.adding') }}" class="btn btn-md btn-primary"><i class="fa fa-plus"></i>
                    Artikel Baru
                </a>
                <a href="{{ route('news.export') }}" class="btn btn-outline-primary"><i class="fa fa-file-pdf"></i>
                    Simpan ke PDF
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
                                <th>Gambar</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($news as $row)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td><img src="{{ route('storage', $row->newsImage) }}" width="50px" height="50px"></td>
                                    <td>{{$row->newsTitle}}</td>
                                    <td>{{$row->category->nameCategory}}</td>
                                    <td>
                                        <a href="{{ route('news.modify', $row->idNews) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href="{{ route('news.delete', $row->idNews) }}"
                                            onclick="return confirm('Hapus Artikel Berita?')" class="btn btn-sm btn-danger">
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

@endsection