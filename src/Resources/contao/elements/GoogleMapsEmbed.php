<?php

namespace tdoescher\GoogleMapsBundle;

use Contao\ContentElement;
use Contao\BackendTemplate;
use Contao\System;

class GoogleMapsEmbed extends ContentElement
{
    protected $strTemplate = 'ce_googlemaps_embed';

    protected function compile()
    {
        $request = System::getContainer()->get('request_stack')->getCurrentRequest();

        if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
        {
            $this->strTemplate = 'be_wildcard';
            $this->Template = new BackendTemplate($this->strTemplate);

            $this->Template->wildcard = $this->arrData['googlemaps_address'];
        }
    }
}
