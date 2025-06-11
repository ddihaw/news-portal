@extends('backend.layout.main')

@section('content')
    <div class="container-fluid">
        @php
            $role = Auth::user()->role;
            $prefix = $role;
        @endphp

        <div class="row">
            <div class="col-lg-12">
                <h1 class="h3 mb-2 text-gray-800">Berita Kategori: "{{ $category->nameCategory }}"</h1>
            </div>
        </div>

        @if (session()->has('pesan'))
            <div class="alert alert-{{ session('pesan')[0] }} mt-3">
                {{ session('pesan')[1] }}
            </div>
        @endif

        <div class="card shadow mb-4 mt-3">
            <div class="card-body">
                @if ($news->count())
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Revisi</th>
                                    <th>Terakhir Diubah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($news as $i => $row)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $row->newsTitle }}</td>
                                        <td>{{ $row->author->name ?? 'Admin' }}</td>
                                        <td>{{ $row->category->nameCategory ?? '-' }}</td>
                                        <td>{{ $row->status }}</td>
                                        <td>{{ $row->revision }}</td>
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

                    <div class="mt-3">
                        {{ $news->links() }}
                    </div>
                @else
                    <div class="alert alert-warning mt-4" role="alert">
                        Tidak ada berita dalam kategori <strong>"{{ $category->nameCategory }}"</strong>.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection