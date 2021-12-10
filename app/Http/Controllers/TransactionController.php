<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\FileList;
use App\Imports\TransactionsImport;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
	public function index($id)
	{
		$transactions = [];
		if ($id >= 0 && $id != 'latest') {
			$transactions = Transaction::where('file_list_id', $id)->orderBy('no_invoice', 'desc')->get();
		} elseif ($id == 'latest') {
			$filelist_latest = FileList::select('id')->latest()->first();
			if ($filelist_latest) {
				$transactions = Transaction::where('file_list_id', $filelist_latest->id)->orderBy('no_invoice', 'desc')->get();
			}
		}

		$title = "Transaksi Penjualan";
		return view('transaction.index', compact('title', 'transactions'));
	}

	public function create()
	{
		$title = "Transaksi Penjualan";
		return view('transaction.create', compact('title'));
	}

	public function filelist()
	{
		$filelist = FileList::latest()->get();
		$title = "Transaksi Penjualan";
		return view('transaction.filelist', compact('title', 'filelist'));
	}

	public function import(Request $request)
	{
		$request->validate(
			[
				'file' => 'required|mimes:xlsx,xls'
			],
			[
				'file.required' => 'Pilih file terlebih dahulu.',
				'file.mimes' => 'File harus berupa excel.'
			]
		);

		Excel::import(new TransactionsImport, $request->file('file'));

		return redirect()->route('transaction.data', 'latest')->with('success', 'Import Berhasil');
	}

	public function show(Transaction $transaction)
	{
		$title = "Transaksi Penjualan";
		return view('transaction.show', compact('transaction', 'title'));
	}
}
