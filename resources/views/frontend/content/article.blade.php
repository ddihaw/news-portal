@extends('frontend.layout.main')

@section('meta')
    <meta property="og:title" content="{{ $news->newsTitle }}" />
    <meta property="og:description" content="{{ Str::limit(strip_tags($news->newsContent), 150) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ secure_asset('storage/news/' . $news->newsImage) }}" />
    <meta property="og:type" content="article" />

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $news->newsTitle }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($news->newsContent), 150) }}">
    <meta name="twitter:image" content="{{ asset('storage/news/' . $news->newsImage) }}">
@endsection

@section('content')
    <section class="py-5 bg-light">
        <div class="container px-5 px-md-5 mt-5 mb-5">
            <div class="row gx-4 gy-5">
                <!-- Main Content -->
                <div class="col-12 col-lg-9 order-1 order-lg-0">
                    <article>
                        <header class="mb-4">
                            <h1 class="fw-bold mb-2">{{ $news->newsTitle }}</h1>
                            <div class="text-muted fst-italic">
                                Dipublikasikan pada
                                {{ \Carbon\Carbon::parse($news->updated_at)->translatedFormat('d F Y') }}
                                &nbsp;•&nbsp;
                                <i class="fas fa-eye"></i> {{ number_format($news->totalViews) }} tayangan
                            </div>
                        </header>

                        <figure class="mb-2">
                            <img class="img-fluid rounded shadow-sm w-100" src="{{ route('storage', $news->newsImage) }}"
                                alt="{{ $news->newsTitle }}">
                        </figure>

                        <div class="mb-4">
                            <div class="card border-0 shadow-sm p-3">
                                <h5 class="mb-3">Bagikan artikel ini:</h5>
                                <div class="social-share-wrapper">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                        class="social-icon social-facebook" target="_blank" title="Bagikan ke Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($news->newsTitle) }}"
                                        class="social-icon social-twitter" target="_blank" title="Bagikan ke Twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://api.whatsapp.com/send?text={{ urlencode($news->newsTitle . ' ' . url()->current()) }}"
                                        class="social-icon social-whatsapp" target="_blank" title="Bagikan ke WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($news->newsTitle) }}"
                                        class="social-icon social-telegram" target="_blank" title="Bagikan ke Telegram">
                                        <i class="fab fa-telegram-plane"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($news->newsTitle) }}"
                                        class="social-icon social-linkedin" target="_blank" title="Bagikan ke LinkedIn">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <button onclick="copyLink()" class="social-icon social-copy" title="Salin tautan">
                                        <i class="fas fa-link"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <section class="mb-5">
                            <div class="fs-5 lh-lg text-justify">{!! $news->newsContent !!}</div>
                        </section>
                    </article>

                    <!-- Sidebar on Mobile Only -->
                    <div class="d-block d-lg-none mb-4">
                        <div class="card border-0 shadow-sm p-3">
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                    <h6 class="fw-bold mb-1">{{ $news->author->name }}</h6>
                                    <span class="badge bg-custom">{{ $news->category->nameCategory }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="mt-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white">
                                <h5 class="mb-0">Komentar</h5>
                            </div>
                            <div class="card-body">
                                @php $user = Auth::guard('user')->user(); @endphp
                                @if($user)
                                    <form id="main-comment-form" class="comment-form mb-4">
                                        @csrf
                                        <input type="hidden" name="idNews" value="{{ $news->idNews }}">
                                        <textarea class="form-control" rows="3" name="content"
                                            placeholder="Tulis komentar Anda..."></textarea>
                                        <button class="btn btn-primary mt-2" type="submit">Kirim Komentar</button>
                                    </form>
                                @else
                                    <p>
                                        <a href="{{ route('auth.index', ['redirect' => url()->full()]) }}">Login</a> untuk
                                        meninggalkan komentar.
                                    </p>
                                @endif

                                <div id="comments-container">
                                    @foreach($comments->where('parent_id', null)->sortByDesc('created_at') as $comment)
                                        @include('partials.comment', ['comment' => $comment])
                                    @endforeach

                                    @if($news->comments->isEmpty())
                                        <p class="text-muted">Belum ada komentar. Jadilah yang pertama!</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Sidebar on desktop only -->
                <div class="col-12 col-lg-3 d-none d-lg-block order-lg-1">
                    <div class="card border-0 shadow-sm p-3 mt-lg-5" style="top: 80px;">
                        <div class="d-flex align-items-center">
                            <div class="ms-2">
                                <h6 class="fw-bold mb-1">{{ $news->author->name }}</h6>
                                <span class="badge bg-custom">{{ $news->category->nameCategory }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- AJAX Comments -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function () {
            $('.card-body').on('click', '.toggle-reply', function () {
                const id = $(this).data('comment-id');
                $('#reply-form-' + id).toggleClass('d-none');
            });

            $('.card-body').on('submit', '.comment-form', function (e) {
                e.preventDefault();
                const form = $(this);
                const data = form.serialize();

                $.post("{{ route('comments.store') }}", data, function (res) {
                    form[0].reset();
                    const parentId = form.find('input[name="parent_id"]').val();
                    if (parentId) {
                        $('#replies-' + parentId).prepend(res.html);
                        $('#reply-form-' + parentId).addClass('d-none');
                    } else {
                        $('#comments-container').prepend(res.html);
                    }
                }).fail(function () {
                    alert('Gagal mengirim komentar.');
                });
            });

            $('.card-body').on('submit', '.delete-comment-form', function (e) {
                e.preventDefault();
                if (!confirm("Yakin ingin menghapus komentar ini?")) return;

                const form = $(this);
                const commentId = form.data('comment-id');

                $.post(`/comments/${commentId}`, form.serialize(), function (res) {
                    if (res.status === 'success') {
                        $('#comment-' + res.comment_id).remove();
                    }
                }).fail(function () {
                    alert('Gagal menghapus komentar.');
                });
            });
        });
    </script>

    <script>
        function copyLink() {
            const url = "{{ url()->current() }}";
            navigator.clipboard.writeText(url).then(() => {
                alert('Tautan berhasil disalin!');
            }).catch(err => {
                alert('Gagal menyalin tautan.');
            });
        }
    </script>

@endsection