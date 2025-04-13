<?php

namespace App\Exports;

use App\Models\M_Transaction;
use App\Models\M_TransactionDetail;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class TransacationsExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $data['transactions'] = Transaction::orderBy('id','desc')->get();
        $data['transactions']->each(function ($transaction) {
            // Ambil detail transaksi berdasarkan 'transaction_id'
            $transaction->details = TransactionDetail::where('transaction_id', $transaction->id)
                ->with('product')  // Menambahkan relasi produk
                ->get();
        });
        return view('Page.xlsx.transaction',$data);
    }
}
