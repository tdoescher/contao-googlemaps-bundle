<?php

/**
 * This file is part of Googlemaps Bundle for Contao
 *
 * @package     tdoescher/googlemaps-bundle
 * @author      Torben Döscher <mail@tdoescher.de>
 * @license     LGPL
 * @copyright   tdoescher.de // WEB & IT <https://tdoescher.de>
 */

namespace tdoescher\GooglemapsBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\System;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(category: 'media')]
class GooglemapsEmbedController extends AbstractContentElementController
{
    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
            return new Response($model->googlemaps_address);
        }

        $template->set('address', $model->googlemaps_address);
        $template->set('apikey', $model->googlemaps_apikey);
        $template->set('title', $model->googlemaps_title);
        $template->set('zoom', $model->googlemaps_zoom);

        return $template->getResponse();
    }
}
