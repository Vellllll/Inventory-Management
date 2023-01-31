<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Category;

class ProductController extends Controller
{
    public function allProductsPage(){
        $products = Product::latest()->get();

        return view('backend.product.all_products')->with([
            'products' => $products
        ]);
    }

    public function addProductPage(){
        $suppliers = Supplier::all();;
        $units = Unit::all();
        $categories = Category::all();

        return view('backend.product.add_product')->with([
            'suppliers' => $suppliers,
            'units' => $units,
            'categories' => $categories
        ]);
    }

    public function addProduct(Request $request){
        Product::insert([
            'supplier_id' => $request->supplier_id,
            'unit_id' => $request->unit_id,
            'category_id' => $request->category_id,
            'name' => $request->product_name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Product Added!',
            'alert-type' => 'success',
        );

        return redirect()->route('all.products.page')->with($notification);
    }

    public function editProductPage($id){
        $product = Product::findOrFail($id);
        $suppliers = Supplier::all();
        $units = Unit::all();
        $categories = Category::all();

        return view('backend.product.edit_product')->with([
            'product' => $product,
            'suppliers' => $suppliers,
            'units' => $units,
            'categories' => $categories
        ]);
    }

    public function editProduct(Request $request, $id){
        $product = Product::find($id);

        $product->update([
            'supplier_id' => $request->supplier_id,
            'unit_id' => $request->unit_id,
            'category_id' => $request->category_id,
            'name' => $request->product_name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Product Updated!',
            'alert-type' => 'success',
        );

        return redirect()->route('all.products.page')->with($notification);
    }

    public function deleteProduct($id){
        $product = Product::findOrFail($id);
        $product->delete();

        $notification = array(
            'message' => 'Product Deleted!',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }
}
