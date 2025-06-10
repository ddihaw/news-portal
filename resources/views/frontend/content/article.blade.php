@extends('frontend.layout.main')
@section('content')
    <section class="py-5">
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-3">
                    <div class="d-flex align-items-center mt-lg-5 mb-4">
                        <!--<img class="img-fluid rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg"
                                                                                alt="..." />-->
                        <div class="ms-3">
                            <div class="fw-bold">{{ $news->author->name }}</div>
                            <div class="text-muted">{{ $news->category->nameCategory }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <!-- Post content-->
                    <article>
                        <!-- Post header-->
                        <header class="mb-4">
                            <!-- Post title-->
                            <h1 class="fw-bolder mb-1">{{ $news->newsTitle }}</h1>
                            <!-- Post meta content-->
                            <div class="text-muted fst-italic mb-2">
                                {{ \Carbon\Carbon::parse($news->created_at)->translatedFormat('d F Y') }}
                                &middot;
                            </div>
                        </header>
                        <!-- Preview image figure-->
                        <figure class="mb-4"><img class="img-fluid rounded" src="{{ route('storage', $news->newsImage) }}"
                                alt="{{ $news->newsTitle }}" /></figure>
                        <!-- Post content-->
                        <section class="mb-5">
                            <p class="fs-5 mb-4">{!! $news->newsContent !!}</p>
                        </section>
                    </article>
                    <!-- Comments section -->
                    <section>
                        <div class="card bg-light">
                            <div class="card-body">
                                @php $user = Auth::guard('user')->user(); @endphp

                                <!-- Komentar form utama -->
                                @if($user)
                                    <form id="main-comment-form" class="comment-form mb-4">
                                        @csrf
                                        <input type="hidden" name="idNews" value="{{ $news->idNews }}">
                                        <textarea class="form-control" rows="3" name="content"
                                            placeholder="Tinggalkan komentar..."></textarea>
                                        <button class="btn btn-primary mt-2" type="submit">Kirim</button>
                                    </form>
                                @else
                                    <p><a href="{{ route('auth.index') }}">Login</a> untuk meninggalkan komentar.</p>
                                @endif

                                <!-- Container komentar -->
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
            </div>
        </div>
    </section>

    <!-- Script AJAX komentar -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.card-body').on('click', '.toggle-reply', function () {
                const id = $(this).data('comment-id');
                $('#reply-form-' + id).toggleClass('d-none');
            });

            $('.card-body').on('submit', '.comment-form', function (e) {
                e.preventDefault();
                const form = $(this);
                const data = form.serialize();

                $.ajax({
                    url: "{{ route('comments.store') }}",
                    method: "POST",
                    data: data,
                    success: function (res) {
                        form[0].reset();
                        const parentId = form.find('input[name="parent_id"]').val();
                        if (parentId) {
                            $('#replies-' + parentId).prepend(res.html);
                            $('#reply-form-' + parentId).addClass('d-none');
                        } else {
                            $('#comments-container').prepend(res.html);

                        }
                    },
                    error: function () {
                        alert('Gagal mengirim komentar.');
                    }
                });
            });

            $('.card-body').on('submit', '.delete-comment-form', function (e) {
                e.preventDefault();
                if (!confirm("Yakin ingin menghapus komentar ini?")) return;

                const form = $(this);
                const commentId = form.data('comment-id');

                $.ajax({
                    url: `/comments/${commentId}`,
                    method: 'POST',
                    data: form.serialize(), // berisi _token dan _method
                    success: function (res) {
                        if (res.status === 'success') {
                            $('#comment-' + res.comment_id).remove();
                        }
                    },
                    error: function () {
                        alert('Gagal menghapus komentar.');
                    }
                });
            });
        });
    </script>

@endsection