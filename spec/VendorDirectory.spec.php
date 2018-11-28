<?php

use Quanta\Utils\VendorDirectory;
use Quanta\Utils\ClassNameCollectionInterface;

describe('VendorDirectory', function () {

    it('should implement ClassNameCollectionInterface', function () {

        expect(new VendorDirectory(''))->toBeAnInstanceOf(ClassNameCollectionInterface::class);

    });

    describe('->classes()', function () {

        context('when the composer/autoload_psr4.php file does not exist', function () {

            it('should return an empty array', function () {

                $directory = new VendorDirectory(__DIR__ . '/test/vendor1');

                $test = $directory->classes();

                expect($test)->toEqual([]);

            });

        });

        context('when the composer/autoload_psr4.php exists', function () {

            context('when the composer/autoload_psr4.php does not return an array', function () {

                it('should return an empty array', function () {

                    $directory = new VendorDirectory(__DIR__ . '/test/vendor2');

                    $test = $directory->classes();

                    expect($test)->toEqual([]);

                });

            });

            context('when the composer/autoload_psr4.php returns an array', function () {

                it('should return the class names defined in the vendor directory', function () {

                    $directory = new VendorDirectory(__DIR__ . '/test/vendor3');

                    $test = $directory->classes();

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
