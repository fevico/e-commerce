<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    // 

    public function AllCategory(){
        $category = Category::latest()->get();
        return view('backend.category.all_category', compact('category'));
    }

    public function AddCategory(){
        return view('backend.category.add_category');
    }

    public function StoreCategory(Request $request){

            $image = $request->file('category_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(120, 120)->save('upload/category/'.$name_gen);
            $save_url = 'upload/category/'.$name_gen;
    
            Category::insert([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
                'category_image' => $save_url,
            ]);
    
            $notification = array(
                'message' => 'Category Inserted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all-category')->with($notification);
    }
}
