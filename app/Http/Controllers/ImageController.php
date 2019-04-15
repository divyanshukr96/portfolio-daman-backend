<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Glide\Server;
use mysql_xdevapi\Exception;

class ImageController extends Controller
{

    private $server;

    /**
     * ImageController constructor.
     */
    public function __construct()
    {
        $this->server = Server::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Server $server
     * @param $image
     * @return Response
     */
    public function image(Server $server, $image)
    {
        $data = Photo::where('name', $image)->get()->first();
        $path = $data ? $data->year . '/' . $data->month . '/' . $data->name : '';
        if (!isset($data) or !$server->sourceFileExists($path)) {
            $server->outputImage('image-not-found.png', $_GET);
            return null;
        }
        $server->outputImage($path, $_GET);

    }

}
