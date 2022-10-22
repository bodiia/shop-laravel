<?php

declare(strict_types=1);

namespace App\Faker;

use Faker\Provider\Base;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SplFileInfo;

final class FakerImageProvider extends Base
{
    public function imageCopy(string $imageDirectory, string $saveDirectory): string
    {
        if (! Storage::exists($saveDirectory)) {
            Storage::makeDirectory($saveDirectory);
        }

        /** @var SplFileInfo $file */
        $file = self::randomElement(File::files($imageDirectory));
        $randFilename = Str::random() . '.' . $file->getExtension();

        File::copy(
            $file->getPathname(),
            Storage::path($saveDirectory . '/' . $randFilename),
        );

        return 'storage/' . $saveDirectory . '/' . $randFilename;
    }
}
