<?php

namespace Ucscode\Style;

require_once 'vendor/autoload.php';

$generator = new Generator();

$sourceCode = $generator->generate();

$filepath = __DIR__ . '/fontsize.css';

if(is_writable($filepath)) {
    file_put_contents($filepath, $sourceCode);
}

echo $sourceCode;