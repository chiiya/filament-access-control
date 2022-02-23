<?php

use Chiiya\CodeStyle\CodeStyle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(CodeStyle::LARAVEL);
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/resources/lang',
        __DIR__ . '/routes',
    ]);
};
