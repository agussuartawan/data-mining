<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\StoreGroupRequest;
use Illuminate\Http\Request;


class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Group Produk";
        $subtitle = "Group Baru";
        $method = FALSE;
        $route = "group.store";
        $groups = Group::all();
        return view('product.group.index', compact('title', 'groups', 'method', 'route', 'subtitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRequest $request)
    {
        Group::create($request->validated());
        return redirect()->route('group.index')->with('success', 'Grup Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        $title = "Group Produk";
        $subtitle = "Edit Grup";
        $method = TRUE;
        $route = "group.update";
        $groups = Group::all();
        return view('product.group.index', compact('title', 'groups', 'method', 'route', 'group', 'subtitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('group.index')->with('success', 'Data grup berhasil dihapus');
    }
}
