@extends('layouts.head')
@section('title','ブログ一覧')
@section('content')
<div>
  <form class="text-center mt-5" action="{{ route('blog.index') }}" method="get">
    @csrf
    <p>
      <input type="text" name="keyword" value="{{ $keyword }}">
      <input type="submit" value="検索">
    </p>
  </form>

  @if(session('err_msg'))
  <p class="text-danger">
    {{session('err_msg')}}
  </p>
  @endif
  <table class="table table-striped">
    <tr>
      <th>ジャンル・日付</th>
      <th>タイトル・投稿者</th>
      <th>内容</th>
      <th></th>
    </tr>
    @foreach($blogs as $blog)
    <tr>
      <td>
        {{ $blog->updated_at->format('Y-m-d') }}
        <br /><br />
        {{ $blog->category->name }}
      </td>
      <td>
        {{ $blog->title  }}
        <br /><br />
        投稿者:{{ $blog->name }}
      </td>
      <td><a href="{{ route('blog.show', $blog->id) }}">{{Str::limit($blog->content, 200, '(続きを読む…)' )}}</a></td>
      <td>
        <button class="mt-2"><a href="{{ route('blog.show', $blog->id) }}">詳細</a></button>
        <br />
        <button class="mt-2"><a href="{{ route('blog.edit', $blog->id) }}">編集</a></button>
        <br />
        <form class="mt-2" method="POST" action="{{ route('blog.delete', $blog->id) }}" onSubmit="return checkDelete()">
          @csrf
          <button type="submit" class="btn btn-primary" onclick=>削除</button>
        </form>
      </td>
    </tr>
    @endforeach
  </table>
</div>
<div class="d-flex justify-content-center pb-5">
  {{ $blogs->appends(request()->query())->links() }}
</div>
<script>
  function checkDelete() {
    if (window.confirm('削除してよろしいですか？')) {
      return true;
    } else {
      return false;
    }
  }
</script>
@endsection
