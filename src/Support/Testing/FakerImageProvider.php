<?php

declare(strict_types=1);

namespace Support\Testing;

use Faker\Generator;
use Faker\Provider\Base;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Support\Str;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

final class FakerImageProvider extends Base
{
    private readonly Filesystem $filesystem;

    public function __construct(Generator $generator, FilesystemFactory $filesystem)
    {
        parent::__construct($generator);

        $this->filesystem = $filesystem->disk('images');
    }

    public function imageCopy(string $from, string $to): string
    {
        if (! $this->filesystem->exists($to)) {
            $this->filesystem->makeDirectory($to);
        }

        /** @var SplFileInfo $file */
        $file = self::randomElement(
            app(Finder::class)->files()->in(base_path('tests/Fixture/images' . DIRECTORY_SEPARATOR . $from))
        );
        $filename = Str::random() . '.' . $file->getExtension();

        copy(
            $file->getPathname(),
            $this->filesystem->path($to . DIRECTORY_SEPARATOR . $filename),
        );

        return implode(DIRECTORY_SEPARATOR, ['storage', $to, $filename]);
    }
}
