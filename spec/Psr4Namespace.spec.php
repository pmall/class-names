<?php

use Quanta\Utils\Psr4Namespace;
use Quanta\Utils\ClassNameCollectionInterface;

describe('Psr4Namespace', function () {

    describe('when there is no directory', function () {

        it('should throw an ArgumentCountError', function () {

            $test = function () { new Psr4Namespace('Test'); };

            expect($test)->toThrow(new ArgumentCountError);

        });

    });

    describe('when there is at least one directory', function () {

        beforeEach(function () {

            $this->collection = new Psr4Namespace('Test', ...[
                __DIR__ . '/.test/vendor3/dir1',
                __DIR__ . '/.test/vendor3/dir2',
                __DIR__ . '/.test/vendor3/nonexisting',
            ]);

        });

        it('should implement ClassNameCollectionInterface', function () {

            expect($this->collection)->toBeAnInstanceOf(ClassNameCollectionInterface::class);

        });

        describe('->classes()', function () {

            it('should return the class names of the namespace', function () {

                $test = $this->collection->classes();

                expect($test)->toBeAn('array');
                expect($test)->toHaveLength(7);
                expect($test)->toContainKeys(range(0, 6));
                expect($test)->toContain('Test\\Class1');
                expect($test)->toContain('Test\\Test1\\Class1');
                expect($test)->toContain('Test\\Test1\\Ns1\\Class1');
                expect($test)->toContain('Test\\Test1\\Ns1\\Class2');
                expect($test)->toContain('Test\\Test1\\Ns2\\Class1');
                expect($test)->toContain('Test\\Test2\\Ns1\\Class1');
                expect($test)->toContain('Test\\Test2\\Ns2\\Class1');

            });

        });

    });

});
