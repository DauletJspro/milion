<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends BaseController
{
    public function all()
    {
        $faqs = Faq::all()->toArray();
        return $this->sendResponse($faqs);
    }

    public function faqById(Request $request)
    {
        $faq_id = $request->id;
        $faq = Faq::find($faq_id);
        if (isset($faq)) {
            $faq = $faq->toArray();
            return $this->sendResponse($faq);
        }
        return $this->sendError('Такого faq не существует!!');
    }
}
