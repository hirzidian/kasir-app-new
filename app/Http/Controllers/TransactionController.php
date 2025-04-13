<?php

namespace App\Http\Controllers;

use App\Exports\TransacationsExport;
use App\Models\Customers;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        {
            $data['transaction_details'] = TransactionDetail::get();
            $data['transactions'] = Transaction::with('transaction_details','customer','user')->orderBy('id','desc')->get();
            // Tambahkan properti 'details' ke setiap transaksi
            $data['transactions']->each(function ($transaction) {
                // Ambil detail transaksi berdasarkan 'transaction_id'
                $transaction->details = TransactionDetail::where('transaction_id', $transaction->id)
                    ->with('product')  // Menambahkan relasi produk
                    ->get();
            });
            return view('page.transaction.index',$data);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->back()->with('error','Tidak ada produk yang dipilih');
    }
    
    /**
     * Display the specified resource.
     */
    public function show()
    {
        {
            $data['products'] = Product::all();
            return view('page.transaction.show',$data);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        $products = $r->shop;

        if (!$products) {
            return redirect()->back()->with('error', 'Tidak ada produk yang dipilih');
        }

        $data['products'] = [];
        $data['total_price'] = 0;

        foreach ($products as $product) {
            $productResult = explode(';', $product);

            $id = $productResult[0];
            $name = $productResult[1];
            $price = $productResult[2];
            $quantity = $productResult[3]; // ambil product_total
            $sub_total = $productResult[4]; // ambil sub_total

            if (isset($data['products'][$id])) {
                $data['products'][$id]['product_total'] += $quantity;
                $data['products'][$id]['sub_total'] += $sub_total;
            } else {
                $data['products'][$id] = [
                    'id' => $id,
                    'name' => $name,
                    'price' => $price,
                    'product_total' => $quantity,
                    'sub_total' => $sub_total,
                ];
            }
        }

        $data['total_price'] = array_sum(array_column($data['products'], 'sub_total'));

        return view('page.transaction.create', $data);
    }

    public function storeSales(Request $request)
    {
        $customer = null;
        $products = $request->shop;
        $data['total_price'] = $request->total_price;

        if ($request->member === "Member") {
            foreach ($products as $product) {
                $productResult = explode(';', $product);
                $productId = $productResult[0];
                $quantity = $productResult[3]; // product_total

                $stock = Product::find($productId)->stock;
                if ($stock < $quantity) {
                    return redirect()->route('transactions.index')->with('error', 'Stok kurang untuk salah satu produk!');
                }
            }

            $existMember = Customers::where('no_hp', $request->no_hp)->first();

            if ($existMember) {
                $existMember->update([
                    'total_point' => $existMember->total_point + ((int)$data['total_price'] / 100),
                ]);
            } else {
                Customers::create([
                    'no_hp' => $request->no_hp,
                    'total_point' => (int)$data['total_price'] / 100,
                ]);
            }

            $customer = Customers::where('no_hp', $request->no_hp)->first()->id;
        }

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'customer_id' => $customer,
            'total_price' => $data['total_price'],
            'total_payment' => setNumber($request->total_payment),
            'total_return' => setNumber($request->total_payment) - (int)$data['total_price'],
            'point' => (int)$data['total_price'] / 100,
            'used_point' => 0,
        ]);

        foreach ($products as $product) {
            $productResult = explode(';', $product);
            $id = $productResult[0];
            $quantity = $productResult[3];
            $sub_total = $productResult[4];

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $id,
                'quantity' => $quantity,
                'sub_total' => $sub_total,
            ]);

            Product::find($id)->decrement('stock', $quantity);
        }

        return $request->member === "Member"
            ? redirect()->route('transactions.sale.member', $transaction->id)
            : redirect()->route('transactions.sale.print', $transaction->id);
    }


    public function updateSales($id)
    {
        $data['transaction'] = Transaction::with('customer')->findOrFail($id);
        $data['transaction_details'] = TransactionDetail::where('transaction_id',$id)->with('product')->get();
        // Ambil ID customer langsung dari transaksi yang sudah didapatkan sebelumnya
        $customerId = $data['transaction']->customer_id;

        // Cek apakah ada transaksi lain selain transaksi ini
        $data['isMany'] = Transaction::where('customer_id', $customerId)
            ->where('id', '!=', $id) // Pastikan tidak menghitung transaksi saat ini
            ->exists() ? false : true;
        return view('page.transaction.member', $data);
    }

    public function printDetailStore(Request $request, $id)
    {
        $data['transaction'] = Transaction::with('customer')->findOrFail($id);
        $customer = Customers::where('id',$data['transaction']->customer_id)->first();
        $customer->update([
            'name' => $request->name,
        ]);
        if($request->check_poin){
            $data['transaction']->update([
                'used_point' => $customer->total_point,
                'total_return' => $data['transaction']->total_return + $customer->total_point
            ]);
            $customer->update([
                'total_point' => 0,
            ]);
        }
        return redirect()->route('transactions.sale.print', $id);
    }

    public function printDetail($id)
    {
        $data['transaction'] = Transaction::with('customer')->findOrFail($id);
        $data['transaction_details'] = TransactionDetail::where('transaction_id',$id)->with('product')->get();
        $data['customer'] = Customers::where('id',$data['transaction']->customer_id)->first();
        return view('Page.transaction.detailPrint',$data);
    }

public function pdf($id){
    $data['transaction_details'] = TransactionDetail::where('id',$id)->get();
    $data['transaction'] = Transaction::with('customer')->findOrFail($id);
    $data['customer'] = Customers::where('id',$data['transaction']->customer_id)->first();
    // return view('pages.pdf.transaction',$data);
    $pdf = Pdf::loadView('page.pdf.transaction',$data);
    $pdf = $pdf->setPaper('A4', 'portrait');
    return $pdf->download('laporan-pembelian.pdf');
}

public function excel(){
    // return view('pages.transaction.excel');
    return Excel::download(new TransacationsExport, 'laporan-pembelian.xlsx');
}

}
