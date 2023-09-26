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
}
