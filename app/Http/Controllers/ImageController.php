<?php


namespace App\Http\Controllers;


use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use \Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class ImageController extends Controller
{
    /**
     * Store uploaded image to storage and database
     * @param UploadedFile|UploadedFile[]|array|null $image_file
     * @param $name
     * @return Image
     */
    public function store(UploadedFile $image_file, string $name): Image
    {
        $image_extension = $image_file->extension();
        $image_name = Str::slug($name, '-', 'cs') . '_' . time();
        $resized_image = (new ImageManager)->make($image_file)->resize(1920, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image_path = public_path('images'). '/' .$image_name . '.' . $image_extension;
        $resized_image->save($image_path, 75, $image_extension);
        return Image::create([
            'name' => $image_name,
            'path' => $image_path,
            'type' => $image_extension
        ]);
    }

    /**
     * Show image cropped to selected resolution
     * @param Request $request
     * @return mixed
     */
    public function show(Request $request)
    {
        $image = $request->image;
        $width = $request->width;
        $height = $request->height;
        $image = Image::find($image);
        $path = $image->path;
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $img = (new ImageManager())->make($file);
        if ($width && $height) {
            $img->fit($width, $height);
        } else if ($width) {
            $img->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        } else if ($height) {
            $img->resize(null, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        return $img->response();

    }
}
