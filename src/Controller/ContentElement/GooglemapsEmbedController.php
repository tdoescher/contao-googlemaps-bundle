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
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(category: 'media')]
class GooglemapsEmbedController extends AbstractContentElementController
{
    public function __construct(private readonly ScopeMatcher $scopeMatcher)
    {
    }

    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        if ($this->scopeMatcher->isBackendRequest($request)) {
            return new Response(htmlspecialchars($model->googlemaps_address ?? ''));
        }

        $template->set('googlemaps_address', $model->googlemaps_address ?? '');
        $template->set('googlemaps_apikey', $model->googlemaps_apikey ?? '');
        $template->set('googlemaps_title', $model->googlemaps_title ?? '');
        $template->set('googlemaps_zoom', max(0, min(21, (int) ($model->googlemaps_zoom ?? 16))));

        return $template->getResponse();
    }
}
