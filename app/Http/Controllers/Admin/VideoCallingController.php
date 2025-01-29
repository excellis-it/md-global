<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoCallPrice;
use Illuminate\Http\Request;

class VideoCallingController extends Controller
{
    public function videoCallPrice()
    {
        $videos = VideoCallPrice::orderBy('id', 'desc')->get();
        return view('admin.video_calling.price')->with(compact('videos'));
    }

    public function create()
    {
        return view('admin.video_calling.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:video_call_prices',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'description' => 'nullable'
        ]);

        $new_video = new VideoCallPrice();
        $new_video->title = $request->title;
        $new_video->price = $request->price;
        $new_video->duration = $request->duration;
        $new_video->description = $request->description;
        $new_video->save();

        return redirect()->route('video-call-price.index')->with('message', 'Video call price added successfully');
    }

    public function edit($id)
    {
        $video = VideoCallPrice::find($id);
        return view('admin.video_calling.edit')->with(compact('video'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:video_call_prices,title,' . $id,
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'description' => 'nullable'
        ]);

        $video = VideoCallPrice::find($id);
        $video->title = $request->title;
        $video->price = $request->price;
        $video->duration = $request->duration;
        $video->description = $request->description;
        $video->save();

        return redirect()->route('video-call-price.index')->with('message', 'Video call price updated successfully');
    }

    public function delete($id)
    {
        $video = VideoCallPrice::find($id);
        $video->delete();
        return redirect()->route('video-call-price.index')->with('message', 'Video call price deleted successfully');
    }
}
