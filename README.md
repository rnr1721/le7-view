# le7-view
Base View component for le7 framework or any PHP projects.

You can install any of this in any PHP 8 PSR project.

## Requirements

- PHP 8.1 or higher.
- Composer 2.0 or higher.

## What it can?

- AssetsCollection object for manage collections of JS and CSS
- WebPage object for store webpage header and scripts data
- ViewTrait that part of any view adapter for le7-framework

## Installation

This component is dependency for this projects:

- https://github.com/rnr1721/le7-view-twig - Twig renderer
- https://github.com/rnr1721/le7-view-smarty - Smarty renderer
- https://github.com/rnr1721/le7-view-php - PHP renderer

You must install one of them to use it, but...

```shell
composer require rnr1721/le7-view
```

## Testing

```shell
composer test
```

## AssetsCollection

This is great tool to manage assets collection. It can be controlled by
special setter methods or you can set configuration array into constructor.

Example of configuration:

```php
        $styles = [
            'bootstrap5' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css'
        ];

        $scripts = [
            'axios' => [
                // You can define with params as need
                'script' => 'https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js',
                'params' => 'defer'
            ],
            // Or you can define scripts directly
            'jquery' => 'https://code.jquery.com/jquery-3.7.0.min.js',
            'vuejs' => 'https://cdn.jsdelivr.net/npm/vue@2.7.8/dist/vue.js',
            'bootstrap5' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js'
        ];

        $collections = [
            'mycollection' => [
                'scripts_header' => [
                    'vuejs'
                ],
                'scripts_footer' => [
                    
                ],
                'styles' => [
                    'bootstrap5'
                ]
            ]
        ];
```

Now, we can create instance of AssetsCollectionGeneric (implements
AssetsCollectionInterface):

```php
use Core\View\AssetsCollectionGeneric;
$ac = new AssetsCollectionGeneric($scripts, $styles, $collections);
```

### Methods for setting scripts

#### setStyle

You can set new style to styles library:

```php
$ac->setStyle('bootstrap5', 'https://link_to_bootstrap5.css');
```

#### setScript

You can set new scripts to styles library:

```php
$params = 'defer' // Not-required
$ac->setScript('bootstrap5', 'https://link_to_bootstrap5.js', $params);
```

#### setCollection

You can set new collection to styles library:
For example, we need collection, where will be vuejs JS and bootstrap5 CSS:
Of course, all scripts with keys need to be defined before.

```php
// Add to header
$ac->setCollection('mycollection', ['vuejs'], [], ['bootstrap5']);
// Add to footer
$ac->setCollection('mycollection', [], ['vuejs'], ['bootstrap5']);
```

### WebPage object

WebPage object collects various information about web page and you can
use in in webpage template - scripts, styles, meta-tags, import maps,
title, description, keywords etc.

### ViewTopology object

ViewTopology needs to store base paths and urls.
