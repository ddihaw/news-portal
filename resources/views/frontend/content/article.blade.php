@extends('frontend.layout.main')

@section('content')
    <section class="py-4 bg-light">
        <div class="container px-3 px-md-5 mt-2 mb-5">
            <div class="row gx-4 gy-5">
                <!-- Main Content -->
                <div class="col-12 col-lg-9 order-1 order-lg-0">
                    <article>
                        <!-- Title & Meta -->
                        <header class="mb-4">
                            <h1 class="fw-bold mb-2">{{ $news->newsTitle }}</h1>
                            <div class="text-muted fst-italic">
                                Dipublikasikan pada
                                {{ \Carbon\Carbon::parse($news->updated_at)->translatedFormat('d F Y') }}
                            </div>
                        </header>

                        <!-- Image -->
                        <figure class="mb-4">
                            <img class="img-fluid rounded shadow-sm w-100" src="{{ route('storage', $news->newsImage) }}"
                                alt="{{ $news->newsTitle }}">
                        </figure>

                        <!-- Content -->
                        <section class="mb-5">
                            <div class="fs-5 lh-lg text-justify">{!! $news->newsContent !!}</div>
                        </section>
                    </article>

                    <!-- Sidebar on mobile -->
                    <div class="d-block d-lg-none mb-4">
                        <div class="card border-0 shadow-sm p-3">
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                    <h6 class="fw-bold mb-1">{{ $news->author->name }}</h6>
                                    <span class="badge bg-primary">{{ $news->category->nameCategory }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Komentar -->
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
                                <span class="badge bg-primary">{{ $news->category->nameCategory }}</span>
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
@endsection