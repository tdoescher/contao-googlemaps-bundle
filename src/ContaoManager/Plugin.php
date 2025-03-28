<?php

/**
 * This file is part of Googlemaps Bundle for Contao
 *
 * @package     tdoescher/googlemaps-bundle
 * @author      Torben Döscher <mail@tdoescher.de>
 * @license     LGPL
 * @copyright   tdoescher.de // WEB & IT <https://tdoescher.de>
 */

namespace tdoescher\GooglemapsBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use tdoescher\GooglemapsBundle\GooglemapsBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(GooglemapsBundle::class)
                ->setLoadAfter([ ContaoCoreBundle::class ]),
        ];
    }
}
