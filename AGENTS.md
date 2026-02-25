# AGENTS.md – Entwicklungsrichtlinien für contao-googlemaps-bundle

Dieses Dokument beschreibt die Projektstruktur, Build-Befehle und Code-Style-Richtlinien
für das `tdoescher/googlemaps-bundle` – ein Contao 5 Bundle zur Einbindung von Google Maps
als Content-Element (Embed API oder HTML-Code).

---

## Projektübersicht

| Eigenschaft        | Wert                                      |
|--------------------|-------------------------------------------|
| Typ                | Contao-Bundle (`contao-bundle`)           |
| PHP-Mindestversion | `>=8.0`                                   |
| Contao-Version     | `^5.3`                                    |
| Root-Namespace     | `tdoescher\GooglemapsBundle\`             |
| Autoloading        | PSR-4                                     |
| Lizenz             | LGPL-3.0-or-later                         |

---

## Verzeichnisstruktur

```
contao-googlemaps-bundle/
├── composer.json
├── src/
│   ├── GooglemapsBundle.php                        # Bundle-Klasse
│   ├── ContaoManager/
│   │   └── Plugin.php                              # Contao Manager Plugin
│   ├── Controller/
│   │   └── ContentElement/
│   │       ├── GooglemapsEmbedController.php       # Embed API Controller
│   │       └── GooglemapsHtmlController.php        # HTML-Code Controller
│   ├── DependencyInjection/
│   │   └── GooglemapsExtension.php                 # DI Extension
│   └── Resources/
│       ├── config/
│       │   └── controller.yaml                     # Service-Konfiguration
│       └── contao/
│           ├── dca/
│           │   └── tl_content.php                  # DCA-Felddefinitionen
│           ├── languages/
│           │   └── de/
│           │       ├── default.php
│           │       └── tl_content.php              # Deutsche Übersetzungen
│           └── templates/
│               └── content_element/
│                   ├── googlemaps_embed.html.twig
│                   └── googlemaps_html.html.twig
```

---

## Build-, Lint- und Test-Befehle

Dieses Projekt hat **keine konfigurierte Entwicklungs-Toolchain** (kein Makefile,
kein phpunit.xml, kein `.php-cs-fixer.php`, kein GitHub Actions Workflow).

### Abhängigkeiten installieren

```bash
composer install
```

### Paket aktualisieren

```bash
composer update
```

### Tests

Aktuell sind **keine automatisierten Tests** vorhanden. Bei Bedarf PHPUnit einrichten:

```bash
composer require --dev phpunit/phpunit
# Einzelnen Test ausführen:
vendor/bin/phpunit tests/Controller/GooglemapsEmbedControllerTest.php
# Alle Tests ausführen:
vendor/bin/phpunit
```

### Code Style (empfohlen, noch nicht konfiguriert)

```bash
# PHP-CS-Fixer einrichten und ausführen:
composer require --dev friendsofphp/php-cs-fixer
vendor/bin/php-cs-fixer fix src/

# PHPStan statische Analyse:
composer require --dev phpstan/phpstan
vendor/bin/phpstan analyse src/ --level=8
```

---

## Code-Style-Richtlinien

### Datei-Header

Jede PHP-Datei beginnt mit `<?php`, einer Leerzeile und diesem Docblock:

```php
<?php

/**
 * This file is part of Googlemaps Bundle for Contao
 *
 * @package     tdoescher/googlemaps-bundle
 * @author      Torben Döscher <mail@tdoescher.de>
 * @license     LGPL
 * @copyright   tdoescher.de // WEB & IT <https://tdoescher.de>
 */
```

### Namespaces

- Root-Namespace: `tdoescher\GooglemapsBundle\` (Vendor-Teil **bewusst kleingeschrieben**)
- Namespace-Deklaration direkt nach dem Datei-Header, ohne Leerzeile dazwischen
- Unternamespaces spiegeln die Verzeichnisstruktur unter `src/` wider

```php
namespace tdoescher\GooglemapsBundle\Controller\ContentElement;
```

### Import / Use-Statements

- Alphabetisch sortiert innerhalb logischer Gruppen (Contao, Symfony, eigene Klassen)
- Zwischen Gruppen **eine Leerzeile**
- Eigene Bundle-Klassen werden zuletzt importiert

```php
use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\System;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
```

### Klassen

- Eine Klasse pro Datei
- Klassenname entspricht dem Dateinamen (PSR-4)
- PHP 8 Attribute (`#[...]`) werden für Contao-Content-Elemente verwendet:

