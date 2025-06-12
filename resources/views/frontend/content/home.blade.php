@extends('frontend.layout.main')
@section('content')
    @php
        $badgeColors = ['primary', 'success', 'danger', 'warning', 'info', 'dark', 'secondary', 'custom'];
    @endphp
    <section class="py-5 bg-light">
        <div class="container px-5 mt-5">
            <div class="row gx-5">
                <div class="col-xl-8 d-flex flex-column h-100">
                    <h2 class="fw-bolder fs-5 mb-4">Berita Populer</h2>
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach ($popularNews as $index => $top)
                                <button type="button" data-bs-target="#carouselExampleIndicators"
                                    data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"
                                    aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}">
                                </button>
                            @endforeach
                        </div>

                        <div class="carousel-inner">
                            @foreach ($popularNews as $index => $top)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img class="d-block w-100" src="{{ route('storage', $top->newsImage) }}"
                                        alt="Slide {{ $index + 1 }}">
                                    <div class="overlay"></div>
                                    <div class="carousel-caption">
                                        <p style="margin-bottom: 2px;">{{ $top->category->nameCategory  }} |
                                            {{ \Carbon\Carbon::parse($top->created_at)->diffForHumans() }}
                                        </p>
                                        <a class="text-decoration-none link-light stretched-link"
                                            href="{{ route('landing.articlePage', $top->idNews) }}">
                                            <h5 class="headline" style="margin-top: 0;">{{ $top->newsTitle }}</h5>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </div>
                </div>

                <div class="col-xl-4 d-flex flex-column h-100">
                    <div class="card card-top-kategori mt-5">
                        <div class="card-body text-center">
                            <h5 class="fw-bold mb-2">Top Kategori</h5>
                            <p class="text-muted small mb-4">Jelajahi berita berdasarkan topik yang sedang ramai.</p>
                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                @foreach ($topCategories as $i => $category)
                                    @php
                                        $color = $badgeColors[$i % count($badgeColors)];
                                    @endphp
                                    <a href="{{ route('newsIndex.byCategory', $category->idCategory) }}"
                                        class="category-badge bg-{{ $color }}">
                                        <i class="bi bi-tag me-1"></i> {{ $category->nameCategory }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog preview section-->
    <section class="py-0 bg-light">
        <div class="container px-5">
            <h2 class="fw-bolder fs-5 mb-4">Berita Terbaru</h2>
            <div class="row gx-5">
                @foreach ($latestNews as $newest)
                    <div class="col-lg-4 mb-5">
                        <div class="card h-100 shadow border-0">
                            <img class="card-img-top" src="{{ route('storage', $newest->newsImage) }}"
                                alt="{{ $newest->newsTitle }}" />
                            <div class="card-body p-4">
                                <div class="badge bg-custom bg-gradient rounded-pill mb-2">
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
                                            <div class="fw-bold">{{ $newest->author->name }}</div>
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

                <div class="text-end mb-5 mb-xl-0 py-4">
                    <a class="text-decoration-none" href="{{ route('landing.allArticles') }}">
                        Lihat Selengkapnya
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
    </section>
@endsection