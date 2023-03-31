<?php

declare(strict_types=1);

namespace Core\View;

use Core\Interfaces\ViewTopology;

class ViewTopologyGeneric implements ViewTopology
{

    public array $templatePath = [];
    public array $url = [
        'base_url' => '',
        'libs_url' => '',
        'css_url' => '',
        'images_url' => '',
        'fonts_url' => '',
        'js_url' => '',
        'theme_url' => ''
    ];

    public function getBaseUrl(): string
    {
        return $this->url['base_url'];
    }

    public function getThemeUrl(): string
    {
        return $this->url['theme_url'];
    }

    public function getLibsUrl(): string
    {
        return $this->url['libs_url'];
    }

    public function getCssUrl(): string
    {
        return $this->url['css_url'];
    }

    public function getJsUrl(): string
    {
        return $this->url['js_url'];
    }

    public function getFontsUrl(): string
    {
        return $this->url['fonts_url'];
    }

    public function getImagesUrl(): string
    {
        return $this->url['images_url'];
    }

    public function getTemplatePath(): array
    {
        return $this->templatePath;
    }

    public function setBaseUrl(string $url): ViewTopology
    {
        $this->url['base_url'] = $url;
        return $this;
    }

    public function setThemeUrl(string $url): ViewTopology
    {
        $this->url['theme_url'] = $url;
        return $this;
    }

    public function setLibsUrl(string $url): ViewTopology
    {
        $this->url['libs_url'] = $url;
        return $this;
    }

    public function setCssUrl(string $url): ViewTopology
    {
        $this->url['css_url'] = $url;
        return $this;
    }

    public function setJsUrl(string $url): ViewTopology
    {
        $this->url['js_url'] = $url;
        return $this;
    }

    public function setFontsUrl(string $url): ViewTopology
    {
        $this->url['fonts_url'] = $url;
        return $this;
    }

    public function setImagesUrl(string $url): ViewTopology
    {
        $this->url['images_url'] = $url;
        return $this;
    }

    public function setTemplatePath(string|array $path): ViewTopology
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

    private function addTemplatePath(string $path): void
    {
        if (!array_key_exists($path, $this->templatePath)) {
            $this->templatePath[] = $path;
        }
    }

}
