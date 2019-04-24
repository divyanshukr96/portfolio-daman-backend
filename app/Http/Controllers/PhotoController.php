<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\GalleryResource;
use App\Photo;
use App\Traits\ResizeImage;
use App\Traits\StoreImage;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class PhotoController extends Controller
{

    use StoreImage, ResizeImage;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $galleries = Photo::paginate(30);
        $categories = Category::all();
        $selected = 'all';
        return view('gallery.home', compact('galleries', 'categories', 'selected'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param $category
     * @return Response
     */
    public function byCategory($category)
    {
        $galleries = Category::where('value', $category)->first()->images()->paginate(30);
        $categories = Category::all();
        $selected = $category;
        return view('gallery.home', compact('galleries', 'categories', 'selected'));
    }

    /**
     * Display a listing of the trash resource.
     *
     * @return Response
     */
    public function trash()
    {
        $galleries = Photo::onlyTrashed()->paginate(30);
        return view('gallery.trash', ['galleries' => $galleries]);
    }

    /**
     * Display a listing of the trash resource.
     *
     * @return Response
     */
    public function getResize()
    {
        $galleries = Photo::where('size', '>', '2')->paginate(30);
        return view('gallery.resize', ['galleries' => $galleries]);
    }


    /**
     * @return ResponseFactory|Response
     */
    public function optimizeList()
    {
        return response(Photo::where('size', '>', '2')->count(), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function gallery()
    {
        return GalleryResource::collection(Photo::all())->pluck('name');
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
            'photo.*' => 'required|image',
            'category' => 'required|exists:categories,value'
        ], [], [
            'photo.*' => 'photo'
        ]);
        if ($request->hasFile('photo')) {
            $category = Category::where('value', $request->get('category'))->first();
            $photos = $request->file('photo');
            foreach ($photos as $photo) {
                $category->images()->attach(Photo::create(['name' => $photo]));
            }
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Photo $photo
     * @return Response
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Photo $photo
     * @return Response
     */
    public function edit(Photo $photo)
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
    public function optimize(Request $request, Photo $photo)
    {
        $this->resize($photo);
        $photo->size = $this->getPhotoSize($photo);
        $photo->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Photo $photo
     * @return Response
     * @throws Exception
     */
    public function destroy(Photo $photo)
    {
        $redirect = 'gallery';
        if ($photo->layout) {
            $message = "This photo belongs to Home Layout. <a href='" . route('layout.show', ['layout' => $photo->layout]) . "' class=\"alert-link\">Click here to view detail.</a>";
            Session::flash('alert-warning', $message);
        } elseif ($photo->description) {
            $message = "This photo belongs to Description. <a href='" . route('description') . "' class=\"alert-link\">Click here to view detail.</a>";
            Session::flash('alert-warning', $message);
        } else {
            if ($photo->carousel) $redirect = 'carousel';
            $photo->delete();
        }
        return redirect()->route($redirect);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function restore($id)
    {
        $photo = Photo::onlyTrashed()->find($id);
        $photo->restore();
        return redirect()->route('gallery.trash');
    }

}
