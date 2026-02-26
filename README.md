# Googlemaps Bundle for Contao

Contao 5 Bundle zur Einbindung von Google Maps als Content-Element. Es stehen zwei Element-Typen zur Verfügung:

- **Google Maps Embed** – Einbindung per iFrame via Google Maps Embed API (API-Key erforderlich)
- **Google Maps HTML** – Ausgabe von benutzerdefiniertem HTML-Code der Google Maps JavaScript API

## Content-Elemente

### Google Maps Embed (`googlemaps_embed`)

Bettet eine Google Maps Karte per iFrame ein. Die Karte wird über die [Google Maps Embed API](https://developers.google.com/maps/documentation/embed/get-started) geladen.

**Felder:**

| Feld               | Beschreibung                        | Pflichtfeld |
|--------------------|-------------------------------------|-------------|
| `googlemaps_title` | Titel des iFrame (Barrierefreiheit) | Nein        |
| `googlemaps_apikey`| Google Maps API-Key                 | Ja          |
| `googlemaps_zoom`  | Zoom-Stufe (Standard: 16)           | Ja          |
| `googlemaps_address`| Adresse oder Ortsbezeichnung       | Ja          |

Im Backend wird die eingetragene Adresse als Vorschau angezeigt.

### Google Maps HTML (`googlemaps_html`)

Gibt benutzerdefiniertes HTML aus, das z. B. über die Google Maps JavaScript API erzeugt wurde. Der Code wird direkt aus dem Feld `unfilteredHtml` ausgegeben.

Im Backend wird ein statischer Platzhaltertext angezeigt.

## CSP-Konfiguration

Die Templates setzen automatisch die erforderlichen Content Security Policy Header:

**Embed-Element:**
- `frame-src https://www.google.com`

**HTML-Element:**
- `connect-src https://*.google.com`, `https://*.googleapis.com`, `https://*.gstatic.com`
- `font-src https://fonts.gstatic.com`
- `img-src https://*.google.com`, `https://*.googleapis.com`, `https://*.googleusercontent.com`, `https://*.gstatic.com`
- `script-src https://*.google.com`, `https://*.googleapis.com`
- `style-src 'unsafe-inline' https://fonts.googleapis.com`

## Template-Anpassung

Die Twig-Templates befinden sich unter `contao/templates/content_element/` und können wie bei Contao üblich überschrieben werden:

- `googlemaps_embed.html.twig`
- `googlemaps_html.html.twig`

Beide Templates erweitern `@Contao/content_element/_base.html.twig` und verwenden responsive Container mit BEM-Klassen:

```
.content-googlemaps-embed__container
.content-googlemaps-embed__responsive

.content-googlemaps-html__container
.content-googlemaps-html__responsive
```
