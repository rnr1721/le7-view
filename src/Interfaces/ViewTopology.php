<?php

declare(strict_types=1);

namespace Core\Interfaces;

interface ViewTopology
{

    /**
     * Get base URL of site
     * @param string $url Full URL
     * @return self
     */
    public function setBaseUrl(string $url): self;

    /**
     * Get JavaScript URL
     * @param string $url Full URL
     * @return self
     */
    public function setJsUrl(string $url): self;

    /**
     * Get Libs URL
     * @param string $url Full URL
     * @return self
     */
    public function setLibsUrl(string $url): self;

    /**
     * Get Theme CSS URL
     * @param string $url Full URL
     * @return self
     */
    public function setCssUrl(string $url): self;

    /**
     * Get theme fonts URL
     * @param string $url Full URL
     * @return self
     */
    public function setFontsUrl(string $url): self;

    /**
     * Get theme images URL
     * @param string $url Full URL
     * @return self
     */
    public function setImagesUrl(string $url): self;

    /**
     * Get theme URL
     * @param string $url Full URL
     * @return self
     */
    public function setThemeUrl(string $url): self;

    /**
     * Set filesystem path to HTML templates
     * @param string $path Full or relative path
     * @return self
     */
    public function setTemplatePath(string $path): self;

    /**
     * Set alternative path to HTML templates
     * @param string $path Full or relative path
     * @return self
     */
    public function setTemplateSystemPath(string $path): self;

    /**
     * Get base URL of site
     * @return string
     */
    public function getBaseUrl(): string;

    /**
     * Get theme JavaScript URL
     * @return string
     */
    public function getJsUrl(): string;

    /**
     * Get theme CSS URL
     * @return string
     */
    public function getCssUrl(): string;

    /**
     * Get theme fonts URL
     * @return string
     */
    public function getFontsUrl(): string;

    /**
     * Get theme images URL
     * @return string
     */
    public function getImagesUrl(): string;

    /**
     * Get theme URL
     * @return string
     */
    public function getThemeUrl(): string;

    /**
     * Get libs URL
     * @return string
     */
    public function getLibsUrl(): string;

    /**
     * Get filesystem template path
     * @return string
     */
    public function getTemplatePath(): string;

    /**
     * Get gilesystem template alternative path
     * @return string
     */
    public function getTemplateSystemPath(): string;
}
