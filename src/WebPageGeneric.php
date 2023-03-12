<?php

declare(strict_types=1);

namespace App\View;

use App\View\Interfaces\ViewTopology;
use App\View\Interfaces\WebPage;

class WebPageGeneric implements WebPage
{

    private ViewTopology $viewTopology;
    
    private array $jsImportMap = array(
        'imports' => []
    );
    private array $vars = [
        'microformat' => '',
        'keywords' => '',
        'title' => '',
        'header' => '',
        'description' => '',
        'importmap' => '',
        'scripts_header' => '',
        'scripts_footer' => '',
        'styles' => ''
    ];

    public function __construct(ViewTopology $viewTopology)
    {
        $this->viewTopology = $viewTopology;
    }

    public function setMicroFormatting(string $jsonMicroformat): self
    {
        $this->vars['microformat'] = $jsonMicroformat;
        return $this;
    }

    public function setPageKeywords(string|array $keywords): self
    {
        if (is_array($keywords)) {
            $keywords = implode(',', $keywords);
        }
        $this->vars['keywords'] = $keywords;
        return $this;
    }

    public function setPageTitle(string $pageTitle): self
    {
        $this->vars['title'] = $pageTitle;
        return $this;
    }

    public function setPageHeader(string $pageHeader): self
    {
        $this->vars['header'] = $pageHeader;
        return $this;
    }

    public function setPageDescription(string $description): self
    {
        $this->vars['description'] = $description;
        return $this;
    }

    public function setImportMap(array $vars, bool $internal = true, string $type = "importmap"): self
    {
        foreach ($vars as $oneVar => $varValue) {
            if ($internal) {
                $a = $this->viewTopology->getJsGlobalUrl() . '/' . $varValue;
            } else {
                $a = $varValue;
            }
            $this->jsImportMap['imports'][$oneVar] = $a;
        }
        $template = '<script type="' . $type . '">' . PHP_EOL . '{data}' . PHP_EOL . '</script>';

        $dataString = json_encode($this->jsImportMap, JSON_PRETTY_PRINT);

        $result = str_replace('{data}', $dataString, $template);

        $this->vars['importmap'] = $result;
        return $this;
    }

    public function setScriptCdn(string $address, bool $header = true, string $params = ''): self
    {
        if (!empty($params)) {
            $params = ' ' . $params;
        }
        if ($header) {
            $scripts_place = 'scripts_header';
        } else {
            $scripts_place = 'scripts_footer';
        }
        $string = '<script' . $params . ' src="' . $address . '"></script>' . "\r\n";
        if (isset($this->vars[$scripts_place])) {
            $this->vars[$scripts_place] .= $string;
        } else {
            $this->vars[$scripts_place] = $string;
        }
        return $this;
    }

    public function setScript(string $scriptName, bool $header = true, string $params = '', string $version = ''): self
    {
        if (!empty($version)) {
            $version = '?v=' . $version;
        }
        $url = $this->viewTopology->getJsThemeUrl() . '/' . $scriptName . $version;
        $this->setScriptCdn($url, $header, $params);
        return $this;
    }

    public function setScriptLib(string $scriptName, bool $header = true, string $params = ''): self
    {
        $url = $this->viewTopology->getJsGlobalUrl() . '/' . $scriptName;
        $this->setScriptCdn($url, $header, $params);
        return $this;
    }

    public function setStyleCdn(string $url): self
    {
        $start = '<link rel="stylesheet" href="';
        $end = '">' . "\r\n";
        if (isset($this->vars['styles'])) {
            $this->vars['styles'] .= $start . $url . $end;
        } else {
            $this->vars['styles'] = $start . $url . $end;
        }
        return $this;
    }

    public function setStyle(string $styleName, string $version = ''): self
    {
        if (!empty($version)) {
            $version = '?v=' . $version;
        }
        $url = $this->viewTopology->getCssThemeUrl() . '/' . $styleName . $version;
        $this->setStyleCdn($url);
        return $this;
    }

    public function setStyleLib(string $styleName): self
    {
        $url = $this->viewTopology->getCssGlobalUrl() . '/' . $styleName;
        $this->setStyleCdn($url);
        return $this;
    }

    public function getWebpage(): array
    {
        return $this->vars;
    }

}
