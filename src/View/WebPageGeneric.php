<?php

declare(strict_types=1);

namespace Core\View;

use Core\Interfaces\AssetsCollection;
use Core\Interfaces\ViewTopology;
use Core\Interfaces\WebPage;
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

    /**
     * AssetsCollection
     * @var AssetsCollection
     */
    private AssetsCollection $assetsCollection;

    /**
     * Library of page attributes
     * @var array
     */
    private array $attributes = [];

    /**
     * Topology of paths used by rendering engines
     * @var ViewTopology
     */
    private ViewTopology $viewTopology;

    /**
     * JS importmanp data
     * @var array
     */
    private array $jsImportMap = array(
        'imports' => []
    );

    /**
     * Page variables for use in templates
     * @var array
     */
    private array $vars = [
        'base' => '',
        'libs' => '',
        'css' => '',
        'js' => '',
        'theme' => '',
        'images' => '',
        'fonts' => '',
        'microformat' => '',
        'keywords' => '',
        'meta_tags' => '',
        'title' => '',
        'header' => '',
        'description' => '',
        'importmap' => '',
        'scripts_header' => '',
        'scripts_footer' => '',
        'styles' => ''
    ];

    /**
     * WebPageGeneric constructor
     * @param ViewTopology $viewTopology Topology object
     * @param array $scriptsLib Predefined scripts
     * @param array $stylesLib Predefined styles
     */
    public function __construct(
            ViewTopology $viewTopology,
            AssetsCollection $assetsCollection
    )
    {
        $this->viewTopology = $viewTopology;
        $this->assetsCollection = $assetsCollection;
    }

    /**
     * @inheritdoc
     */
    public function setMicroFormatting(string $jsonMicroformat): self
    {
        $this->vars['microformat'] = $jsonMicroformat;
        return $this;
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
    public function setMetaTag(string $name, string $content): self
    {
        $metaTag = '<meta name="' . $name . '" content="' . $content . '">' . PHP_EOL;
        $this->vars['meta_tags'] .= $metaTag;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setCacheControl(string $directive): self
    {
        $metaTag = '<meta http-equiv="Cache-Control" content="' . $directive . '">' . PHP_EOL;
        $this->vars['meta_tags'] .= $metaTag;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setExpires(string $directive): self
    {
        $metaTag = '<meta http-equiv="Expires" content="' . $directive . '">' . PHP_EOL;
        $this->vars['meta_tags'] .= $metaTag;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setLastModified(string $date): self
    {
        $metaTag = '<meta http-equiv="Last-Modified" content="' . $date . '">' . PHP_EOL;
        $this->vars['meta_tags'] .= $metaTag;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setPageTitle(string $pageTitle): self
    {
        $this->vars['title'] = $pageTitle;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setPageHeader(string $pageHeader): self
    {
        $this->vars['header'] = $pageHeader;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setPageDescription(string $description): self
    {
        $this->vars['description'] = $description;
        return $this;
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
    public function setScript(string $scriptName, bool $header = true, string $params = '', string $version = ''): self
    {
        if (!empty($version)) {
            $version = '?v=' . $version;
        }
        $url = $this->viewTopology->getJsUrl() . '/' . $scriptName . $version;
        $this->setScriptCdn($url, $header, $params);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setScriptFromGlobal(string $scriptName, bool $header = true, string $params = ''): self
    {
        $url = $this->viewTopology->getLibsUrl() . '/' . $scriptName;
        $this->setScriptCdn($url, $header, $params);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setScriptFromLib(string $scriptKey, bool $header = true, string $params = ''): self
    {
        $scriptsList = explode(',', $scriptKey);
        foreach ($scriptsList as $cScriptKey) {
            $script = $this->assetsCollection->getScriptUrl($cScriptKey);
            $this->setScriptCdn($script, $header, $params);
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
    public function setStyle(string $styleName, string $version = ''): self
    {
        if (!empty($version)) {
            $version = '?v=' . $version;
        }
        $url = $this->viewTopology->getCssUrl() . '/' . $styleName . $version;
        $this->setStyleCdn($url);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setStyleFromGlobal(string $styleName): self
    {
        $url = $this->viewTopology->getLibsUrl() . '/' . $styleName;
        $this->setStyleCdn($url);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setStyleFromLib(string $styleKey): self
    {
        $stylesList = explode(',', $styleKey);
        foreach ($stylesList as $cStyleKey) {
            $style = $this->assetsCollection->getStyleUrl($cStyleKey);
            $this->setStyleCdn($style);
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function appendScripts(string $data, bool $header = true): self
    {
        if ($header) {
            $this->vars['scripts_header'] .= $data;
        } else {
            $this->vars['scripts_footer'] .= $data;
        }
        return $this;
    }

    public function applyAssetCollection(string $collectionName): self
    {
        $collection = $this->assetsCollection->getCollection($collectionName);
        foreach ($collection['scriptsHeader'] as $sFooter) {
            $this->setScriptCdn($sFooter['script'], true, $sFooter['params']);
        }
        foreach ($collection['scriptsFooter'] as $sHeader) {
            $this->setScriptCdn($sHeader['script'], false, $sHeader['params']);
        }
        foreach ($collection['styles'] as $style) {
            $this->setStyleCdn($style);
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setAttribute(string $key, mixed $value): self
    {
        if (isset($this->attributes[$key])) {
            throw new ViewException("WebPageGeneric::setAttribute() Attribute with key " . $key . " exists");
        }
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getWebpage(): array
    {
        $this->vars['base'] = $this->viewTopology->getBaseUrl();
        $this->vars['libs'] = $this->viewTopology->getLibsUrl();
        $this->vars['css'] = $this->viewTopology->getCssUrl();
        $this->vars['js'] = $this->viewTopology->getJsUrl();
        $this->vars['images'] = $this->viewTopology->getImagesUrl();
        $this->vars['fonts'] = $this->viewTopology->getFontsUrl();
        $this->vars['theme'] = $this->viewTopology->getThemeUrl();

        $res = $this->vars;

        foreach ($this->attributes as $key => $value) {
            if (array_key_exists($key, $res)) {
                throw new ViewException('WebPageGeneric::getWebpage() Attribute with key ' . $key . ' exists');
            } else {
                $res[$key] = $value;
            }
        }

        return $res;
    }

}
