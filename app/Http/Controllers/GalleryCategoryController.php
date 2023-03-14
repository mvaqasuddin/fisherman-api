<?php

namespace App\Http\Controllers;

use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GalleryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = GalleryCategory::where('lang', $request->lang)->get();
        return response()->json(["categories" => $categories], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'route' => 'required',
            'lang' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $category = GalleryCategory::create([
                "name" => $request->name,
                "route" => $request->route,
                "lang" => $request->lang
            ]);

            return $category ?  response()->json("Data has been saved", 200) : response()->json("Network Issue", 400);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GalleryCategory  $galleryCategory
     * @return \Illuminate\Http\Response
     */
    public function show(GalleryCategory $galleryCategory, Request $request)
    {
        $categories = GalleryCategory::where('_id', $galleryCategory->_id)->where('lang', $request->lang)->first();
        return response()->json(["categories" => $categories], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GalleryCategory  $galleryCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GalleryCategory $galleryCategory)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'route' => 'required',
            'lang' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $category = GalleryCategory::where('_id', $request->_id)->where('lang', $request->lang)->update([
                "name" => $request->name,
                "route" => $request->route,
                "lang" => $request->lang
            ]);

            return $category ?  response()->json("Data has been saved", 200) : response()->json("Network Issue", 400);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GalleryCategory  $galleryCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(GalleryCategory $galleryCategory)
    {
    }
    

}
