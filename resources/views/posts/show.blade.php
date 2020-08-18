@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Borad</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   
                <div class="card">  
                    <div class="card-body">
                      <h5 class="card-title">{{$post->title}}</h5>
                      <h5 class="card-title">
                      カテゴリー名:{{$post->category->category_name}}
                      </h5>
                      <h5 class="card-title">
                      ユザー名:{{$post->user->name}}
                      </h5>
                      <p class="card-text">{{$post->content}}</p>
                       <img src="{{ asset('storage/image/'.$post->image) }}" class="w-100">
                    </div>
                  </div>  
                 
                </div>

                <!-- いかにコメントを投稿するボタンを作成する -->
                <div class="card p-3">  
                
                    <div class="card-body">
                    <!-- いかに投稿されたコメント一覧を表示させる -->
                    @foreach($post->comments as $comment)
                    <p class="card-text">{{$comment-> comment}}</p>
                    投稿者:
                    <a href="{{ route('users.show', $comment->user->id) }}">
                        {{ $comment->user->name }}
                    </a>
                    <hr>
                    @endforeach
                    </div>
                     <a href="{{ route('comments.create', ['post_id' => $post->id]) }}" class="btn btn-primary">コメントをする</a> 
                </div>  

            </div>
            </div>
        </div>
    </div>
</div>
@endsection
