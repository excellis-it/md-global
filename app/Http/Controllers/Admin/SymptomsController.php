<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use App\Models\Symptoms;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SymptomsController extends Controller
{
    use ImageTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $symptoms = Symptoms::all();
        return view('admin.symptoms.list', compact('symptoms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specializations = Specialization::select('id', 'name', 'status')->where('status', true)->get();
        return view('admin.symptoms.create', compact('specializations'));
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
            'specialization_id' => 'required',
            'symptom_name' => 'required',
            'symptom_description' => 'required',
            'symptom_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'symptom_status' => 'required',
            'symptom_slug' => 'required|unique:symptoms,symptom_slug',
        ]);

        $symptom = new Symptoms();
        $symptom->specialization_id = $request->specialization_id;
        $symptom->symptom_name = $request->symptom_name;
        $symptom->symptom_slug = $request->symptom_slug;
        $symptom->symptom_description = $request->symptom_description;
        $symptom->symptom_status = $request->symptom_status;
        $symptom->symptom_image = $this->imageUpload($request->file('symptom_image'), 'symptoms');
        $symptom->meta_title=$request->meta_title;
        $symptom->meta_description=$request->meta_description;
        $symptom->meta_keyword=$request->meta_keyword;
        $symptom->save();

        return redirect()->route('symptoms.index')->with('message', 'Symptom created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $symptom = Symptoms::findOrFail($id);
        $specializations = Specialization::select('id', 'name', 'status')->where('status', true)->get();
        return view('admin.symptoms.edit', compact('symptom', 'specializations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'specialization_id' => 'required',
            'symptom_name' => 'required',
            'symptom_description' => 'required',
            'symptom_status' => 'required',
            'symptom_slug' => 'required|unique:symptoms,symptom_slug,' .$id,
        ]);

        $symptom = Symptoms::findOrFail($id);
        $symptom->specialization_id = $request->specialization_id;
        $symptom->symptom_name = $request->symptom_name;
        $symptom->symptom_slug = $request->symptom_slug;
        $symptom->symptom_description = $request->symptom_description;
        $symptom->symptom_status = $request->symptom_status;
        if ($request->hasFile('symptom_image')) {
            $request->validate([
                'symptom_image' => 'image|mimes:jpg,png,jpeg,gif,svg',
            ]);
            if ($symptom->symptom_image) {
                $currentImageFilename = $symptom->symptom_image; // get current image name
                Storage::delete('app/' . $currentImageFilename);
            }
            $symptom->symptom_image = $this->imageUpload($request->file('symptom_image'), 'symptoms');
        }

        $symptom->meta_title=$request->meta_title;
        $symptom->meta_description=$request->meta_description;
        $symptom->meta_keyword=$request->meta_keyword;
        $symptom->save();

        return redirect()->route('symptoms.index')->with('message', 'Symptom updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $symptom = Symptoms::findOrFail($id);
        if ($symptom->symptom_image) {
            $currentImageFilename = $symptom->symptom_image; // get current image name
            Storage::delete('app/' . $currentImageFilename);
        }
        $symptom->delete();

        return redirect()->route('symptoms.index')->with('error', 'Symptom deleted successfully.');
    }

    public function changeStatus(Request $request)
    {
        $symptom = Symptoms::findOrFail($request->id);
        $symptom->symptom_status = $request->status;
        $symptom->save();

        return response()->json(['success' => 'Status change successfully.']);
    }
}
