@extends('frontend.layout.main')
@section('content')
    <section class="py-5">
        <div class="container px-5">
            <h2 class="fw-bolder fs-5 mb-4">Semua Berita</h2>
            <div class="row gx-5">
                @foreach ($latestNews as $newest)
                    <div class="col-lg-4 mb-5">
                        <div class="card h-100 shadow border-0">
                            <img class="card-img-top" src="{{ route('storage', $newest->newsImage) }}"
                                alt="{{ $newest->newsTitle }}" />
                            <div class="card-body p-4">
                                <div class="badge bg-primary bg-gradient rounded-pill mb-2">
                                    {{ $newest->category->nameCategory }}
                                </div>
                                <a class="text-decoration-none link-dark stretched-link"
                                    href="{{ route('landing.articlePage', $newest->idNews) }}">
                                    <div class="h5 card-title mb-3">{{ $newest->newsTitle }}</div>
                                </a>
                                <p class="card-text mb-0">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($newest->newsContent), 100, '...') }}
                                </p>
                            </div>
                            <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                <div class="d-flex align-items-end justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="small">
                                            <div class="fw-bold">{{ $newest->author ?? 'Admin' }}</div>
                                            <div class="text-muted">
                                                {{ \Carbon\Carbon::parse($newest->created_at)->translatedFormat('d F Y') }}
                                                &middot;
                                                {{ str_word_count(strip_tags($newest->newsContent)) > 0 ? ceil(str_word_count(strip_tags($newest->newsContent)) / 200) : 1 }}
                                                min read
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    </section>
@endsection