<?php

namespace App\Http\Controllers;

use App\Description;
use App\Photo;
use App\Traits\StoreImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class DescriptionController extends Controller
{
    use StoreImage;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        return view('description', ['data' => Description::first()]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function trash()
    {
        return view('description_trash', ['trashes' => Description::onlyTrashed()->paginate(15)]);
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
        $this->validate($request, [
            'description' => 'required|string|unique:descriptions,description,NULL,id,deleted_at,NULL',
//            'description' => 'required|string|unique:descriptions,description,' . $request->get('description') . ', description',
//            'description' => ['required', 'string', Rule::unique('descriptions')->ignore($request->get('description'))->whereNull('deleted_at')]

            'photo' => 'required|image'
        ]);
        $data = Description::first();
        if ($data) $data->delete();

        $description = Description::create($request->all());
        $description->photo()->associate(Photo::create([
            'name' => $request->file('photo')
        ]));
        $description->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        return view('description_view', ['data' => Description::withTrashed()->find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Description $description
     * @return Response
     */
    public function edit(Description $description)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @return Response
     */
    public function restore($id)
    {
        $data = Description::onlyTrashed()->find($id);
//        if ($data) $data->restore();
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Description $description
     * @return Response
     */
    public function update(Request $request, Description $description)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function photoRestore($id)
    {
        $photo_id = Description::withTrashed()->find($id)->photo_id;
        $photo = Photo::withTrashed()->find($photo_id);
        $photo->restore();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Description $description
     * @return Response
     * @throws Exception
     */
    public function destroy(Description $description)
    {
        $description->delete();
        return redirect()->back();
    }
}
