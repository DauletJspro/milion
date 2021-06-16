<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends BaseController
{
    public function all(Request $request)
    {
        $news = News::all()->toArray();
        if (isset($request->from_date) && isset($request->till_date)) {
            $news = News::whereBetween('created_at', [$request->from_date, $request->till_date])->get()
            ->toArray();
        }

        return $this->sendResponse($news);
    }

    public function newsById(Request $request)
    {
        $oneNews = News::find($request->id);
        if ($oneNews) {
            $oneNews = $oneNews->toArray();
            return $this->sendResponse($oneNews);
        }
        return $this->sendError('По указанному id новость не найдено !!');
    }
}
