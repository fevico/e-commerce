<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Category;

class SubcategoryController extends Controller
{
    // 
    public function AllSubcategory(){
     $subcat = Subcategory::latest()->get();
     return view('backend.subcategory.all_subcategory', compact('subcat'));
    }

    public function AddSubcategory(){
        $categories = Category::orderBy('category_name', 'ASC')->get();
        return view('backend.subcategory.add_subcategory', compact('categories'));
    }

    public function StoreSubcategory(Request $request){
        Subcategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name' =>$request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
        ]);
            
        $notification = array(
            'message' => 'Subcategory Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all-subcategory')->with($notification);
    }

    public function EditSubcategory($id){
      $categories = Category::orderBy('category_name', 'ASC')->get();
      $subcategory = Subcategory::findOrFail($id);  
        return view('backend.subcategory.edit_subcategory', compact('subcategory','categories'));
    }

    public function UpdateSubcategory(Request $request){
        $id = $request->id;
        Subcategory::findOrFail($id)->update([
            'category_id' => $request->category_id,
            'subcategory_name' =>$request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
        ]);

        $notification = array(
            'message' => 'Subcategory Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all-subcategory')->with($notification);
    }

    public function DeleteSubcategory($id){
        Subcategory::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Subcategory Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
