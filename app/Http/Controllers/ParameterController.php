<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ParameterController extends Controller
{
    public function index(Request $request)
    {
        $query = Parameter::query();

        if ($request->has('search')) {
            $query->where('id', $request->search)
                  ->orWhere('title', 'like', '%' . $request->search . '%');
        }

        $parameters = $query->with('images')->get();

        return view('parameters.index', compact('parameters'));
    }

    public function uploadImages(Request $request, $id)
    {
        $parameter = Parameter::findOrFail($id);

        if ($parameter->type != 2) {
            return redirect()->back()->withErrors('Images can only be uploaded to parameters of type 2.');
        }

        $request->validate([
            'icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon_gray' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $files = ['icon' => $request->file('icon'), 'icon_gray' => $request->file('icon_gray')];
        foreach ($files as $type => $file) {
            if ($file) {
                $originalName = $file->getClientOriginalName();
                $filename = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '_' . time() . '.' . $file->getClientOriginalExtension();

                $file->storeAs('public/images', $filename);

                Image::updateOrCreate(
                    ['parameter_id' => $parameter->id, 'type' => $type],
                    ['filename' => $filename, 'original_filename' => $originalName]
                );
            }
        }

        return redirect()->back()->with('success', 'Images uploaded successfully.');
    }

    public function deleteImage($id)
    {
        $image = Image::findOrFail($id);
        Storage::delete('public/images/' . $image->filename);
        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    public function getParametersWithImages()
    {
        $parameters = Parameter::where('type', 2)->with('images')->get();
        return response()->json($parameters);
    }
}
