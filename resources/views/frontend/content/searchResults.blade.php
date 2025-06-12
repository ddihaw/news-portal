@extends('frontend.layout.main')
@section('content')
    <section class="py-5">
        <div class="container px-5 mt-5">
            <h3 class="mb-4">Hasil Pencarian untuk: <em>"{{ $query }}"</em></h3>

            @if ($results->count())
                @foreach ($results as $news)
                    <div class="card mb-4 shadow-sm border-0 rounded-3">
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="{{ url('/article/' . $news->idNews) }}" class="text-decoration-none text-dark fw-bold">
                                    {{ $news->newsTitle }}
                                </a>
                            </h4>
                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted"><strong>{{ $news->author->name }}</strong></small>
                                <small class="text-muted">
                                    {{ $news->category->nameCategory }} &bullet;
                                    {{ \Carbon\Carbon::parse($news->created_at)->translatedFormat('d F Y') }}
                                </small>
                            </div>
                            <p class="card-text text-muted">{{ Str::limit(strip_tags($news->newsContent), 160) }}</p>
                            <a href="{{ url('/article/' . $news->idNews) }}" class="btn btn-sm btn-outline-primary mt-2">Baca
                                Selengkapnya</a>
                        </div>
                    </div>
                @endforeach

                <div class="mt-4">
                    {{ $results->links() }}
                </div>
            @else
                <div class="alert alert-warning mt-4" role="alert">
                    Tidak ada berita yang ditemukan untuk pencarian <strong>"{{ $query }}"</strong>.
                </div>
            @endif
        </div>
    </section>
@endsection