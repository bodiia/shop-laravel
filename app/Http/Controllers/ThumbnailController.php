<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Factory as Filesystem;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ThumbnailController extends Controller
{
    public function __construct(private readonly Filesystem $filesystem)
    {
    }

    public function __invoke(string $dirname, string $method, string $size, string $filename): BinaryFileResponse
    {
        abort_if(! in_array($size, config('thumbnail.allowed_sizes')), 403);

        $storage = $this->filesystem->disk('images');

        $path = implode(DIRECTORY_SEPARATOR, [$dirname, $filename]);
        $dirpath = implode(DIRECTORY_SEPARATOR, [$dirname, $method, $size]);
        $filepath = implode(DIRECTORY_SEPARATOR, [$dirpath, $filename]);

        if (! $storage->exists($dirpath)) {
            $storage->makeDirectory($dirpath);
        }

        if (! $storage->exists($filepath)) {
            $image = Image::make($storage->path($path));

            [$width, $height] = explode('x', $size);

            $image->{ $method }($width, $height);
            $image->save($storage->path($filepath));
        }

        return response()->file($storage->path($filepath));
    }
}
