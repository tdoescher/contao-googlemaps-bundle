<?php

/**
 * This file is part of Googlemaps Bundle for Contao
 *
 * @package     tdoescher/googlemaps-bundle
 * @author      Torben Döscher <mail@tdoescher.de>
 * @license     LGPL
 * @copyright   tdoescher.de // WEB & IT <https://tdoescher.de>
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['googlemaps_embed'] = '{type_legend},type,headline;{googlemaps_legend},googlemaps_title,googlemaps_apikey,googlemaps_zoom,googlemaps_address;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['googlemaps_html'] = '{type_legend},type,headline;{googlemaps_legend},unfilteredHtml;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['fields']['googlemaps_address'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [ 'mandatory' => true, 'tl_class' => 'clr', 'maxlength' => '255' ],
    'sql' => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['googlemaps_apikey'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [ 'mandatory' => true, 'tl_class' => 'clr w50', 'maxlength' => '255' ],
    'sql' => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['googlemaps_title'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [ 'tl_class' => 'w100', 'maxlength' => '255' ],
    'sql' => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['googlemaps_zoom'] = [
    'default' => 16,
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [ 'mandatory' => true, 'tl_class' => 'w50', 'maxlength' => '2' ],
    'sql' => "varchar(2) NOT NULL default '16'"
];
