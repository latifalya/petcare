<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryRequest;
use App\Gallery;
use App\HealthPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Gallery::with(['health_package'])->get();

        return view('pages.admin.gallery.index',[
            'items' => $items
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $health_packages = HealthPackage::all();
        return view('pages.admin.gallery.create',[
            'health_packages' => $health_packages
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GalleryRequest $request)
    {
        $uploadImg = $request->file('image');
        $pathImg = $uploadImg->store('assets/gallery', 'public');

        Gallery::create([
            'health_packages_id' => $request->health_packages_id,
            'image' => '/storage/' . $pathImg
        ]);

        return redirect()->route('gallery.index');
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
        $item = Gallery::findOrFail($id);
        $health_packages = HealthPackage::all();

        return view('pages.admin.gallery.edit',[
            'item' => $item,
            'health_packages' => $health_packages
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GalleryRequest $request, $id)
    {
        $data = $request->all();  
        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store(
                'assets/gallery', 'public'
            ); 
        }
        $item = Gallery::findOrFail($id);

        $item->update($data);

        return redirect()->route('gallery.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Gallery::findOrFail($id);

        $item->delete();

        return redirect()->route('gallery.index');
    }
}
