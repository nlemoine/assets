<?php # -*- coding: utf-8 -*-

namespace Inpsyde\Assets;

/**
 * We want to load this file just once. Being loaded by Composer autoload, and being in WordPress context,
 * we have to put special care on this.
 */
if (defined(__NAMESPACE__ . '\\BOOTED')) {
    return;
}
const BOOTED = 'inpsyde.assets.booted';

function assetManager(): AssetManager
{

    static $assetManager;

    if (!$assetManager) {
        $assetManager = (new AssetManager())->useDefaultHandlers()->useDefaultOutputFilters();

        add_action(
            'wp_enqueue_scripts',
            [
                $assetManager,
                'setup',
            ],
            PHP_INT_MAX
        );
    }

    return $assetManager;
}

function assetFactory(): AssetFactory
{

    static $factory;

    if (!$factory) {
        $factory = new AssetFactory();
    }

    return $factory;
}

/**
 * @return string     if SCRIPT_DEBUG=true ".min", otherwise ""
 */
function assetPrefix(): string
{

    return defined('SCRIPT_DEBUG') && \SCRIPT_DEBUG
        ? '.min'
        : '';
}

/**
 * Returns ".min" if SCRIPT_DEBUG is false.
 *
 * @return string
 */
function assetSuffix(): string
{

    return defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
}

/**
 * Adding the assetSuffix() before file extension to the given file.
 *
 * @example before: my-script.js | after: my-script.min.js
 *
 * @param string $file
 * @return string
 */
function withAssetSuffix(string $file): string {

    $suffix = assetSuffix();
    $extension = '.' . pathinfo($file, PATHINFO_EXTENSION);

    return str_replace(
        $extension,
        $suffix . $extension,
        $file
    );
}