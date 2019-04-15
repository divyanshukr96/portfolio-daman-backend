<?php

namespace App\Http\Controllers;

use App\Photo;
use Exception;
use App\Layout;
use App\Description;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\LayoutResource;
use App\Http\Resources\GalleryResource;
use Illuminate\Validation\ValidationException;

class LayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('home_layout.home', [
            'layout' => Layout::all()->where('cover', false),
            'cover' => Layout::all()->where('cover', true)->first(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function home()
    {
        return response()->json([
            'carousel' => GalleryResource::collection(Photo::all()->where('carousel', true)),
            'description' => new LayoutResource(Description::first()),
            'cover' => new LayoutResource(Layout::where('cover', true)->first()),
            'layout' => LayoutResource::collection(Layout::all()),
            'gallery' => GalleryResource::collection(Photo::Paginate(9))
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function description()
    {
        $layout = Layout::where('cover', true)->first();
        return view('home_layout.description', ['layout' => $layout]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function descriptionUpdate(Request $request)
    {
        $data = [];
        $data['about'] = $request->get('about');
        $data['cover'] = $request->get('cover');
        if ($request->hasFile('photo')) {
            $this->validate($request,[
                'photo' => 'required|image'
            ]);
            $photo = Photo::create(['name' => $request->file('photo')]);
            if ($photo) $data['photo_id'] = $photo->id;
        }
        $layout = Layout::where('cover', true)->update($data);
        if (!$layout) Layout::create($data);
        return redirect()->route('layout');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('home_layout.create', ['layout' => Layout::all()->where('cover', false)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'about' => 'required|string',
            'title' => 'required|string',
            'photo' => 'required|image'
        ]);

        $layout = Layout::create($request->all());
        $layout->photo()->associate(Photo::create([
            'name' => $request->file('photo')
        ]));
        $layout->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Layout $layout
     * @return Response
     */
    public function show(Layout $layout)
    {
        return view('home_layout.show', ['data' => $layout]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Layout $layout
     * @return Response
     */
    public function edit(Layout $layout)
    {
        return view('home_layout.edit', ['data' => $layout]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Layout $layout
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, Layout $layout)
    {
        $layout->update($request->all());
        if ($request->hasFile('photo')) {
            $this->validate($request,[
                'photo' => 'required|image'
            ]);
            $layout->photo()->associate(Photo::create([
                'name' => $request->file('photo')
            ]))->save();
        }
        return redirect()->route('layout');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Layout $layout
     * @return Response
     * @throws Exception
     */
    public function destroy(Layout $layout)
    {
        $layout->delete();
        return redirect()->route('layout');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function trash()
    {
        $layout = Layout::onlyTrashed()->get();
        return view('home_layout.trash', ['layout' => $layout]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function restore($id)
    {
        $layout = Layout::onlyTrashed()->find($id);
        $layout->restore();
        return redirect()->route('layout');
    }
}
