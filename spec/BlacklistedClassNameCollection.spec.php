<?php

use function Eloquent\Phony\Kahlan\mock;

use Quanta\Utils\ClassNameCollectionInterface;
use Quanta\Utils\BlacklistedClassNameCollection;

describe('BlacklistedClassNameCollection', function () {

    beforeEach(function () {

        $this->delegate = mock(ClassNameCollectionInterface::class);

    });

    context('when there is no pattern', function () {

        beforeEach(function () {

            $this->collection = new BlacklistedClassNameCollection($this->delegate->get());

        });

        it('should implement ClassNameCollectionInterface', function () {

            expect($this->collection)->toBeAnInstanceOf(ClassNameCollectionInterface::class);

        });

        it('should return the class names returned by the delegate ->classes() method', function () {

            $classes = [SomeClass1::class, SomeClass2::class, SomeClass3::class];

            $this->delegate->classes->returns($classes);

            $test = $this->collection->classes();

            expect($test)->toEqual($classes);

        });

    });

    context('when there is at least one pattern', function () {

        beforeEach(function () {

            $this->collection = new BlacklistedClassNameCollection(...[
                $this->delegate->get(),
                sprintf('/^.+?\%s$/', SomeClass11::class),
                sprintf('/^.+?\%s$/', SomeClass22::class),
                sprintf('/^.+?\%s$/', SomeClass33::class),
            ]);

        });

        it('should implement ClassNameCollectionInterface', function () {

            expect($this->collection)->toBeAnInstanceOf(ClassNameCollectionInterface::class);

        });

        it('should return the class names returned by the delegate ->classes() method not matching any pattern', function () {

            $this->delegate->classes->returns([
                Test\SomeClass11::class,
                Test\SomeClass12::class,
                Test\SomeClass13::class,
                Test\SomeClass21::class,
                Test\SomeClass22::class,
                Test\SomeClass23::class,
                Test\SomeClass31::class,
                Test\SomeClass32::class,
                Test\SomeClass33::class,
            ]);

            $test = $this->collection->classes();

            expect($test)->toEqual([
                Test\SomeClass12::class,
                Test\SomeClass13::class,
                Test\SomeClass21::class,
                Test\SomeClass23::class,
                Test\SomeClass31::class,
                Test\SomeClass32::class,
            ]);

        });

    });

});
