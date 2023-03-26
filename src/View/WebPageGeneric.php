<?php

declare(strict_types=1);

namespace Core\View;

use Core\Interfaces\ViewTopology;
use Core\Interfaces\WebPage;
use \Exception;
use function explode;
use function implode;
use function array_key_exists;
use function array_merge;
use function array_filter;
use function array_unique;
use function json_encode;
use function str_replace;

class WebPageGeneric implements WebPage
{

    private array $attributes = [];
    private ViewTopology $viewTopology;
    private array $jsImportMap = array(
        'imports' => []
    );
    private array $vars = [
        'urlBase' => '',
        'urlLibs' => '',
        'urlCss' => '',
        'urlJs' => '',
        'urlTheme' => '',
        'urlImages' => '',
        'urlFonts' => '',
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
        $keywordsOld = explode(',', $this->vars['keywords']);

        if (is_string($keywords)) {
            $keywords = explode(',', $keywords);
        }

        // merge old keywords and new
        $keywordsNew = array_merge($keywordsOld, $keywords);

        // remove duplicates and empty values
        $result = array_filter(array_unique($keywordsNew));

        $this->vars['keywords'] = implode(',', $result);
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
                $a = $this->viewTopology->getLibsUrl() . '/' . $varValue;
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
        $url = $this->viewTopology->getJsUrl() . '/' . $scriptName . $version;
        $this->setScriptCdn($url, $header, $params);
        return $this;
    }

    public function setScriptLib(string $scriptName, bool $header = true, string $params = ''): self
    {
        $url = $this->viewTopology->getLibsUrl() . '/' . $scriptName;
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
        $url = $this->viewTopology->getCssUrl() . '/' . $styleName . $version;
        $this->setStyleCdn($url);
        return $this;
    }

    public function setStyleLib(string $styleName): self
    {
        $url = $this->viewTopology->getLibsUrl() . '/' . $styleName;
        $this->setStyleCdn($url);
        return $this;
    }

    public function appendScripts(string $data, bool $header = true): self
    {
        if ($header) {
            $this->vars['scripts_header'] .= $data;
        } else {
            $this->vars['scripts_footer'] .= $data;
        }
        return $this;
    }

    public function setAttribute(string $key, mixed $value): self
    {
        if (isset($this->attributes[$key])) {
            throw new Exception("WebPageGeneric::setAttribute() Attribute with key " . $key . " exists");
        }
        $this->attributes[$key] = $value;
        return $this;
    }

    public function getWebpage(): array
    {
        $this->vars['urlBase'] = $this->viewTopology->getBaseUrl();
        $this->vars['urlLibs'] = $this->viewTopology->getLibsUrl();
        $this->vars['urlCss'] = $this->viewTopology->getCssUrl();
        $this->vars['urlJs'] = $this->viewTopology->getJsUrl();
        $this->vars['urlImages'] = $this->viewTopology->getImagesUrl();
        $this->vars['urlFonts'] = $this->viewTopology->getFontsUrl();
        $this->vars['urlTheme'] = $this->viewTopology->getThemeUrl();

        $res = $this->vars;

        foreach ($this->attributes as $key => $value) {
            if (array_key_exists($key, $res)) {
                throw new Exception('WebPageGeneric::getWebpage() Attribute with key ' . $key . ' exists');
            } else {
                $res[$key] = $value;
            }
        }

        return $res;
    }

}
