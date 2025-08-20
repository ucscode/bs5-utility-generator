<?php

namespace Ucscode\Bs5AutoCss;

require_once 'vendor/autoload.php';

$generators = [
    'filesize.css' => new Generator(
        'font-size',
        '--bs-font-',
        'fs-',
        range(1, 10),
        'px'
    ),
    'width.css' => new Generator(
        property: 'width',
        variablePrefix: '--bs-width-',
        classPrefix: 'w-',
        range: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 'auto'],
        unit: '%'
    ),
];

foreach ($generators as $filename => $generator) {
    $filepath = __DIR__ . '/files/' . $filename;
    $sourceCode = $generator->generate();

    file_put_contents($filepath, $sourceCode);
}