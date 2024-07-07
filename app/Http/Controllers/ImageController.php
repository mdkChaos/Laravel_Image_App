<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\Image\StoreRequest;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $image = $data['image'];
        $name = md5(Carbon::now()->timestamp . '_' . uniqid() . '_' . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
        $filePath = Storage::disk('public')->putFileAs('/images', $image, $name);

        return response()->json(['url' => url('/storage/' . $filePath)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }
}
