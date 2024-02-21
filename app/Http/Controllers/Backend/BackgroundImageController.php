<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BackgroundImage;
use Illuminate\Http\Request;

use File;


class BackgroundImageController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $backgroundImage = BackgroundImage::first();
        $route = $backgroundImage ? route('background-images.update', ['background_image' => $backgroundImage->id]) : route('background-images.store');
        return view('staff.backgroundimage.index', compact('backgroundImage', 'route'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $this->uploadImage($request->file('image'));

        BackgroundImage::create(['image_path' => $imagePath]);

        toastr('Created Successfully', 'success', 'Success');


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $backgroundImage = BackgroundImage::first();

        if ($request->hasFile('image')) {
            $oldPath = $backgroundImage ? $backgroundImage->image_path : null;
            $imagePath = $this->uploadImage($request->file('image'), $oldPath);
            if (!$backgroundImage) {
                BackgroundImage::create(['image_path' => $imagePath]);
            } else {
                $backgroundImage->update(['image_path' => $imagePath]);
            }
        }

        toastr('Updated Successfully', 'success', 'Success');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function uploadImage($image, $oldPath = null)
{
    if ($oldPath && File::exists(public_path($oldPath))) {
        // If there's an old image, delete it
        File::delete(public_path($oldPath));
    }

    // Save the uploaded image as JPEG format with the name 'backgroundimage.jpg'
    $image->move(public_path('backgrounds'), 'backgroundimage.jpg');

    // Return the path to the saved image
    return 'backgrounds/backgroundimage.jpg';
}
}
