<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withPhpVersion(PhpVersion::PHP_85)
    ->withPaths([__DIR__ . '/sources'])
    ->withSets([
        SetList::TYPE_DECLARATION,
        LevelSetList::UP_TO_PHP_85
    ])
    ->withSkip([
        AddOverrideAttributeToOverriddenMethodsRector::class,
    ])
    ->withComposerBased(symfony: true);
