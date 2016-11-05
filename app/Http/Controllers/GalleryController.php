<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function show($id=1)
    {
        $gallery = \App\Gallery::find($id);
        $images = $gallery->images()->orderBy('id','desc')->paginate(10);
        return view('welcome',compact('images','gallery'));
    }
}
