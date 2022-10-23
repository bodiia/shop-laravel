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
    public function imageCopy(string $from, string $to): string
    {
        if (! Storage::exists($to)) {
            Storage::makeDirectory($to);
        }

        /** @var SplFileInfo $file */
        $file = self::randomElement(File::files($from));

        $filename = Str::random() . '.' . $file->getExtension();

        File::copy(
            $file->getPathname(),
            Storage::path($to . '/' . $filename),
        );

        return 'storage/' . $to . '/' . $filename;
    }
}
