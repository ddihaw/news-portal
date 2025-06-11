@extends('frontend.layout.main')

@section('content')
    <section class="py-5">
        <div class="container px-5">
            <h2 class="fw-bolder fs-5 mb-4">Berita Kategori: {{ $category->nameCategory }}</h2>

            @if ($news->count())
                <div class="row gx-5">
                    @foreach ($news as $item)
                        <div class="col-lg-4 mb-5">
                            <div class="card h-100 shadow border-2">
                                <img class="card-img-top" src="{{ route('storage', $item->newsImage) }}"
                                    alt="{{ $item->newsTitle }}" />
                                <div class="card-body p-4">
                                    <div class="badge bg-primary bg-gradient rounded-pill mb-2">
                                        {{ $item->category->nameCategory ?? 'Tanpa Kategori' }}
                                    </div>
                                    <a class="text-decoration-none link-dark stretched-link"
                                        href="{{ route('landing.articlePage', $item->idNews) }}">
                                        <div class="h5 card-title mb-3">{{ $item->newsTitle }}</div>
                                    </a>
                                    <p class="card-text mb-0">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($item->newsContent), 100, '...') }}
                                    </p>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="small">
                                                <div class="fw-bold">{{ $item->author->name ?? 'Admin' }}</div>
                                                <div class="text-muted">
                                                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                                                    &middot;
                                                    {{ str_word_count(strip_tags($item->newsContent)) > 0 ? ceil(str_word_count(strip_tags($item->newsContent)) / 200) : 1 }}
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

                <div class="mt-4">
                    {{ $news->links() }}
                </div>
            @else
                <p class="text-muted">Tidak ada berita dalam kategori ini.</p>
            @endif
        </div>
    </section>
@endsection