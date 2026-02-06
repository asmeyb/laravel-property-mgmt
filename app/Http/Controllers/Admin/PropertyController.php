<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Time;
use App\Models\Location;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use App\Models\Property;
use App\Models\PropertyGalleryImage;
use Illuminate\Support\Carbon;

class PropertyController extends Controller
{
    public function AllTimes(){
        $times = Time::latest()->get();
        return view('admin.backend.time.all_time',compact('times'));
    } 
    //End Method 

    public function AddTimes(){
    return view('admin.backend.time.add_time');
    }
    //End Method 

    public function StoreTimes(Request $request){

        Time::create([
            'time_name' => $request->time_name,
            'time_hour' => $request->time_hour,
        ]);

        $notification = array(
            'message' => 'Time Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.times')->with($notification);

    }
    //End Method 

    public function EditTimes($id){
        $times = Time::find($id);
        return view('admin.backend.time.edit_time',compact('times'));
    }
    //End Method 

    public function UpdateTimes(Request $request){

        $time_id = $request->id;

        Time::find($time_id)->update([
            'time_name' => $request->time_name,
            'time_hour' => $request->time_hour,
        ]);

        $notification = array(
            'message' => 'Time Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.times')->with($notification);

    }
    //End Method 

    public function DeleteTimes($id){
      
        Time::find($id)->delete();

        $notification = array(
            'message' => 'Time Deleted Successfully',
            'alert-type' => 'success'
        ); 
        return redirect()->back()->with($notification);

    }
    //End Method 

    ///////////// Location Method //////////////

    public function AllLocation(){
        $location = Location::latest()->get();
        return view('admin.backend.location.all_location',compact('location'));
    } 
    //End Method 

    public function AddLocation(){
    return view('admin.backend.location.add_location');
    }
    //End Method 

    public function StoreLocation(Request $request){

        if ($request->hasFile('image')) {
          $image = $request->file('image');
          $manager = new ImageManager(new Driver());
          $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
          $img = $manager->read($image);
          $img->resize(300,395)->save(public_path('upload/location/'.$name_gen));
          $save_url = 'upload/location/'.$name_gen; 
        }

        Location::create([
            'name' => $request->name,
            'image' => $save_url
        ]);

        $notification = array(
            'message' => 'Location Added Successfully',
            'alert-type' => 'success'
        ); 
        return redirect()->route('all.location')->with($notification); 

    }
       //End Method 

    public function EditLocation($id){
        $location = Location::find($id);
        return view('admin.backend.location.edit_location',compact('location'));
    }
    //End Method 


     public function UpdateLocation(Request $request){

        $location_id = $request->id;
        $location = Location::findOrFail($location_id);

        if ($request->hasFile('image')) {
           
          if (File::exists(public_path($location->image))) {
            File::delete(public_path($location->image));
          }  

          $image = $request->file('image');
          $manager = new ImageManager(new Driver());
          $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
          $img = $manager->read($image);
          $img->resize(300,395)->save(public_path('upload/location/'.$name_gen));
          $save_url = 'upload/location/'.$name_gen;  

        Location::find($location_id)->update([
            'name' => $request->name,
            'image' => $save_url
        ]);

        $notification = array(
            'message' => 'Location Added Successfully',
            'alert-type' => 'success'
        ); 
        return redirect()->route('all.location')->with($notification); 
     
    } else{

        Location::find($location_id)->update([
            'name' => $request->name, 
        ]);

        $notification = array(
            'message' => 'Location Added Successfully',
            'alert-type' => 'success'
        ); 
        return redirect()->route('all.location')->with($notification);  
     } 

    }
       //End Method 

