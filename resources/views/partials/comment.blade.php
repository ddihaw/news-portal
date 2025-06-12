<div class="comment border rounded p-2 mb-2 bg-light" id="comment-{{ $comment->id }}">
    <div class="d-flex align-items-center gap-2">
        <strong>{{ $comment->user->name }}</strong>

        <div class="vr mx-2"></div>

        <span style="font-size: small">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
    </div>

    <p>{{ $comment->content }}</p>

    @php $user = Auth::guard('user')->user(); @endphp
    @if ($user)
        <button class="btn btn-sm btn-link toggle-reply" data-comment-id="{{ $comment->id }}"
            style="color: #012d61">Balas</button>

        <div class="reply-form d-none mt-2" id="reply-form-{{ $comment->id }}">
            <form class="comment-form">
                @csrf
                <input type="hidden" name="idNews" value="{{ $comment->idNews }}">
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <textarea name="content" class="form-control mb-2" rows="2" placeholder="Tulis balasan..."></textarea>
                <button type="submit" class="btn btn-sm btn-success mb-1">Kirim</button>
            </form>
        </div>
    @endif

    @php $user = Auth::guard('user')->user(); @endphp
    @if ($user && $user->id === $comment->idUser || $user && $user->role == 'admin')
        <form method="POST" class="d-inline delete-comment-form" data-comment-id="{{ $comment->id }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
        </form>
    @endif

    <div class="ms-4 mt-2" id="replies-{{ $comment->id }}">
        @foreach($comment->replies as $reply)
            @include('partials.comment', ['comment' => $reply])
        @endforeach
    </div>
</div>