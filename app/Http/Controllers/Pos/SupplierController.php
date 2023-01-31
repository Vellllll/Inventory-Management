<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Models\Supplier;

class SupplierController extends Controller
{
    public function allSuppliersPage(){
        // $suppliers = Supplier::all();
        $suppliers = Supplier::latest()->get();
        return view('backend.supplier.all_suppliers')->with([
            'suppliers' => $suppliers
        ]);
    }

    public function addSupplierPage(){
        return view('backend.supplier.add_supplier');
    }

    public function addSupplier(Request $request){
        Supplier::insert([
            'name' => $request->name,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'address' => $request->address,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Supplier Added!',
            'alert-type' => 'success',
        );

        return redirect()->route('all.suppliers.page')->with($notification);
    }

    public function editSupplierPage($id){
        $supplier = Supplier::findOrFail($id);

        return view('backend.supplier.edit_supplier')->with([
            'supplier' => $supplier
        ]);
    }

    public function editSupplier(Request $request, $id){
        $supplier = Supplier::find($id);

        $supplier->update([
            'name' => $request->name,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'address' => $request->address,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Supplier Updated!',
            'alert-type' => 'success',
        );

        return redirect()->route('all.suppliers.page')->with($notification);
    }

    public function deleteSupplier($id){
        $supplier = Supplier::findOrFail($id);

        $supplier->delete();

        $notification = array(
            'message' => 'Supplier Deleted!',
            'alert-type' => 'success',
        );

        return redirect()->route('all.suppliers.page')->with($notification);
    }
}
