<?php

declare(strict_types=1);

namespace App\View\Interfaces;

interface WebPage
{

    public function setMicroFormatting(string $jsonMicroformat): self;

    public function setPageKeywords(string|array $keywords): self;

    public function setPageTitle(string $pageTitle): self;

    public function setPageHeader(string $pageHeader): self;

    public function setPageDescription(string $description): self;

    public function setImportMap(array $vars, bool $internal = true, string $type = "importmap"): self;

    public function setScriptCdn(string $address, bool $header = true, string $params = ''): self;

    public function setScript(string $scriptName, bool $header = true, string $params = '', string $version = ''): self;

    public function setScriptLib(string $scriptName, bool $header = true, string $params = ''): self;

    public function setStyleCdn(string $url): self;

    public function setStyle(string $styleName, string $version = ''): self;

    public function setStyleLib(string $styleName): self;

    public function getWebpage(): array;
}
