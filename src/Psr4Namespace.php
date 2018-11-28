<?php declare(strict_types=1);

namespace Quanta\Utils;

final class Psr4Namespace implements ClassNamesInterface
{
    /**
     * The pattern a file name must match to be considered as a file containing
     * a class declaration.
     *
     * Starts with an uppercased letter, contains only letters an numbers and
     * have php extension.
     *
     * It actually also matches interfaces and traits but who cares.
     *
     * @var string
     */
    const PATTERN = '/[A-Z][A-Za-z0-9]+\.php$/';

    /**
     * The namespace.
     *
     * @var string
     */
    private $namespace;

    /**
     * The directories containing the php files declaring the namespace classes.
     *
     * @var string[]
     */
    private $directories;

    /**
     * Constructor.
     *
     * At least one directory is required.
     *
     * @param string $namespace
     * @param string $directory
     * @param string ...$directories
     */
    public function __construct(string $namespace, string $directory, string ...$directories)
    {
        $this->namespace = rtrim($namespace, '\\');
        $this->directories = array_merge([$directory], $directories);
    }

    /**
     * @inheritdoc
     */
    public function classes(): array
    {
        return array_values(iterator_to_array($this->fqcn()));
    }

    /**
     * Yield an iterator for each directory.
     *
     * @return \Generator
     */
    private function directories(): \Generator
    {
        foreach ($this->directories as $root) {
            if (is_dir($root)) {
                yield $root => new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($root)
                );
            }
        }
    }

    /**
     * Yield paths of the files declaring classes for each directory.
     *
     * @return \Generator
     */
    private function paths(): \Generator
    {
        foreach ($this->directories() as $root => $directory) {
            foreach ($directory as $file) {
                if (preg_match(self::PATTERN, $file->getFilename()) === 1) {
                    yield $root => $file->getPathname();
                }
            }
        }
    }

    /**
     * Yield the non redundant fully qualified class name of the classes.
     *
     * @return \Generator
     */
    private function fqcn(): \Generator
    {
        foreach ($this->paths() as $root => $path) {
            $x = substr($path, strlen($root) + 1, -4);

            $fqcn = implode('', [$this->namespace, '\\', str_replace('/', '\\', $x)]);

            yield $fqcn => $fqcn;
        }
    }
}
