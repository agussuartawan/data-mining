<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BundleController extends Controller
{
    public function index()
    {
    	$title = "Produk Bundel";
    	return view('bundle.index', compact('title'));
    }

    public function create()
    {
    	$title = "Produk Bundel";
    	return view('bundle.create', compact('title'));
    }
}
