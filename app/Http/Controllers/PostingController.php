<?php

namespace App\Http\Controllers;

use App\Models\Posting;
use App\Models\JenisUsers;
use App\Models\Menu;
use App\Models\User;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class PostingController extends Controller
{

    public function index()
    {
        $users = User::all();
        $menus = Menu::where('parent_id', null)->notDeleted()->get();
        $currentUserRole = Auth::user()->id_jenis_user;
        $selectedMenus = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $postings = Posting::with(['comments', 'likes', 'users'])->latest()->get();
        return view('user.dashboard', ['users'=>$users,  'menus'=> $menus, 'selectedMenus'=>$selectedMenus, 'postings'=> $postings]);
    }
    public function mypost()
    {
        $users = User::all();
        $menus = Menu::where('parent_id', null)->notDeleted()->get();
        $currentUserRole = Auth::user()->id_jenis_user;
        $selectedMenus = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $postings = Posting::with(['comments', 'likes', 'users'])->latest()->get();
        return view('user.mypost', ['users'=>$users,  'menus'=> $menus, 'selectedMenus'=>$selectedMenus, 'postings'=> $postings]);
    }

    public function create()
    {
        $users = User::all();
        $menus = Menu::where('parent_id', null)->notDeleted()->get();
        $currentUserRole = Auth::user()->id_jenis_user;
        $selectedMenus = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $postings = Posting::with(['comments', 'likes', 'users'])->latest()->get();
        return view('user.addpost', ['users'=>$users,  'menus'=> $menus, 'selectedMenus'=>$selectedMenus, 'postings'=> $postings]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'message_gambar' => 'image|nullable|max:2048',
        ]);

        $posting = new Posting();
        $posting->user_id = Auth::id();
        $posting->message = $request->message;

        if ($request->hasFile('message_gambar')) {

            $imagePath = $request->file('message_gambar')->store('images', 'public');
            $posting->message_gambar = 'storage/' . $imagePath;
        }

        $posting->create_by = Auth::user()->username;
        $posting->update_by = Auth::user()->username;
        $posting->update_date = now();

        $posting->save();
        return redirect()->route('add.postings')->with('success', 'Posting created successfully.');
    }

    public function show()
    {

    }

    public function edit($id)
    {
        $users = User::all();
        $menus = Menu::where('parent_id', null)->notDeleted()->get();
        $currentUserRole = Auth::user()->id_jenis_user;
        $selectedMenus = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $postings = Posting::findOrFail($id);


        if ($postings->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to edit this post.');
        }

        return view('user.edit', ['users'=>$users,  'menus'=> $menus, 'selectedMenus'=>$selectedMenus, 'postings'=> $postings, ]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'message' => 'required',
            'message_gambar' => 'image|nullable|max:2048',
        ]);

        $posting = Posting::findOrFail($id);

        $posting->message = $request->message;

        if ($request->hasFile('message_gambar')) {

            if ($posting->message_gambar) {
                Storage::disk('public')->delete($posting->message_gambar);
            }

            $imagePath = $request->file('message_gambar')->store('images', 'public');
            $posting->message_gambar = 'storage/' . $imagePath;
        }

        $posting->update_by = Auth::user()->username;
        $posting->update_date = now();

        $posting->save();

        return redirect()->back()->with('success', 'Posting updated successfully.');
    }

    public function destroy($id)
    {
        $posting = Posting::findOrFail($id);

        if ($posting->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this post.');
        }

        if ($posting->message_gambar) {
            Storage::delete('public/' . $posting->message_gambar);
        }

        $posting->delete();

        return redirect()->back()->with('success', 'Posting deleted successfully.');
    }

    // Like a post
    public function addLike($postingId)
    {
            Like::firstOrCreate([
            'user_id' => Auth::id(),
            'create_by' => Auth::user()->username,
            'posting_id' => $postingId,
        ]);

        return redirect()->back()->with('success', 'Liked successfully.');
    }

    public function dislike($postingId)
    {
        $like = Like::where('user_id', Auth::id())->where('posting_id', $postingId)->first();
        if ($like) {
            $like->delete();
        }

        return redirect()->back()->with('success', 'Unliked successfully.');
    }

    // Add a new comment
    public function addComment(Request $request, $postingId)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->posting_id = $postingId;
        $comment->comment = $request->comment;
        $comment->create_by = Auth::user()->username;
        $comment->save();

        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    public function discomment(Request $request, $postingId, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }




}




