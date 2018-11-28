<?php declare(strict_types=1);

namespace Quanta\Utils;

interface ClassNameCollectionInterface
{
    /**
     * Return an array of class names.
     *
     * @return string[]
     */
    public function classes(): array;
}
