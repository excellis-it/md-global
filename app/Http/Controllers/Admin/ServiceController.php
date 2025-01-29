<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;
use App\Traits\ImageTrait;

class ServiceController extends Controller
{

    use ImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service = Service::orderBy('id', 'desc')->get();
        return view('admin.services.list', compact('service'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:services',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'title' => 'required',
            'description' => 'required',
        ]);

        $service = new Service();
        $service->slug = $request->slug;
        $service->title = $request->title;
        $service->description = $request->description;
        $service->image = $this->imageUpload($request->file('image'), 'service');
        $service->meta_title=$request->meta_title;
        $service->meta_description=$request->meta_description;
        $service->meta_keyword=$request->meta_keyword;
        // dd($service);
        $service->save();
        return redirect()->route('services.index')->with('message', 'Service created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'slug' => 'required|unique:services,slug,' . $request->id,
            'title' => 'required',
            'description' => 'required',
        ]);

        $service = Service::findOrFail($request->id);
        $service->slug = $request->slug;
        $service->title = $request->title;
        $service->description = $request->description;
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpg,png,jpeg,gif,svg',
            ]);
            if ($service->image) {
                $currentImageFilename = $service->image; // get current image name
                Storage::delete('app/' . $currentImageFilename);
            }
            $service->image = $this->imageUpload($request->file('image'), 'service');
        }

        $service->meta_title=$request->meta_title;
        $service->meta_description=$request->meta_description;
        $service->meta_keyword=$request->meta_keyword;
        //dd($service);

        $service->save();

        return redirect()->route('services.index')->with('message', 'Service updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        if ($service->image) {
            $currentImageFilename = $service->image; // get current image name
            Storage::delete('app/' . $currentImageFilename);
        }
        $service->delete();
        return redirect()->route('services.index')->with('error', 'Service deleted successfully');
    }
}
