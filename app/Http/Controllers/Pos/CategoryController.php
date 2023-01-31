<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Models\Category;

class CategoryController extends Controller
{
    public function allCategoriesPage(){
        $categories = Category::all();

        return view('backend.category.all_categories')->with([
            'categories' => $categories
        ]);
    }

    public function addCategoryPage(){
        return view('backend.category.add_category');
    }

    public function addCategory(Request $request){
        Category::insert([
            'name' => $request->category_name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Category Added!',
            'alert-type' => 'success',
        );

        return redirect()->route('all.categories.page')->with($notification);
    }

    public function editCategoryPage($id){
        $category = Category::findOrFail($id);

        return view('backend.category.edit_category')->with([
            'category' => $category
        ]);
    }

    public function editCategory(Request $request, $id){
        $category = Category::find($id);

        $category->update([
            'name' => $request->category_name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Category Updated!',
            'alert-type' => 'success',
        );

        return redirect()->route('all.categories.page')->with($notification);
    }

    public function deleteCategory($id){
        $category = Category::findOrFail($id);
        $category->delete();

        $notification = array(
            'message' => 'Category Deleted!',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }
}