    public function DeleteLocation($id){
        $location = Location::findOrFail($id);

        // Delete main image
        if ($location->image && file_exists(public_path($location->image))) {
           unlink(public_path($location->image));
        }

        Location::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Location Deleted Successfully',
            'alert-type' => 'success'
        ); 
        return redirect()->back()->with($notification);  

    }
    //End Method 

    /////////////// Property All Method 

   public function AllProperty(){
    $allData = Property::orderBy('id','desc')->get();
    return view('admin.backend.property.all_property',compact('allData')); 
   }
   //End Method 

   public function AddProperty(){
    $location = Location::get();
    $times = Time::get();
    return view('admin.backend.property.add_property',compact('location','times'));
   }
   //End Method 

   public function StoreProperty(Request $request){

    $validated = $request->validate([
        'image' => 'required|image|mimes:png,jpg,jpeg,gif,webp|max:2048',
        'title' => 'required',
        'slug' => 'required'
    ]);

    $save_url = null;

     if ($request->hasFile('image')) {
          $image = $request->file('image');
          $manager = new ImageManager(new Driver());
          $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
          $img = $manager->read($image);
          $img->resize(555,370)->save(public_path('upload/property/'.$name_gen));
          $save_url = 'upload/property/'.$name_gen; 
        }

     // Installment Amount 
     $per_installment_amount = null;
     if ($request->investment_type === 'Investment-By-Installment' && $request->total_installment > 0) {
        $perShare = (float) $request->per_share_amount;
        $downPayment = (float) $request->down_payment;
        $downAmount = ($perShare * $downPayment) / 100;
        $remaining = $perShare - $downAmount;
        $per_installment_amount = $remaining / (int) $request->total_installment;
     }

     $property = Property::create([

        'image' => $save_url,
        'title' => $request->title,
        'slug' => $request->slug,
        'location_id' => $request->location_id,
        'time_id' => $request->time_id,
        'location_map' => $request->location_map,
        'details' => $request->details,

        'is_featured' => $request->is_featured,
        'status' => $request->status,
        'investment_type' => $request->investment_type,
        'total_share' => $request->total_share,
        'per_share_amount' => $request->per_share_amount,
        'capital_back' => $request->capital_back,

        'profit_back' => $request->profit_back,
        'profit_type' => $request->profit_type,
        'total_installment' => $request->total_installment,
        'down_payment' => $request->down_payment,
        'per_installment_amount' => $request->per_installment_amount,
        'installment_late_fee' => $request->installment_late_fee,
        'time_between_installment' => $request->time_between_installment,

        'profit_amount_type' => $request->profit_amount_type,
        'minimum_profit_amount' => $request->minimum_profit_amount,
        'profit_amount' => $request->profit_amount,
        'profit_distribution' => $request->profit_distribution,
        'auto_profit_distribution' => $request->auto_profit_distribution,
        'profit_schedule' => $request->profit_schedule,

        'profit_schedule_period' => $request->profit_schedule_period,
        'repeat_time' => $request->repeat_time,
        'created_at' => Carbon::now(), 

     ]);
     $property_id = $property->id;

     /// Multiple Image Upload From Here 
     $images = $request->file('gallery_images');
     if (!empty($images) && is_array($images)) {
        foreach($images as $img){

          $manager = new ImageManager(new Driver());
          $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
          $imgs = $manager->read($img);
          $imgs->resize(840,450)->save(public_path('upload/multi_image/'.$make_name));
          $uploadPath = 'upload/multi_image/'.$make_name; 

          PropertyGalleryImage::insert([
            'property_id' => $property_id,
            'image' => $uploadPath,
            'created_at' => Carbon::now(),
          ]);
        } //End Foreach 
     }
     /// End Multiple Image Upload From Here  

       $notification = array(
            'message' => 'Property Added Successfully',
            'alert-type' => 'success'
        ); 
        return redirect()->route('all.property')->with($notification); 

   }
    //End Method 

   public function EditProperty($id){

    $editData = Property::find($id);
    $location = Location::get();
    $times = Time::get();
    $multiimg = PropertyGalleryImage::where('property_id',$id)->get();
    return view('admin.backend.property.edit_property',compact('editData','location','times','multiimg'));
   }
    //End Method 

   public function GalleryImgDelete($id){

     $image = PropertyGalleryImage::find($id);

        if ($image) {
            $imagePath = public_path($image->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            $image->delete();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Image not found.']); 
   }
    //End Method 


    public function UpdateProperty(Request $request,$id){

    $validated = $request->validate([ 
        'title' => 'required',
        'slug' => 'required'
    ]);

    $property = Property::findOrFail($id);
 

     if ($request->hasFile('image')) {
           if (File::exists(public_path($property->image))) {
                File::delete(public_path($property->image));
            }

          $image = $request->file('image');
          $manager = new ImageManager(new Driver());
          $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
          $img = $manager->read($image);
          $img->resize(555,370)->save(public_path('upload/property/'.$name_gen));
          $save_url = 'upload/property/'.$name_gen; 
        }

     // Installment Amount 
     $per_installment_amount = null;
     if ($request->investment_type === 'Investment-By-Installment' && $request->total_installment > 0) {
        $perShare = (float) $request->per_share_amount;
        $downPayment = (float) $request->down_payment;
        $downAmount = ($perShare * $downPayment) / 100;
        $remaining = $perShare - $downAmount;
        $per_installment_amount = $remaining / (int) $request->total_installment;
     }

     $property->update([

        'image' => $request->hasFile('image') ? $save_url : $property->image,
        'title' => $request->title,
        'slug' => $request->slug,
        'location_id' => $request->location_id,
        'time_id' => $request->time_id,
        'location_map' => $request->location_map,
        'details' => $request->details,

        'is_featured' => $request->is_featured,
        'status' => $request->status,
        'investment_type' => $request->investment_type,
        'total_share' => $request->total_share,
        'per_share_amount' => $request->per_share_amount,
        'capital_back' => $request->capital_back,

        'profit_back' => $request->profit_back,
        'profit_type' => $request->profit_type,
        'total_installment' => $request->total_installment,
        'down_payment' => $request->down_payment,
        'per_installment_amount' => $request->per_installment_amount,
        'installment_late_fee' => $request->installment_late_fee,
        'time_between_installment' => $request->time_between_installment,

        'profit_amount_type' => $request->profit_amount_type,
        'minimum_profit_amount' => $request->minimum_profit_amount,
        'profit_amount' => $request->profit_amount,
        'profit_distribution' => $request->profit_distribution,
        'auto_profit_distribution' => $request->auto_profit_distribution,
        'profit_schedule' => $request->profit_schedule,

        'profit_schedule_period' => $request->profit_schedule_period,
        'repeat_time' => $request->repeat_time, 

     ]);

     /// Multiple Image Upload From Here 
     $images = $request->file('gallery_images');
     if (!empty($images) && is_array($images)) {
        foreach($images as $img){

          $manager = new ImageManager(new Driver());
          $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
          $imgs = $manager->read($img);
          $imgs->resize(840,450)->save(public_path('upload/multi_image/'.$make_name));
          $uploadPath = 'upload/multi_image/'.$make_name; 

          PropertyGalleryImage::create([
            'property_id' => $property->id,
            'image' => $uploadPath, 
          ]);
        } //End Foreach 
     }
     /// End Multiple Image Upload From Here  

       $notification = array(
            'message' => 'Property Updated Successfully',
            'alert-type' => 'success'
        ); 
        return redirect()->route('all.property')->with($notification); 

   }
    //End Method 

    public function DeleteProperty($id){
        $property = Property::findOrFail($id);

        // Delete main image 
        if ($property->image && file_exists(public_path($property->image))) {
           unlink(public_path($property->image));
        }

        // delete all gallery images
        $galleryImages = PropertyGalleryImage::where('property_id',$id)->get();
        foreach($galleryImages as $img){
            if ($img->image && file_exists(public_path($img->image))) {
                unlink(public_path($img->image));
            }
        }

        PropertyGalleryImage::where('property_id',$id)->delete();
        $property->delete();

         $notification = array(
            'message' => 'Property Delete Successfully',
            'alert-type' => 'success'
        ); 
        return redirect()->back()->with($notification); 
    }
    //End Method 




}