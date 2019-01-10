<?php

use Quanta\Utils\VendorDirectory;
use Quanta\Utils\ClassNameCollectionInterface;

describe('VendorDirectory', function () {

    context('when the vendor directory does not contain a composer/autoload_psr4.php file', function () {

        beforeEach(function () {

            $this->collection = new VendorDirectory(__DIR__ . '/.test/vendor1');

        });

        it('should implement ClassNameCollectionInterface', function () {

            expect($this->collection)->toBeAnInstanceOf(ClassNameCollectionInterface::class);

        });

        describe('->classes()', function () {

            it('should return an empty array', function () {

                $test = $this->collection->classes();

                expect($test)->toEqual([]);

            });

        });

    });

    context('when the vendor directory contains a composer/autoload_psr4.php file', function () {

        context('when the composer/autoload_psr4.php file does not return an array', function () {

            beforeEach(function () {

                $this->collection = new VendorDirectory(__DIR__ . '/.test/vendor2');

            });

            it('should implement ClassNameCollectionInterface', function () {

                expect($this->collection)->toBeAnInstanceOf(ClassNameCollectionInterface::class);

            });

            describe('->classes()', function () {

                it('should return an empty array', function () {

                    $test = $this->collection->classes();

                    expect($test)->toEqual([]);

                });

            });

        });

        context('when the composer/autoload_psr4.php file returns an array', function () {

            beforeEach(function () {

                $this->collection = new VendorDirectory(__DIR__ . '/.test/vendor3');

            });

            it('should implement ClassNameCollectionInterface', function () {

                expect($this->collection)->toBeAnInstanceOf(ClassNameCollectionInterface::class);

            });

            describe('->classes()', function () {

                it('should return the class names defined in the vendor directory', function () {

                    $test = $this->collection->classes();

                    expect($test)->toBeAn('array');
                    expect($test)->toHaveLength(9);
                    expect($test)->toContainKeys(range(0, 8));
                    expect($test)->toContain('Root\\Test1\\Class1');
                    expect($test)->toContain('Root\\Test1\\Test1\\Class1');
                    expect($test)->toContain('Root\\Test1\\Test1\\Ns1\\Class1');
                    expect($test)->toContain('Root\\Test1\\Test1\\Ns1\\Class2');
                    expect($test)->toContain('Root\\Test1\\Test1\\Ns2\\Class1');
                    expect($test)->toContain('Root\\Test1\\Test2\\Ns1\\Class1');
                    expect($test)->toContain('Root\\Test1\\Test2\\Ns2\\Class1');
                    expect($test)->toContain('Root\\Test2\\Ns1\\Class1');
                    expect($test)->toContain('Root\\Test2\\Ns2\\Class1');

                });

            });

        });

    });

});
