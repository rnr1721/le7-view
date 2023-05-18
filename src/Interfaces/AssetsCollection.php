<?php

namespace Core\Interfaces;

/**
 * Assets collection manager
 */
interface AssetsCollection
{

    /**
     * Add new script to repository
     * @param string $scriptKey Key of script
     * @param string $scriptUrl Url of script
     * @param string $params Params (for example 'defer')
     * @return self
     */
    public function setScript(
            string $scriptKey,
            string $scriptUrl,
            string $params = ''
    ): self;

    /**
     * Add new style to repository
     * @param string $styleKey Key of style
     * @param string $styleUrl Url of style
     * @return self
     */
    public function setStyle(string $styleKey, string $styleUrl): self;

    /**
     * Add new Asset collection
     * @param string $name Collection name
     * @param array $scriptHeaderKeys Array of header script keys
     * @param array $scriptFooterKeys Array of footer script keys
     * @param array $styleKeys Array of styles keys
     * @return self
     */
    public function setCollection(
            string $name,
            array $scriptHeaderKeys = [],
            array $scriptFooterKeys = [],
            array $styleKeys = []
    ): self;

    /**
     * Get collection of assets
     * @param string $name
     * @return array
     */
    public function getCollection(string $name): array;

    /**
     * Get scripts URl by key
     * @param string $scriptKey
     * @return string
     */
    public function getScriptUrl(string $scriptKey): string;

    /**
     * Get style URL by key
     * @param string $styleKey
     * @return string
     */
    public function getStyleUrl(string $styleKey): string;

    /**
     * Reset state
     * @return self
     */
    public function reset(): self;
}
