@extends('layouts.head')
@section('title','ブログ編集')
@section('content')
<div>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <h2>ブログ編集フォーム</h2>
      <form method="POST" action="{{ route('blog.update') }}" onSubmit="return checkSubmit()">
        @csrf
        <input type="hidden" name="id" value="{{ $blog->id }}">
        <div class="form-group">
          <label for="title">
            タイトル
          </label>
          <input id="title" name="title" class="form-control" value="{{ $blog->title }}" type="text">
          @if ($errors->has('title'))
          <div class="text-danger">
            {{ $errors->first('title') }}
          </div>
          @endif
        </div>
        <div class="form-group">
          <label for="category_id">
            カテゴリ
          </label>
          <select name="category_id" id="category_id">
            @foreach($categories as $category)
            <option value="{{ $category->id }}" @if($category->id === $blog->category_id) selected='selected' @endif>{{ $category->name }}</option>
            @endforeach
          </select>
          @if ($errors->has('category_id'))
          <div class="text-danger">
            {{ $errors->first('category_id') }}
          </div>
          @endif
        </div>
        <div class="form-group">
          <label for="name">
            投稿者
          </label>
          <input id="name" name="name" class="form-control" value="{{ $blog->name }}" type="text">
          @if ($errors->has('name'))
          <div class="text-danger">
            {{ $errors->first('name') }}
          </div>
          @endif
        </div>
        <div class="form-group">
          <label for="content">
            本文
          </label>
          <textarea id="content" name="content" class="form-control" rows="4">{{ $blog->content }}</textarea>
          @if ($errors->has('content'))
          <div class="text-danger">
            {{ $errors->first('content') }}
          </div>
          @endif
        </div>
        <div class="mt-5">
          <a class="btn btn-secondary" href="{{ route('blog.index') }}">
            キャンセル
          </a>
          <button type="submit" class="btn btn-primary">
            更新する
          </button>
        </div>
      </form>
    </div>
  </div>
  <script>
    function checkSubmit() {
      if (window.confirm('更新してよろしいですか？')) {
        return true;
      } else {
        return false;
      }
    }
  </script>
</div>
@endsection
