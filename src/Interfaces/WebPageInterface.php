<?php

declare(strict_types=1);

namespace Core\Interfaces;

/**
 * WebPage object - all that needs to build web page
 */
interface WebPageInterface
{

    /**
     * Add any meta-tag to webPage
     * 
     * @param string $attribute Ecample: "name"
     * @param string $value Example: "description"
     * @param string|null $content Optional. Example: "page description"
     * @return self
     * 
     * @example
     * $webPage->setMetaTag('name','description','page description');
     */
    public function setMetaTag(string $attribute, string $value, ?string $content = null): self;

    /**
     * Set json for microformatting
     * @param string $jsonMicroformat JSON string
     * @return self
     */
    public function setMicroFormatting(string $jsonMicroformat): self;

    /**
     * Set page viewport
     * @param string $viewport Default: width=device-width, initial-scale=1.0
     * @return self
     */
    public function setPageViewport(string $viewport): self;

    /**
     * The keywords tag is used to specify a list of keywords or phrases that
     * are relevant to the content of a web page. These keywords can help
     * search engines understand the topics covered on the page and can be
     * used for SEO (Search Engine Optimization) purposes. It is typically
     * placed within the head section of an HTML document.
     * This method check keywords for duplicates and add only new values
     * 
     * @param string|array $keywords Array key=>value or string comma-divided
     * @return self
     */
    public function setPageKeywords(string|array $keywords): self;

    /**
     * The charset tag is used to declare the character encoding used in
     * the HTML document. It specifies the character set or encoding scheme
     * that should be used to interpret the characters in the document.
     * Commonly used character encodings include UTF-8, ISO-8859-1,
     * and Windows-1252. The charset tag is typically placed within
     * the head section of an HTML document, and its value is specified
     * using the charset attribute.
     * 
     * @param string $charset Default: UTF-8
     * @return self
     */
    public function setPageCharset(string $charset): self;

    /**
     * The cache-control meta tag controls the caching of a page in the
     * client's browser or on proxy servers. It determines whether the page
     * should be cached and, if so, for how long
     * 
     * @param string $directive Example: max-age=3600
     * @return self
     */
    public function setCacheControl(string $directive): self;

    /**
     * The expires meta tag specifies the date and time when the page expires
     * and should be refreshed from the source. It helps the browser understand
     * when to request an updated version of the page
     * 
     * @param string $directive Example: Wed, 26 May 2023 12:00:00 GMT
     * @return self
     */
    public function setExpires(string $directive): self;

    /**
     * The last-modified meta tag specifies the date and time of the last
     * modification of the page. It helps the browser and proxy servers
     * determine whether to request an updated version of the page
     * 
     * @param string $date Example: Wed, 26 May 2023 10:00:00 GMT
     * @return self
     */
    public function setLastModified(string $date): self;

    /**
     * The etag meta tag defines a unique identifier (hash) for the version
     * of the page. It is used to check if the page has changed since the
     * last request, and if not, the browser can use the cached version
     * 
     * @param string $content Example: unique-id
     * @return self
     */
    public function setEtag(string $content): self;

    /**
     * The pragma meta tag is used to control caching on proxy servers.
     * It can take values like no-cache, public, or private
     * 
     * @param string $content Example: no-cache
     * @return self
     */
    public function setPragma(string $content): self;

    /**
     * The title tag is used to specify the title of a web page. It defines
     * the title that is displayed in the browser's title bar or tab for that
     * particular page
     * 
     * @param string $pageTitle Title of page
     * @return self
     */
    public function setPageTitle(string $pageTitle): self;

    /**
     * Page header (H1)
     * @param string $pageHeader Content for H1
     * @return self
     */
    public function setPageHeader(string $pageHeader): self;

    /**
     * The meta tag with the name attribute set to "description" is used to
     * provide a brief description of the web page. This description is often
     * displayed by search engines in their search results
     * 
     * @param string $description Meta description
     * @return self
     */
    public function setPageDescription(string $description): self;

    /**
     * Import Maps is a feature introduced in modern JavaScript that allows
     * you to define mappings between module specifiers and their corresponding
     * locations. It provides a way to control module loading and resolve
     * dependencies in a more flexible manner.
     * 
     * With Import Maps, you can specify explicit mappings between module
     * names and URLs, bypassing the need for a package manager or a bundler.
     * This is particularly useful when you want to load modules directly from
     * specific URLs or CDN (Content Delivery Network) locations.
     * 
     * @param array $vars Data $key=>$value of importmap
     * @param bool $internal From CDN or internal
     * @param string $type Type if any other
     * @return self
     */
    public function setImportMap(array $vars, bool $internal = true, string $type = "importmap"): self;

    /**
     * Plug any script from CDN or any URL
     * 
     * @param string $address URL of script
     * @param bool $header In header or in footer
     * @param string $params Any string params
     * @return self
     */
    public function setScriptCdn(string $address, bool $header = true, string $params = ''): self;

    /**
     * Plug script from theme folder
     * 
     * @param string $scriptName
     * @param bool $header In header or footer
     * @param string $params Ant string params
     * @param string $version Version as number
     * @return self
     */
    public function setScript(string $scriptName, bool $header = true, string $params = '', string $version = ''): self;

    /**
     * Plug script from libs folder
     * 
     * @param string $scriptName
     * @param bool $header In header or footer
     * @param string $params Any string params
     * @return self
     */
    public function setScriptFromGlobal(string $scriptName, bool $header = true): self;

    /**
     * Plug script from predefined library (defined in WebPage obj constructor)
     * You can put comma-separated keys in $scriptKey param
     * 
     * @param string $scriptKey Name of script in library (may comma-separated)
     * @param bool $header In header or in footer
     * @param string $params
     * @return self
     */
    public function setScriptFromLib(string $scriptKey, bool $header = true, string $params = ''): self;

    /**
     * Put content after scripts section
     * 
     * @param string $data String data
     * @param bool $header In header or in footer
     * @return self
     */
    public function appendScripts(string $data, bool $header = true): self;

    /**
     * Apply collection of assets to page
     * 
     * @param string $collectionName Name of collection
     * @return self
     */
    public function applyAssetCollection(string $collectionName): self;

    /**
     * Plug style from cdn or any URL
     * 
     * @param string $url URL of style
     * @return self
     */
    public function setStyleCdn(string $url): self;

    /**
     * Plug style from theme folder
     * 
     * @param string $styleName Style filename
     * @param string $version Version
     * @return self
     */
    public function setStyle(string $styleName, string $version = ''): self;

    /**
     * Plug style from libs folder
     * 
     * @param string $styleName Filename stylesheet
     * @return self
     */
    public function setStyleFromGlobal(string $styleName): self;

    /**
     * Plug style from library defined in webPage object constructor
     * while it created
     * You can put comma-separated style keys to $styleKey param
     * 
     * @param string $styleKey Name of style (can be comma-separated)
     * @return self
     */
    public function setStyleFromLib(string $styleKey): self;

    /**
     * Set mixed attribute to use in webpage templates as variables
     * 
     * @param string $key Key of attribute
     * @param mixed $value Value of attribute
     * @return self
     */
    public function setAttribute(string $key, mixed $value): self;

    /**
     * Get result webpage array
     * @return array
     */
    public function getWebpage(): array;
}
