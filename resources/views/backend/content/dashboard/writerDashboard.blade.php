@extends('backend.layout.main')
@section('content')
    <div class="container-fluid">
        @php
            $name = Auth::user()->name;
        @endphp

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Hai, {{ $name }}!</h1>
        </div>

        @if (session()->has('pesan'))
            <div class="alert alert-{{ session()->get('pesan')[0] }}">
                {{ session()->get('pesan')[1] }}
            </div>
        @endif

        <div class="row align-items-stretch">

            <div class="col-xl-12 col-lg-12 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Berita Terbaru</h6>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Gambar</th>
                                        <th>Judul Artikel</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Terakhir Diubah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestNews as $news)
                                        <tr>
                                            <td><img src="{{ route('storage', $news->newsImage) }}" width="50px" height="50px">
                                            </td>
                                            <td>{{ $news->newsTitle }}</td>
                                            <td>{{ $news->category->nameCategory }}</td>
                                            <td>{{ $news->status }}</td>
                                            <td>{{ \Carbon\Carbon::parse($news->updated_at)->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection