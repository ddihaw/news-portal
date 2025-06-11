<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'idNews' => 'required|exists:news,idNews',
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'idNews' => $request->idNews,
            'idUser' => Auth::guard('user')->id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id,
        ]);

        $comment->load(['user', 'replies']);

        if ($request->ajax()) {
            $html = view('partials.comment', compact('comment'))->render();
            return response()->json([
                'status' => 'success',
                'html' => $html,
                'message' => 'Komentar berhasil dikirim.',
            ]);
        }

        return back()->with('pesan', ['success', 'Komentar berhasil dikirim.']);
    }

    public function destroy(Comment $comment)
    {
        $user = Auth::guard('user')->user();

        if ($comment->idUser !== $user->id) {
            abort(403, 'Tidak diizinkan menghapus komentar ini.');
        }

        $comment->replies()->delete();
        $comment->delete();

        if (request()->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Komentar berhasil dihapus.',
                'comment_id' => $comment->id,
            ]);
        }

        return back()->with('pesan', ['success', 'Komentar berhasil dihapus.']);
    }
}
