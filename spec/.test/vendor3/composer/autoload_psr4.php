<?php

$vendor = realpath(__DIR__ . '/..');

return [
    [$vendor . '/dir1', $vendor . '/dir2', 'nonexisting'],
    'Root\\Test1\\' => [$vendor . '/dir1', $vendor . '/dir2', 'nonexisting'],
    'Root\\Test2\\' => [$vendor . '/dir3'],
    'Root\\Test3\\' => 1,
    'Root\\Test4\\' => [],
];
