<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ⭐️追加
        $tweets = Tweet::with(['user', 'liked'])->latest()->get();

        // $tweetsを'tweets.index'に渡す
        // このtweets.indexとは、resources/views配下のtweetsの中のindex.blade.phpを指すよ。
        return view('tweets.index', compact('tweets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
   
        return view('tweets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // tweet必須 + 最高で255文字までの制限
            'tweet' => 'required|max:255',
        ]);

        $request->user()->tweets()->create($request->all());
        // リクエストからユーザの情報を取得し、「ユーザidが指定済みのtweetsテーブル」を用意してデータを作成する
        // $request->user()->tweets()->create($request->only('tweet')); // ←これでもok

        return redirect()->route('tweets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
        return view('tweets.show', compact('tweet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet)
    {
        return view('tweets.edit', compact('tweet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tweet $tweet)
    {
        $request->validate([
            'tweet' => 'required|max:255',
        ]);

        $tweet->update($request->only('tweet'));

        return redirect()->route('tweets.show', $tweet);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        $tweet->delete();

        return redirect()->route('tweets.index');
    }
}
