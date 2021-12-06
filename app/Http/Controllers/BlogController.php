<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use App\Http\Requests\BlogRequest;

class BlogController extends Controller
{
    /**
     * ブログの一覧を表示
     */
    public function index(Request $request)
    {

        $keyword = $request->input('keyword');
        $category = $request->input('category');

        $categories = Category::all();
        // dd($categories);
        $query = Blog::query();

        if (!empty($keyword)) {
            $query->where('title', 'LIKE', "%{$keyword}%")
                ->orWhere('name', 'LIKE', "%{$keyword}%")
                ->orWhere('content', 'LIKE', "%{$keyword}%");
        }
        if (!empty($category)) {
            $query->where('category_id', 'LIKE', "%{$keyword}%");
        }

        $blogs = $query->orderBy('updated_at', 'desc')->paginate(10);
        return view('blog.index', compact('blogs', 'keyword', 'categories'));
    }

    /**
     * ブログの詳細を表示
     * @param int $id
     */
    public function show($id)
    {
        $blog = DB::table('blogs')->find($id);

        if (!$blog) {
            \Session::flash('err_msg', 'データがありません.');
            return redirect(route('blog.index'));
        }

        return view('blog.show', ['blog' => $blog]);
    }

    /**
     * ブログの登録画面を表示
     * @param int $id
     */
    public function create()
    {
        $categories = Category::all();
        return view('blog.create', compact('categories'));
    }

    /**
     * ブログの新規登録
     */
    public function store(BlogRequest $request)
    {
        $inputs = $request->all();
        \DB::beginTransaction();
        try {
            //ブログ登録
            Blog::create($inputs);
            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg', 'ブログ登録をしました。');
        return redirect(route('blog.index'));
    }

    /**
     * ブログの編集フォームを表示
     * @param int $id
     */
    public function edit($id)
    {
        $categories = Category::all();
        $blog = DB::table('blogs')->find($id);

        if (!$blog) {
            \Session::flash('err_msg', 'データがありません.');
            return redirect(route('blog.index'));
        }

        return view('blog.edit', compact('blog', 'categories'));
    }

    /**
     * ブログの更新
     */
    public function update(BlogRequest $request)
    {
        $inputs = $request->all();

        \DB::beginTransaction();
        try {
            //ブログ更新
            $blog = Blog::find($inputs['id']);
            $blog->fill([
                'title' => $inputs['title'],
                'name' => $inputs['name'],
                'content' => $inputs['content'],
                'category_id' => $inputs['category_id'],
            ]);
            $blog->save();
            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg', 'ブログを更新しました。');
        return redirect(route('blog.index'));
    }

    /**
     * ブログ削除
     * @param int $id
     */
    public function delete($id)
    {
        if (empty($id)) {
            \Session::flash('err_msg', 'データがありません。');
            return redirect(route('blog.index'));
        }

        try {
            // ブログを削除
            Blog::destroy($id);
        } catch (\Throwable $e) {
            abort(500);
        }

        \Session::flash('err_msg', '削除しました。');
        return redirect(route('blog.index'));
    }
}
