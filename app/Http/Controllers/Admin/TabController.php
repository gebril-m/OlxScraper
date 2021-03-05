<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tab;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TabRepository;
use App\Http\Requests\TabCreateRequest;

class TabController extends Controller
{
    public $tabrepo;

    public function __construct(TabRepository $tabrepository)
    {
        $this->tabrepo=$tabrepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tabs=\App\Models\Tab::all();
        return view('admin.scrap.tabs.index',compact('tabs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$advertisings=\App\Models\Advertising::latest()->get();
        return view('admin.scrap.tabs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TabCreateRequest $request)
    {
        $tab=$this->tabrepo->create($request->all());
        return redirect(url('tabs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tab  $tab
     * @return \Illuminate\Http\Response
     */
    public function show(Tab $tab)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tab  $tab
     * @return \Illuminate\Http\Response
     */
    public function edit(Tab $tab)
    {
        $advertisings=\App\Models\Advertising::all();
        return view('admin.scrap.tabs.edit',compact('advertisings','tab'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tab  $tab
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tab $tab)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tab  $tab
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tab $tab)
    {
        //
    }
}
