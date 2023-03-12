<?php

declare(strict_types=1);

namespace App\View;

use App\View\Interfaces\ViewTopology;

class ViewEnv implements ViewTopology
{

    public array $templatePath = [
        'theme_path' => '',
        'system_path' => ''
    ];
    public array $url = [
        'base_url' => '',
        'css_global_url' => '',
        'css_theme_url' => '',
        'js_global_url' => '',
        'js_theme_url' => ''
    ];

    public function getBaseUrl(): string
    {
        return $this->url['base_url'];
    }

    public function getCssGlobalUrl(): string
    {
        return $this->url['css_global_url'];
    }

    public function getCssThemeUrl(): string
    {
        return $this->url['css_theme_url'];
    }

    public function getJsGlobalUrl(): string
    {
        return $this->url['js_global_url'];
    }

    public function getJsThemeUrl(): string
    {
        return $this->url['js_theme_url'];
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

    public function setCssGlobalUrl(string $url): ViewTopology
    {
        $this->url['css_global_url'] = $url;
        return $this;
    }

    public function setCssThemeUrl(string $url): ViewTopology
    {
        $this->url['css_theme_url'] = $url;
        return $this;
    }

    public function setJsGlobalUrl(string $url): ViewTopology
    {
        $this->url['js_global_url'] = $url;
        return $this;
    }

    public function setJsThemeUrl(string $url): ViewTopology
    {
        $this->url['js_theme_url'] = $url;
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
