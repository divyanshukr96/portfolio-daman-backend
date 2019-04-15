<?php

namespace App\Http\Controllers;

use App\Photo;
use App\Traits\StoreImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CoverPhotoController extends Controller
{
    use StoreImage;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('carousel.home', ['covers' => Photo::all()->where('carousel', true)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function removed()
    {
        return view('carousel.trash', ['covers' => Photo::where('remove', true)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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
        $this->validate($request,[
            'photo.*' => 'required|image'
        ],[],[
            'photo.*' => 'photo'
        ]);
        if ($request->hasFile('photo')) {
            $photos = $request->file('photo');
            foreach ($photos as $photo) {
                Photo::create([
                    'name' => $photo,
                    'carousel' => $request->get('carousel')
                ]);
            }
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Photo $photo
     * @return Response
     */
    public function remove(Request $request, Photo $photo)
    {
        $photo->update(['carousel' => false, 'remove' => true]);
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @return Response
     */
    public function restore($id)
    {
        $photo = Photo::withTrashed()->find($id)->first();
        $photo->update(['carousel' => true, 'remove' => false]);
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
