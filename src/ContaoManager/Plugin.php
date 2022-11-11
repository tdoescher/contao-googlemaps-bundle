<?php

namespace tdoescher\GoogleMapsBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use tdoescher\GoogleMapsBundle\GoogleMapsBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(GoogleMapsBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
