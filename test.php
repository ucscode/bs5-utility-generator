<?php

namespace Ucscode\Bs5AutoCss;

require_once 'vendor/autoload.php';

echo (new Generator(
    'font-size',
    '--bs-font-',
    'fs-',
    range(1, 10),
    'px'
))->generate();

$filepath = __DIR__ . '/fontsize.css';

if(is_writable($filepath)) {
    file_put_contents($filepath, $sourceCode);
}

echo (new Generator(
    property: 'width',
    varPrefix: '--bs-width-',
    classPrefix: 'w-',
    range: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100],
    unit: '%'
))->generate();