```php
#[AsContentElement(category: 'media')]
class GooglemapsEmbedController extends AbstractContentElementController
{
```

### Methoden und Type-Hints

- Vollständige **Return-Type-Hints** für alle Methoden (PHP 8 Syntax)
- Vollständige **Parameter-Type-Hints**
- Neue Methoden sollten `: void` als Return-Type deklarieren, wenn nichts zurückgegeben wird

```php
protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
{
    // ...
}
```

### Null-Koaleszenz

Bevorzuge den Null-Koaleszenz-Operator `??` statt expliziter Null-Prüfungen:

```php
$template->set('html', $model->unfilteredHtml ?? '');
```

### Arrays

- Kurzschreibweise `[ ]` (nicht `array()`)
- Assoziative Arrays über mehrere Zeilen mit 4-Leerzeichen-Einrückung
- Inline-Arrays mit Leerzeichen nach `[` und vor `]`:

```php
'eval' => [ 'mandatory' => true, 'tl_class' => 'clr', 'maxlength' => '255' ],
```

### Einrückung und Formatierung

- **4 Leerzeichen** pro Einrückungsebene (keine Tabs)
- Öffnende geschweifte Klammern `{` auf **neuer Zeile** bei Klassen
- Öffnende geschweifte Klammern auf **gleicher Zeile** bei Methoden
- Keine abschließenden Leerzeichen am Zeilenende

### Error Handling

- Keine eigenen Exception-Klassen vorhanden; bei Bedarf im Namespace
  `tdoescher\GooglemapsBundle\Exception\` anlegen
- Contao-spezifische Prüfungen (z.B. Backend vs. Frontend) direkt im Controller:

```php
if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
    return new Response($model->googlemaps_address);
}
```

---

## Contao-spezifische Konventionen

### DCA-Felddefinitionen (`tl_content.php`)

- Feldnamen mit Bundle-Präfix: `googlemaps_*`
- Paletten als einzeilige Strings mit `{legend_name}` Gruppen
- Felddefinitionen als strukturierte Arrays ohne abschließendes Komma nach letztem Eintrag

```php
$GLOBALS['TL_DCA']['tl_content']['fields']['googlemaps_address'] = [
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => [ 'mandatory' => true, 'tl_class' => 'clr', 'maxlength' => '255' ],
    'sql'       => "varchar(255) NOT NULL default ''"
];
```

### Übersetzungen (Language-Dateien)

- Nur deutschsprachige Übersetzungen (`de/`) vorhanden
- Einzeilige Zuweisung, Felder als Array `[Label, Beschreibung]`:

```php
$GLOBALS['TL_LANG']['tl_content']['googlemaps_address'] = [ 'Adresse', 'Beschreibungstext.' ];
```

### Twig-Templates

- Erweitern immer `@Contao/content_element/_base.html.twig`
- CSP-Direktiven mit `{% do csp_source('...', '...') %}` vor dem `{% block content %}`
- BEM-ähnliche CSS-Klassen: `content-{element-name}__{block}`
- Inline-Bedingungen für optionale Attribute: `{% if title %} title="{{ title }}"{% endif %}`

### Service-Konfiguration (`controller.yaml`)

```yaml
services:
  _defaults:
    autoconfigure: true

  tdoescher\GooglemapsBundle\Controller\ContentElement\GooglemapsEmbedController: ~
```

---

## Neue Content-Elemente hinzufügen

1. Controller in `src/Controller/ContentElement/` erstellen mit `#[AsContentElement]`-Attribut
2. Service in `src/Resources/config/controller.yaml` registrieren
3. DCA-Palette und Felder in `src/Resources/contao/dca/tl_content.php` definieren
4. Übersetzungen in `src/Resources/contao/languages/de/tl_content.php` ergänzen
5. Twig-Template in `src/Resources/contao/templates/content_element/` anlegen
