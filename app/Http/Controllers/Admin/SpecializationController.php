<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpecializationController extends Controller
{

    use ImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specializations = Specialization::orderBy('position', 'asc')->get();
        return view('admin.specializations.list', compact('specializations'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.specializations.create');
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
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'slug' => 'required|unique:specializations,slug',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ], [
            'slug.unique' => 'The slug has already been taken.',
            'slug.required' => 'The slug field is required.',
            'name.required' => 'The Specialization Name field is required.',
        ]);


        $last_position = Specialization::orderBy('position', 'desc')->first();

        $specialization = new Specialization();
        $specialization->name = $request->name;
        $specialization->description = $request->description;
        $specialization->status = $request->status;
        $specialization->slug = $request->slug;
        $specialization->image = $this->imageUpload($request->file('image'), 'specializations');
        $specialization->meta_title=$request->meta_title;
        $specialization->meta_description=$request->meta_description;
        $specialization->meta_keyword=$request->meta_keyword;
        $specialization->save();

        return redirect()->route('specializations.index')->with('message', 'Specialization created successfully.');
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
        $specialization = Specialization::findOrFail($id);
        return view('admin.specializations.edit', compact('specialization'));
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
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'slug' => 'required|unique:specializations,slug,' . $id,
        ], [
            'slug.unique' => 'The slug has already been taken.',
            'slug.required' => 'The slug field is required.',
            'name.required' => 'The Specialization Name field is required.',
        ]);

        $specialization = Specialization::findOrFail($id);
        $specialization->name = $request->name;
        $specialization->description = $request->description;
        $specialization->status = $request->status;
        $specialization->slug = $request->slug;
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpg,png,jpeg,gif,svg',
            ]);
            if ($specialization->image) {
                $currentImageFilename = $specialization->image; // get current image name
                Storage::delete('app/' . $currentImageFilename);
            }
            $specialization->image = $this->imageUpload($request->file('image'), 'specialization');
        }
        $specialization->meta_title=$request->meta_title;
        $specialization->meta_description=$request->meta_description;
        $specialization->meta_keyword=$request->meta_keyword;
        $specialization->save();


        return redirect()->route('specializations.index')->with('message', 'Specialization updated successfully.');
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

        $specialization = Specialization::findOrFail($id);
        if ($specialization->image) {
            $currentImageFilename = $specialization->image; // get current image name
            Storage::delete('app/' . $currentImageFilename);
        }
        $specialization->delete();

        return redirect()->back()->with('error', 'Specialization deleted successfully.');
    }

    public function changeStatus(Request $request)
    {
        $specialization = Specialization::findOrFail($request->id);
        $specialization->status = $request->status;
        $specialization->save();

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function reorder(Request $request)
    {
        $reorderData = $request->input('reorderData', []);

        if (!empty($reorderData)) {
            foreach ($reorderData as $data) {
                $specializationId = str_replace('row_', '', $data['id']);
                $newPosition = $data['newPosition'];

                Specialization::where('id', $specializationId)->update(['position' => $newPosition]);
            }
            $specializations = Specialization::orderBy('position', 'asc')->get();
            $view = view('admin.specializations.specializations-list', compact('specializations'))->render();
            return response()->json(['status' => 'success', 'message' => 'Reordering updated successfully', 'view' => $view]);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid request data']);
    }

}
