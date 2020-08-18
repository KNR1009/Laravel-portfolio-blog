<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $q = \Request::query();
        if(isset($q['category_id'])){
           $posts = Post::latest()->where('category_id', $q['category_id'])->paginate(5);
           $posts->load('category', 'user');
           return view('posts.index', [
            'posts' => $posts,
        ]);
        }else{
            $posts = Post::latest()->paginate(5);

        // モデルに定義したcategoryを読み込む

        $posts->load('category', 'user');
        
        // Viewファイルにデータを送る

        return view('posts.index', [
            'posts' => $posts,
        ]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('posts.create', [
           
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        // 問題なく画像がアップロードできたかをチェックする
        

        if ($request->file('image')->isValid()) { 
            //postのインスタンスを生成する
            $post = new Post;
                // 入力された値を変数に格納する
            $post->title = $request->input('title');
            $post->category_id = $request->input('category_id');
            $post->content = $request->input('content');
            $post->user_id = $request->input('user_id');

            // 画像の保存先のファイル名をいかに記述する
            $filename = $request->file('image')->store('public/image');
            // basenameで暗号化している
            $post->image = basename($filename);
        }


       $post->save();

       
        return redirect('/');  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::find($id);
        $post->load('category', 'user', 'comments.user');
        return view('posts.show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

     public function search(Request $request)
    {
        
        $posts = Post::where('title', 'like', "%{$request->search}%")
                ->orWhere('content', 'like', "%{$request->search}%")
                ->paginate(3);

        
        $search_result = $request->search.'の検索結果'.$posts->total().'件';

        return view('posts.index', [
            'posts' => $posts,
            'search_result' => $search_result,
            'search_query'  => $request->search
        ]);
    }

     // $posts = Post::where('title', 'like', "%{$request->search}%")
        //         ->orWhere('content', 'like', "%{$request->search}%")
        //         ->paginate(3);


        // $search_result = $request->search.'の検索結果'.$posts->total().'件';

        // return view('posts.index', [
        //     'posts' => $posts,
        //     'search_result' => $search_result,
        //     'search_query'  => $request->search
        // ]);

}
