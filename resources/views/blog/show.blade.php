@extends('layouts.head')
@section('title','ブログ詳細')
@section('content')
<div class="container mt-5 p-3 border">
  <p>{{ $blog->updated_at }}</p>
  <h2>
    タイトル：<br />
    {{ $blog->title  }}
  </h2>
  <p>
    投稿者：<br />
    {{ $blog->name }}
  </p>
  <p>
    記事：<br />
    {{ $blog->content }}
  </p>
</div>
<div class="mt-2">
  <button class="p-2"><a href="{{ route('blog.index') }}">一覧へ戻る</a></button>
</div>
@endsection
