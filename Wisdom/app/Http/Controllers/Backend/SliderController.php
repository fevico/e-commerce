<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    //
    public function AllSlider(){
        $slider = Slider::latest()->get();
        return view('backend.slider.all_slider', compact('slider'));
    }

    public function AddSlider(){
        return view('backend.slider.add_slider');
    }

    public function storeSlider(Request $request){

        $image = $request->file('slider_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(2376, 807)->save('upload/slider/'.$name_gen);
        $save_url = 'upload/slider/'.$name_gen;

        Slider::insert([
            'slider_title' => $request->slider_title,
            'short_title' => $request->short_title,
            'slider_image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Slider Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all-slider')->with($notification);
    }

    public function EditSlider($id){
        $slider = Slider::findOrFail($id);
        return view('backend.slider.edit_slider', compact('slider'));
    }

    public function UpdateSlider(Request $request){
        $slider_id = $request->id;
        $old_img = $request->old_img;

        if($request->file('slider_image')){
            
            $image = $request->file('slider_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(2376, 807)->save('upload/slider/'.$name_gen);
            $save_url = 'upload/slider/'.$name_gen;

            if(file_exists($old_img)){
                unlink($old_img);
            }
    
            Slider::findOrFail($slider_id)->update([
                'slider_title' => $request->slider_title,
                'short_title' => $request->short_title,
                'slider_image' => $save_url,
            ]);
    
            $notification = array(
                'message' => 'Slider Updated With Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all-slider')->with($notification);

        }else{
    
            Slider::findOrFail($slider_id)->update([
                'slider_title' => $request->slider_title,
                'short_title' => $request->short_title,
            ]);
    
            $notification = array(
                'message' => 'Slider Updated Without Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all-slider')->with($notification);
        }
    }

    public function DeleteSlider($id){
        $sliders = Slider::find($id);
        $img = $sliders->slider_image;
        unlink($img);

        Slider::find($id)->delete();

        $notification = array(
            'message' => 'Slider Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
