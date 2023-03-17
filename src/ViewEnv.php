<?php

declare(strict_types=1);

namespace Core\View;

use Core\View\Interfaces\ViewTopology;

class ViewEnv implements ViewTopology
{

    public array $templatePath = [
        'theme_path' => '',
        'system_path' => ''
    ];
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

    public function getTemplatePath(): string
    {
        return $this->templatePath['theme_path'];
    }

    public function getTemplateSystemPath(): string
    {
        return $this->templatePath['system_path'];
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

    public function setTemplatePath(string $path): ViewTopology
    {
        $this->templatePath['theme_path'] = $path;
        return $this;
    }

    public function setTemplateSystemPath(string $path): ViewTopology
    {
        $this->templatePath['system_path'] = $path;
        return $this;
    }

}
