<?php

declare(strict_types=1);

namespace App\View\Interfaces;

interface ViewTopology
{

    public function setBaseUrl(string $url): self;

    public function setJsThemeUrl(string $url): self;

    public function setJsGlobalUrl(string $url): self;

    public function setCssThemeUrl(string $url): self;

    public function setCssGlobalUrl(string $url): self;

    public function setTemplatePath(string $path): self;

    public function setTemplateSystemPath(string $path): self;

    public function getBaseUrl(): string;

    public function getJsThemeUrl(): string;

    public function getJsGlobalUrl(): string;

    public function getCssThemeUrl(): string;

    public function getCssGlobalUrl(): string;

    public function getTemplatePath(): string;

    public function getTemplateSystemPath(): string;
}
