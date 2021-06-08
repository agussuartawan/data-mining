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
        $title = "Grup Produk";
        $data = [
            'subtitle' => 'Grup Baru',
            'method' => FALSE,
            'route' => 'product/group',
        ];
        $groups = Group::all();
        return view('product.group.index', compact('title', 'groups', 'data'));
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
        $title = "Grup Produk";
        $data = [
            'subtitle' => 'Edit Grup',
            'method' => TRUE,
            'route' => 'product/group/' . $group->id,
            'group_id' => $group->id,
            'group_name' => $group->name,
        ];
        $groups = Group::all();
        return view('product.group.index', compact('data', 'groups', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $group->update($request->all());
        return redirect()->route('group.index')->with('success', 'Grup berhasil diubah');
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
