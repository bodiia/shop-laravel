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

    private readonly Finder $finder;

    public function __construct(Generator $generator, FilesystemFactory $filesystem, Finder $finder)
    {
        parent::__construct($generator);

        $this->filesystem = $filesystem->disk('images');
        $this->finder = $finder;
    }

    public function imageCopy(string $from, string $to): string
    {
        if (! $this->filesystem->exists($to)) {
            $this->filesystem->makeDirectory($to);
        }

        /** @var SplFileInfo $file */
        $file = self::randomElement(
            $this->finder->files()->in(base_path('tests/Fixture/images' . DIRECTORY_SEPARATOR . $from))
        );
        $filename = Str::random() . '.' . $file->getExtension();

        copy(
            $file->getPathname(),
            $this->filesystem->path($to . DIRECTORY_SEPARATOR . $filename),
        );

        return implode(DIRECTORY_SEPARATOR, ['storage', $to, $filename]);
    }
}
