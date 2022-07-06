<?php declare(strict_types=1);

use Chiiya\CodeStyle\CodeStyle;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $config): void {
    $config->import(CodeStyle::ECS);
    $config->paths([
        __DIR__.'/src',
        __DIR__.'/config',
        __DIR__.'/database',
        __DIR__.'/resources/lang',
        __DIR__.'/routes',
    ]);
};
