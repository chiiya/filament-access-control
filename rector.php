<?php declare(strict_types=1);

use Chiiya\CodeStyle\CodeStyle;
use Rector\Config\RectorConfig;

return static function (RectorConfig $config): void {
    $config->import(CodeStyle::RECTOR);
    $config->paths([
        __DIR__.'/src',
        __DIR__.'/config',
        __DIR__.'/database',
        __DIR__.'/resources/lang',
        __DIR__.'/routes',
    ]);
    $config->importNames();
};
