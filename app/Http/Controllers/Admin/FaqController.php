<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('faqs.create');
    }

    public function store(Request $request)
    {
        if (Faq::create($request->all())) {
            $request->session()->flash('success', 'Вы успешно добавили FAQ');
            return redirect(route('faq.index'));
        }
        $request->session()->flash('danger', 'Произошла ошибка');
        return back()->withInput();

    }

    public function edit(Faq $faq)
    {
        return view('faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        if ($faq->update($request->all())) {
            session()->flash('success', 'Вы успешно изменили FAQ');
            return redirect(route('faq.index'));
        }
        session()->flash('danger', 'Произошла ошибка при изменение');
        return redirect(route('faq.index'));
    }

    public function destroy(Faq $faq)
    {
        if ($faq->delete()) {
            session()->flash('success', 'Вы успешно удалили FAQ');
            return redirect(route('faq.index'));
        }
        session()->flash('danger', 'Произошла ошибка при удаление');
        return redirect(route('faq.index'));
    }
}
