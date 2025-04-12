<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\detail_purchase;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index(){
        $purchases = Purchase::with('user')->get();
        return view('Page.Purchase.index', compact('purchases'));
    }

    public function product(){
        $products = Product::all();
        return view('Page.Purchase.product', compact('products'));
    }

    public function create(Request $request){
        $data = $request->input('data');

        if (!$data || !is_array($data)) {
            return redirect()->route('purchases.product')->with('error', 'Tidak ada produk yang dipilih.');
        }

        $produkTerpilih = [];
        $duplikatIds = [];

        foreach ($data as $item) {
            list($productId, $quantity, $subtotal) = explode(';', $item);

            $product = Product::find((int) $productId);
            if (!$product) continue;

            if (isset($produkTerpilih[$productId])) {
                $produkTerpilih[$productId]['qty'] += (int) $quantity;
                $produkTerpilih[$productId]['subtotal'] += (int) $subtotal;
                $duplikatIds[$productId] = true;
            } else {
                $produkTerpilih[$productId] = [
                    'id'       => $product->id,
                    'name'     => $product->name,
                    'price'    => $product->price,
                    'image'    => $product->image,
                    'qty'      => (int) $quantity,
                    'subtotal' => (int) $subtotal,
                    'is_double' => false,
                ];
            }
        }

        foreach ($duplikatIds as $id => $value) {
            $produkTerpilih[$id]['is_double'] = true;
        }

        $pembelians = array_values($produkTerpilih);
        $total = array_sum(array_column($pembelians, 'subtotal'));

        return view('Page.Purchase.create', compact('pembelians', 'total'));
    }

    public function store(Request $request){
        $data = $request->input('shop');

        if (!$data || !is_array($data)) {
            return back()->with('error', 'Tidak ada produk yang dipilih.');
        }

        $total = array_sum(array_map(function ($item) {
            return explode(';', $item)[4];
        }, $data));

        $totalPay = (int) str_replace('.', '', $request->input('total_pay'));
        if ($totalPay < $total) {
            return redirect()->back()->with('error', 'Jumlah bayar belum mencukupi.');
        }

        if ($request->member === 'Member') {
            session([
                'shop' => $data,
                'total_price' => $total,
                'total_pay' => $totalPay
            ]);
            return redirect()->route('purchases.sale.member');
        }

        DB::beginTransaction();
        try {
            $kembalian = $totalPay - $total;

            $purchases = Purchase::create([
                'sale_date'     => now(),
                'total_price'   => $total,
                'total_pay'     => $totalPay,
                'total_return'  => $kembalian,
                'customer_id'   => null,
                'user_id'       => Auth::id(),
                'point'         => $total / 100,
                'total_point'   => 0,
            ]);

            foreach ($data as $item) {
                list($productId, $productName, $productPrice, $quantity, $subtotal) = explode(';', $item);

                $product = Product::find($productId);
                if (!$product || $product->stock < (int) $quantity) {
                    throw new \Exception("Stok tidak cukup untuk produk: {$product->name}");
                }

                $product->stock -= (int) $quantity;
                $product->save();

                detail_purchase::create([
                    'sale_id'    => $purchases->id,
                    'product_id' => $productId,
                    'amount'     => (int) $quantity,
                    'subtotal'   => (int) $subtotal,
                ]);
            }

            DB::commit();
            return redirect()->route('purchases.invoice', $purchases->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function storeSales(Request $request)
    {
        $shop = session('shop');
        $total_price = session('total_price');
        $total_pay = session('total_pay');

        if (!$shop || !is_array($shop)) {
            return redirect()->route('purchases.create')->with('error', 'Tidak ada produk yang dipilih.');
        }

        return view('Page.Purchase.member', compact('shop', 'total_price', 'total_pay'));
    }

    public function updateSales($id)
    {
        $transaction = Purchase::with('customer')->findOrFail($id);
        $transaction_details = detail_purchase::where('sale_id', $id)->with('product')->get();
    
        $customerId = $transaction->customer_id;
    
        $isMany = !Purchase::where('customer_id', $customerId)
            ->where('id', '!=', $id)
            ->exists();
    
        return view('Page.Purchase.member', compact('transaction', 'transaction_details', 'isMany'));
    }
    

    public function invoice($id)
    {
        $data['purchase'] = Purchase::with('customer')->findOrFail($id);
        $data['purchase_details'] = detail_purchase::where('sale_id', $id)->with('product')->get();
        $data['customer'] = Customers::find($data['purchase']->customer_id);

        return view('Page.Purchase.invoice', $data)->with('success', 'berhasil');
    }

    // public function printDetailStore(Request $r,$id){
    //     $data['transaction'] = M_Transaction::with('customer')->findOrFail($id);
    //     $customer = M_Customer::where('id',$data['transaction']->customer_id)->first();
    //     $customer->update([
    //         'name' => $r->name,
    //     ]);
    //     if($r->check_poin){
    //         $data['transaction']->update([
    //             'used_point' => $customer->total_point,
    //             'total_return' => $data['transaction']->total_return + $customer->total_point
    //         ]);
    //         $customer->update([
    //             'total_point' => 0,
    //         ]);
    //     }
    //     return redirect()->route('transaction.sale.print', $id);
    // }

    // public function printDetail($id){
    //     $data['transaction'] = M_Transaction::with('customer')->findOrFail($id);
    //     $data['transaction_details'] = M_TransactionDetail::where('transaction_id',$id)->with('product')->get();
    //     $data['customer'] = M_Customer::where('id',$data['transaction']->customer_id)->first();
    //     return view('pages.transaction.detailPrint',$data);
    // }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('Page.Product.edit', compact('product'));
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
