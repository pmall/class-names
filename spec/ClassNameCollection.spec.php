<?php

use Quanta\Utils\ClassNameCollection;
use Quanta\Utils\ClassNameCollectionInterface;

describe('ClassNameCollection', function () {

    beforeEach(function () {

        $this->collection = new ClassNameCollection(...[
            Test\SomeClass1::class,
            Test\SomeClass2::class,
            Test\SomeClass3::class,
        ]);

    });

    it('should implement ClassNameCollectionInterface', function () {

        expect($this->collection)->toBeAnInstanceOf(ClassNameCollectionInterface::class);

    });

    describe('->classes()', function () {

        it('should return the classes', function () {

            $test = $this->collection->classes();

            expect($test)->toEqual([
                Test\SomeClass1::class,
                Test\SomeClass2::class,
                Test\SomeClass3::class,
            ]);

        });

    });

});
