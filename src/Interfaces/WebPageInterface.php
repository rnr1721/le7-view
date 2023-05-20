<?php

declare(strict_types=1);

namespace Core\Interfaces;

/**
 * WebPage object - all that needs to build web page
 */
interface WebPageInterface
{

    /**
     * Set json for microformatting
     * @param string $jsonMicroformat JSON string
     * @return self
     */
    public function setMicroFormatting(string $jsonMicroformat): self;

    /**
     * Set keywords.
     * This function check for duplicates
     * @param string|array $keywords Array key=>value or string
     * @return self
     */
    public function setPageKeywords(string|array $keywords): self;

    /**
     * Add meta-tag to webPage
     * @param string $name Meta name
     * @param string $content Meta content
     * @return self
     */
    public function setMetaTag(string $name, string $content): self;

    /**
     * Add cache-control meta tag to web page
     * @param string $directive
     * @return self
     */
    public function setCacheControl(string $directive): self;

    /**
     * Add expires meta tag to web page
     * @param string $directive
     * @return self
     */
    public function setExpires(string $directive): self;

    /**
     * Add Last-Modified meta tag to web page
     * @param string $date
     * @return self
     */
    public function setLastModified(string $date): self;

    /**
     * Page title (title tag)
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
     * Page description
     * @param string $description Meta description
     * @return self
     */
    public function setPageDescription(string $description): self;

    /**
     * JS import map
     * @param array $vars Data $key=>$value of importmap
     * @param bool $internal From CDN or internal
     * @param string $type Type if any other
     * @return self
     */
    public function setImportMap(array $vars, bool $internal = true, string $type = "importmap"): self;

    /**
     * Plug any script from CDN or any URL
     * @param string $address URL of script
     * @param bool $header In header or in footer
     * @param string $params Any string params
     * @return self
     */
    public function setScriptCdn(string $address, bool $header = true, string $params = ''): self;

    /**
     * Plug script from theme folder
     * @param string $scriptName
     * @param bool $header In header or footer
     * @param string $params Ant string params
     * @param string $version Version as number
     * @return self
     */
    public function setScript(string $scriptName, bool $header = true, string $params = '', string $version = ''): self;

    /**
     * Plug script from libs folder
     * @param string $scriptName
     * @param bool $header In header or footer
     * @param string $params Any string params
     * @return self
     */
    public function setScriptFromGlobal(string $scriptName, bool $header = true): self;

    /**
     * Plug script from predefined library (defined in WebPage obj constructor)
     * You can put comma-separated keys in $scriptKey param
     * @param string $scriptKey Name of script in library (may comma-separated)
     * @param bool $header In header or in footer
     * @param string $params
     * @return self
     */
    public function setScriptFromLib(string $scriptKey, bool $header = true, string $params = ''): self;

    /**
     * Put content after scripts section
     * @param string $data String data
     * @param bool $header In header or in footer
     * @return self
     */
    public function appendScripts(string $data, bool $header = true): self;

    /**
     * Apply collection of assets to page
     * @param string $collectionName Name of collection
     * @return self
     */
    public function applyAssetCollection(string $collectionName): self;

    /**
     * Plug style from cdn or any URL
     * @param string $url URL of style
     * @return self
     */
    public function setStyleCdn(string $url): self;

    /**
     * Plug style from theme folder
     * @param string $styleName Style filename
     * @param string $version Version
     * @return self
     */
    public function setStyle(string $styleName, string $version = ''): self;

    /**
     * Plug style from libs folder
     * @param string $styleName Filename stylesheet
     * @return self
     */
    public function setStyleFromGlobal(string $styleName): self;

    /**
     * Plug style from library defined in webPage object constructor
     * while it created
     * You can put comma-separated style keys to $styleKey param
     * @param string $styleKey Name of style (can be comma-separated)
     * @return self
     */
    public function setStyleFromLib(string $styleKey): self;

    /**
     * Set mixed attribute to use in webpage templates
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
