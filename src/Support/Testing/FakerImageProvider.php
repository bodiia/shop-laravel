<?php

declare(strict_types=1);

namespace Support\Testing;

use Faker\Provider\Base;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SplFileInfo;

final class FakerImageProvider extends Base
{
    public function imageCopy(string $from, string $to): string
    {
        $storage = Storage::disk('images');

        if (! $storage->exists($to)) {
            $storage->makeDirectory($to);
        }

        /** @var SplFileInfo $file */
        $file = self::randomElement(File::files(base_path('tests/Fixture/images' . DIRECTORY_SEPARATOR . $from)));
        $filename = Str::random() . '.' . $file->getExtension();

        File::copy(
            $file->getPathname(),
            $storage->path($to . DIRECTORY_SEPARATOR . $filename),
        );

        return implode(DIRECTORY_SEPARATOR, ['storage', $to, $filename]);
    }
}
