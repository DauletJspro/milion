<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();
        return view('news.index', compact('news'));
    }

    public function create()
    {
        return view('news.create');
    }


    public function add_news(Request $request)
    {
        $validation = Validator::make($request->all(), News::rules());
        if ($validation->fails()) {
            $request->session()->flash('danger', $validation->errors()->all());
            return back()->withInput();
        }
        $file = new FileUpload(new News());
        $upload_result = $file->upload($request);
        try {
            DB::table('news')->insert([
                'name' => $request->name,
                'title' => $request->title,
                'is_important' => isset($request->is_important) ?? 1,
                'is_active' => isset($request->is_active) ?? 1,
                'author_id' => Auth::user()->id,
                'content' => $request->news_content,
                'image' => 'news/' . $upload_result['name'],
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ]);
            $request->session()->flash('success', 'Вы успешно добавили новость');
            return redirect(route('news.index'));
        } catch (\Exception $exception) {
            $request->session()->flash('danger', $exception->getMessage());
            $file->rollback($request, $upload_result['name']);
            return back()->withInput();
        }
    }

    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validation = Validator::make($request->all(), News::updateRules());
        if ($validation->fails()) {
            $request->session()->flash('danger', $validation->errors()->all());
            return back()->withInput();
        }

        if ($request->hasFile('image')) {
            $file = new FileUpload(new News());
            $upload_result = $file->upload($request);
        }
        try {
            $data = [
                'name' => $request->name,
                'title' => $request->title,
                'is_important' => isset($request->is_important) ?? 1,
                'is_active' => isset($request->is_active) ?? 1,
                'author_id' => Auth::user()->id,
                'content' => $request->news_content,
                'updated_at' => date('Y-m-d')
            ];
            if (isset($upload_result)) {
                $data['image'] = 'news/' . $upload_result['name'];
            }


            $news->update($data);

            $request->session()->flash('success', 'Вы успешно изменили новость');
            return redirect(route('news.index'));
        } catch (\Exception $exception) {
            $request->session()->flash('danger', $exception->getMessage());
            if ($request->hasFile('image')) {
                $file->rollback($request, $upload_result['name']);
            }
            return back()->withInput();
        }

    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect(route('news.index'));
    }
}
