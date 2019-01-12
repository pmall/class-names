<?php declare(strict_types=1);

namespace Quanta\Utils;

final class ClassNameCollection implements ClassNameCollectionInterface
{
    /**
     * The class names.
     *
     * @var string[]
     */
    private $classes;

    /**
     * Constructor.
     *
     * @param string ...$classes
     */
    public function __construct(string ...$classes)
    {
        $this->classes = $classes;
    }

    /**
     * @inheritdoc
     */
    public function classes(): array
    {
        return $this->classes;
    }
}
