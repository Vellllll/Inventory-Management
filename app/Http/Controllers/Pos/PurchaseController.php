<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Models\Purchase;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;

class PurchaseController extends Controller
{
    public function allPurchasePage(){
        $purchases = Purchase::orderBy('date', 'desc')->orderBy('id','desc')->get();
        return view('backend.purchase.all_purchase')->with([
            'purchases' => $purchases
        ]);
    }

    public function addPurchasePage(){
        $categories = Category::all();
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('backend.purchase.add_purchase')->with([
            'categories' => $categories,
            'suppliers' => $suppliers,
            'products' => $products
        ]);
    }

    public function addPurchase(Request $request){
        if($request->category_id == null){
            $notification = array(
                'message' => "You don't choose any product!",
                'alert-type' => 'error',
            );

            return redirect()->back()->with($notification);
        } else {
            $count_product = count($request->category_id);
            for($i = 0; $i < $count_product; $i++){
                $purchase = new Purchase();
                $purchase::insert([
                    'supplier_id' => $request->supplier_id[$i],
                    'category_id' => $request->category_id[$i],
                    'product_id' => $request->product_id[$i],
                    'purchase_no' => $request->purchase_number[$i],
                    'date' => date('Y-m-d', strtotime($request->date[$i])),
                    'description' => $request->description[$i],
                    'buying_qty' => $request->buying_qty[$i],
                    'unit_price' => $request->unit_price[$i],
                    'buying_price' => $request->buying_price[$i],
                    'status' => '0',
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);
            }
            $notification = array(
                'message' => "Purchase Added!",
                'alert-type' => 'success',
            );

            return redirect()->route('all.purchases.page')->with($notification);
        }
    }

    public function deletePurchase($id){
        $purchase = Purchase::findOrFail($id);
        $purchase->delete();

        $notification = array(
            'message' => "Purchase Deleted!",
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }

    public function approvePurchasePage(){
        $purchases = Purchase::orderBy('date', 'desc')->orderBy('id','desc')->where('status', '0')->get();
        return view('backend.purchase.purchase_approval')->with([
            'purchases' => $purchases
        ]);
    }

    public function approvePurchase($id){
        $purchase = Purchase::findOrFail($id);
        $product = Product::where('id', $purchase->product_id)->first();

        $purchase_qty = ((float)($purchase->buying_qty)) + ((float)($product->quantity));

        $product->update([
            'quantity' => $purchase_qty,
        ]);

        $purchase->update([
            'status' => '1',
        ]);

        $notification = array(
            'message' => "Purchase Approved!",
            'alert-type' => 'success',
        );

        return redirect()->route('all.purchases.page')->with($notification);
    }

    public function dailyPurchaseReport(){
        return view('backend.purchase.daily_purchase_report');
    }

    public function dailyPurchaseReportPdf(Request $request){
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));

        $purchases = Purchase::whereBetween('date', [$start_date,$end_date])->where('status','1')->get();

        return view('backend.pdf.daily_purchase_report')->with([
            'purchases' => $purchases,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }
}
