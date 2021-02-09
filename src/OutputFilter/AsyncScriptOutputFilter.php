<?php

/*
 * This file is part of the Assets package.
 *
 * (c) Inpsyde GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Inpsyde\Assets\OutputFilter;

use Inpsyde\Assets\Asset;

class AsyncScriptOutputFilter implements AssetOutputFilter
{

    public function __invoke(string $html, Asset $asset): string
    {
        $typeAttr = function_exists('is_admin') && ! is_admin() && function_exists('current_theme_supports') && ! current_theme_supports('html5', 'script') ? " type='text/javascript'" : '';
        return str_replace("{$typeAttr} src='{$asset->url()}", " async{$typeAttr} src='{$asset->url()}", $html);
    }
}
