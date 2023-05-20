<?php

declare(strict_types=1);

namespace Core\View;

use Core\Interfaces\ViewTopologyInterface;

class ViewTopologyGeneric implements ViewTopologyInterface
{

    /**
     * Array of paths for templates
     * @var array
     */
    public array $templatePath = [];

    /**
     * Base urls array
     * @var array
     */
    public array $url = [
        'base_url' => '',
        'libs_url' => '',
        'css_url' => '',
        'images_url' => '',
        'fonts_url' => '',
        'js_url' => '',
        'theme_url' => ''
    ];

    /**
     * @inheritDoc
     */
    public function getBaseUrl(): string
    {
        return $this->url['base_url'];
    }

    /**
     * @inheritDoc
     */
    public function getThemeUrl(): string
    {
        return $this->url['theme_url'];
    }

    /**
     * @inheritDoc
     */
    public function getLibsUrl(): string
    {
        return $this->url['libs_url'];
    }

    /**
     * @inheritDoc
     */
    public function getCssUrl(): string
    {
        return $this->url['css_url'];
    }

    /**
     * @inheritDoc
     */
    public function getJsUrl(): string
    {
        return $this->url['js_url'];
    }

    /**
     * @inheritDoc
     */
    public function getFontsUrl(): string
    {
        return $this->url['fonts_url'];
    }

    /**
     * @inheritDoc
     */
    public function getImagesUrl(): string
    {
        return $this->url['images_url'];
    }

    /**
     * @inheritDoc
     */
    public function getTemplatePath(): array
    {
        return $this->templatePath;
    }

    /**
     * @inheritDoc
     */
    public function setBaseUrl(string $url): ViewTopologyInterface
    {
        $this->url['base_url'] = $url;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setThemeUrl(string $url): ViewTopologyInterface
    {
        $this->url['theme_url'] = $url;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setLibsUrl(string $url): ViewTopologyInterface
    {
        $this->url['libs_url'] = $url;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setCssUrl(string $url): ViewTopologyInterface
    {
        $this->url['css_url'] = $url;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setJsUrl(string $url): ViewTopologyInterface
    {
        $this->url['js_url'] = $url;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setFontsUrl(string $url): ViewTopologyInterface
    {
        $this->url['fonts_url'] = $url;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setImagesUrl(string $url): ViewTopologyInterface
    {
        $this->url['images_url'] = $url;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setTemplatePath(string|array $path): ViewTopologyInterface
    {
        if (is_string($path)) {
            $this->addTemplatePath($path);
        } else {
            foreach ($path as $item) {
                $this->addTemplatePath($item);
            }
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    private function addTemplatePath(string $path): void
    {
        if (!array_key_exists($path, $this->templatePath)) {
            $this->templatePath[] = $path;
        }
    }

}
