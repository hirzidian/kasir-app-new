<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast;

class ProductController extends Controller
{

    public function index(request $request)
    {

        $query = Product::query();
        if($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->get();
        return view('Page.Product.index', compact('products'));
    }

    public function create()
    {
        return view('Page.Product.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            if($request->hasFile('image')){
                $file = $request->file('image');
                $path = $file->store('product', 'public');
                $validate['image'] = 'storage/' . $path;
            }

            Product::create($validate);
            return redirect()->route('products.index')->with('success', 'Success Menambahkan Product');
        } catch (\Exception $error) {
            return redirect()->back()->withInput()->with('error', 'Failed Create Product, Try Again');
        }
    }


    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('Page.Product.edit', compact('product'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);

    try {
        $product = Product::findOrFail($id);

        // Jika ada image baru, simpan dan timpa yang lama
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('product', 'public'); // simpan di storage/app/public/product
            $validated['image'] = 'storage/' . $path;
        }

        // Update produk
        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Success Update Product');
    } catch (\Exception $error) {
        return redirect()->back()->withInput()->with('error', 'Failed Update Product, Try Again');
    }
}


    public function destroy(string $id)
    {
        $products = Product::findOrFail($id);
        $products->delete();
        return redirect()->route('products.index')->with('success', 'Success Delete Product');
    }
}
