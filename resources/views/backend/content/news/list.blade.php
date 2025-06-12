@extends('backend.layout.main')
@section('content')
    <div class="container-fluid">
        @php
            $role = Auth::user()->role;
            $prefix = $role;
        @endphp

        <div class="row">
            <div class="col-lg-6">
                <h1 class="h3 mb-2 text-gray-800">Daftar Artikel Berita</h1>
            </div>
            <div class="col-lg-6 text-right">
                <a href="{{ url($prefix . '/news/adding') }}" class="btn btn-md btn-primary"><i class="fa fa-plus"></i>
                    Artikel Baru
                </a>
                @if ($role == 'admin' || $role == 'editor')
                    <a href="{{ url($prefix . '/news/export') }}" class="btn btn-outline-primary"><i class="fa fa-file-pdf"></i>
                        Simpan ke PDF
                    </a>
                @endif
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
                                <th>Penulis</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Revisi</th>
                                <th>Terakhir Diubah</th>
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
                                    <!--
                                                        <td><img src="{{ route('storage', $row->newsImage) }}" width="50px" height="50px"></td>
                                                    -->
                                    <td>{{ $row->author->name }}</td>
                                    <td>{{$row->newsTitle}}</td>
                                    <td>{{$row->category->nameCategory}}</td>
                                    <td>{{$row->status}}</td>
                                    <td>{{$row->revision}}</td>
                                    <td>{{ \Carbon\Carbon::parse($row->updated_at)->diffForHumans() }}</td>
                                    <td>
                                        @if (Auth::user()->role == 'author')
                                            @if ($row->status == 'Ditolak')
                                                <a href="{{ url($prefix . '/news/delete/' . $row->idNews) }}"
                                                    onclick="return confirm('Hapus Artikel Berita?')" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </a>
                                            @else
                                                <a href="{{ url($prefix . '/news/modify/' . $row->idNews) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <a href="{{ url($prefix . '/news/delete/' . $row->idNews) }}"
                                                    onclick="return confirm('Hapus Artikel Berita?')" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{ url($prefix . '/news/modify/' . $row->idNews) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="{{ url($prefix . '/news/delete/' . $row->idNews) }}"
                                                onclick="return confirm('Hapus Artikel Berita?')" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i> Hapus
                                            </a>
                                        @endif
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