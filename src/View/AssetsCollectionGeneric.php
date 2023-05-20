<?php

declare(strict_types=1);

namespace Core\View;

use Core\Interfaces\AssetsCollectionInterface;

class AssetsCollectionGeneric implements AssetsCollectionInterface
{

    /**
     * Scripts library
     * @var array
     */
    protected array $scripts = [];

    /**
     * Styles library
     * @var array
     */
    protected array $styles = [];

    /**
     * Collections library
     * @var array
     */
    protected array $collections = [];

    public function __construct(
            array $scripts = [],
            array $styles = [],
            array $collections = []
    )
    {
        foreach ($scripts as $scriptKey => $scriptValue) {
            if (is_array($scriptValue)) {
                if (isset($scriptValue['script']) && isset($scriptValue['params'])) {
                    $this->scripts[$scriptKey] = $scriptValue;
                }
            } else {
                $this->scripts[$scriptKey] = [
                    'script' => $scriptValue,
                    'params' => ''
                ];
            }
        }
        $this->styles = $styles;
        foreach ($collections as $collectionName => $collectionValue) {
            $cScriptHeaders = $collectionValue['scripts_header'] ?? [];
            $cScriptFooters = $collectionValue['scripts_footer'] ?? [];
            $cStyles = $collectionValue['styles'] ?? [];
            $this->setCollection($collectionName, $cScriptHeaders, $cScriptFooters, $cStyles);
        }
    }

    /**
     * @inheritDoc
     */
    public function setScript(string $scriptKey, string $scriptUrl, string $params = ''): self
    {
        $this->scripts[$scriptKey] = ['script' => $scriptUrl, 'params' => $params];
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setStyle(string $styleKey, string $styleUrl): self
    {
        $this->styles[$styleKey] = $styleUrl;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setCollection(
            string $name,
            array $scriptHeaderKeys = [],
            array $scriptFooterKeys = [],
            array $styleKeys = []
    ): self
    {
        $this->collections[$name] = [
            'scriptsHeader' => $this->getFilteredScripts($scriptHeaderKeys),
            'scriptsFooter' => $this->getFilteredScripts($scriptFooterKeys),
            'styles' => $this->getFilteredStyles($styleKeys),
        ];
        return $this;
    }

    protected function getFilteredScripts(array $scriptKeys): array
    {
        $filteredScripts = [];
        foreach ($scriptKeys as $key) {
            if (!isset($this->scripts[$key])) {
                throw new ViewException("JS Script key not found: $key");
            }
            $filteredScripts[$key] = $this->scripts[$key];
        }
        return $filteredScripts;
    }

    protected function getFilteredStyles(array $styleKeys): array
    {
        $filteredStyles = [];
        foreach ($styleKeys as $key) {
            if (!isset($this->styles[$key])) {
                throw new ViewException("CSS Style key not found: $key");
            }
            $filteredStyles[$key] = $this->styles[$key];
        }
        return $filteredStyles;
    }

    /**
     * @inheritDoc
     */
    public function getCollection(string $name): array
    {
        if (!isset($this->collections[$name])) {
            throw new ViewException("Assets collection key not found: $name");
        }
        return $this->collections[$name];
    }

    /**
     * @inheritDoc
     */
    public function getScriptUrl(string $scriptKey): string
    {
        if (!isset($this->scripts[$scriptKey])) {
            throw new ViewException("Script key not found: $scriptKey");
        }
        return $this->scripts[$scriptKey]['script'];
    }

    /**
     * @inheritDoc
     */
    public function getStyleUrl(string $styleKey): string
    {
        if (!isset($this->styles[$styleKey])) {
            throw new ViewException("Style key not found: $styleKey");
        }
        return $this->styles[$styleKey];
    }

    /**
     * @inheritDoc
     */
    public function reset(): self
    {
        $this->scripts = [];
        $this->styles = [];
        $this->collections = [];
        return $this;
    }

}
