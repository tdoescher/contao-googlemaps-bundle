<?php

namespace tdoescher\GoogleMapsBundle;

class GoogleMaps extends \ContentElement
{
    protected $strTemplate = 'ce_googlemaps_embed';

    protected function compile()
    {
        if (TL_MODE == 'BE')
        {
            $this->strTemplate = 'be_wildcard';
            $this->Template = new \BackendTemplate($this->strTemplate);

            $this->Template->wildcard = $this->arrData['googlemaps_address'];
        }
    }
}
