<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Image;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): PostResource
    {
        $post = Post::latest()->first();

        return new PostResource($post);
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
        $images = $data['images'];
        unset($data['images']);
        $post = Post::firstOrCreate($data);
        foreach ($images as $image) {
            $name = md5(Carbon::now()->timestamp . '_' . uniqid() . '_' . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
            $previewName = 'prev_' . $name;
            $filePath = Storage::disk('public')->putFileAs('/images', $image, $name);

            Image::create([
                'path' => $filePath,
                'url' => url('/storage/' . $filePath),
                'preview_url' => url('/storage/images/' . $previewName),
                'post_id' => $post->id,
            ]);

            $manager = ImageManager::imagick();
            $imagePreview = $manager->read($image);
            $imagePreview->resize(100, 100)->save(storage_path('/app/public/images/' . $previewName));
        }
        return response()->json(['message' => 'Post created']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
