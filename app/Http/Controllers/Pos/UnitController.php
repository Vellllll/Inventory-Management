<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Models\Unit;

class UnitController extends Controller
{
    public function allUnitPage(){
        $units = Unit::latest()->get();

        return view('backend.unit.all_units')->with([
            'units' => $units,
        ]);
    }

    public function addUnitPage(){
        return view('backend.unit.add_unit');
    }

    public function addUnit(Request $request){
        Unit::insert([
            'name' => $request->unit_name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Unit Added!',
            'alert-type' => 'success',
        );

        return redirect()->route('all.units.page')->with($notification);
    }

    public function editUnitPage($id){
        $unit = Unit::findOrFail($id);

        return view('backend.unit.edit_unit')->with([
            'unit' => $unit,
        ]);
    }

    public function editUnit(Request $request, $id){
        $unit = Unit::find($id);

        $unit->update([
            'name' => $request->unit_name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Unit Updated!',
            'alert-type' => 'success',
        );

        return redirect()->route('all.units.page')->with($notification);
    }

    public function deleteUnit($id){
        $unit = Unit::findOrFail($id);
        $unit->delete();

        $notification = array(
            'message' => 'Unit Deleted!',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }
}
