<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cabinet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CabinetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $cabinets = Cabinet::all();
        return view('cabinets.index', ['cabinets' => $cabinets]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('cabinets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), (new Cabinet())->rules());
        if ($validation->fails()) {
            $request->session()->flash('danger', $validation->errors()->all());
            return back()->withInput();
        }

        $cabinet = new Cabinet();
        $cabinet->fill($request->all());
        $cabinet->save();

        $request->session()->flash('success', 'Вы успешно добавили студента!');
        return redirect(route('cabinet.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Cabinet $cabinet
     * @return \Illuminate\Http\Response
     */
    public function show(Cabinet $cabinet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Cabinet $cabinet
     * @return \Illuminate\Http\Response
     */
    public function edit(Cabinet $cabinet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Cabinet $cabinet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cabinet $cabinet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Cabinet $cabinet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cabinet $cabinet)
    {
        //
    }
}
