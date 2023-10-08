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

    public function EditCategory($id){
        $category = Category::findOrFail($id);
        return view('backend.category.edit_category', compact('category'));
    }

    public function UpdateCategory(Request $request){
        $cat_id = $request->id;
        $old_image = $request->old_image;

        if($request->file('category_image')){
            
            $image = $request->file('category_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(120, 120)->save('upload/category/'.$name_gen);
            $save_url = 'upload/category/'.$name_gen;

            if(file_exists($old_image)){
                unlink($old_image);
            }
    
            Category::findOrFail($cat_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
                'category_image' => $save_url,
            ]);
    
            $notification = array(
                'message' => 'Category Updated With Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all-category')->with($notification);

        }else{
    
            Category::findOrFail($cat_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
            ]);
    
            $notification = array(
                'message' => 'Category Updated Without Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all-category')->with($notification);
        }
    }

    public function DeleteCategory($id){
        
        $category = Category::find($id);
        $img = $category->category_image;
        unlink($img);

        Category::find($id)->delete();

        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
 
    }
}
