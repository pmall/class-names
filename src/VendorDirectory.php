<?php declare(strict_types=1);

namespace Quanta\Utils;

final class VendorDirectory implements ClassNamesInterface
{
    /**
     * The vendor dir path.
     *
     * @var string
     */
    private $path;

    /**
     * Constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @inheritdoc
     */
    public function classes(): array
    {
        return iterator_to_array($this->fqcn());
    }

    /**
     * Return whether the given values defines a valid namespace.
     *
     * @param mixed $namespace
     * @param mixed $directories
     * @return bool
     */
    private function isValidNamespace($namespace, $directories): bool
    {
        if (is_string($namespace) && is_array($directories)) {
            $total = count($directories);
            $valid = count(array_filter($directories, 'is_string'));

            return $total > 0 && $total == $valid;
        }

        return false;
    }

    /**
     * Yield namespace/directories pairs from the psr4 autoload file.
     *
     * @return \Generator
     */
    private function map(): \Generator
    {
        $path = realpath($this->path) . '/composer/autoload_psr4.php';

        if (file_exists($path) && is_array($map = require $path)) {
            yield from $map;
        }
    }

    /**
     * Yield an instance of Psr4Namespace for each entry of the autoload map.
     *
     * @return \Generator
     */
    private function namespaces(): \Generator
    {
        foreach ($this->map() as $namespace => $directories) {
            if ($this->isValidNamespace($namespace, $directories)) {
                yield new Psr4Namespace($namespace, ...$directories);
            }
        }
    }

    /**
     * Yield the fully qualified class names of the classes defined for each
     * namespace.
     *
     * @return \Generator
     */
    private function fqcn(): \Generator
    {
        foreach ($this->namespaces() as $namespace) {
            foreach ($namespace->classes() as $class) {
                yield $class;
            }
        }
    }
}
