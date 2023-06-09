<?php

declare(strict_types=1);

namespace Core\Interfaces;

use Psr\Http\Message\ResponseInterface;

/**
 * Main view interface
 */
interface ViewInterface
{

    /**
     * Get ResponseInterface from cache
     * @param ResponseInterface|null Response
     * @return ResponseInterface|null
     */
    public function renderFromCache(?ResponseInterface $response = null): ResponseInterface|null;

    /**
     * Get string from cache
     * @return string|null
     */
    public function fetchFromCache(): string|null;

    /**
     * Clear all assigned vars
     */
    public function clear(): void;

    /**
     * Assign variable to template
     * @param array|string|object $key Key as string or array $key=>$value
     * @param mixed $value Value of assigned element
     * @param bool $check Check if var defined in page variables
     * @return self
     */
    public function assign(array|string|object $key, mixed $value = null, bool $check = true): self;

    /**
     * Render the template
     * Return string data that you can add to cache or display
     * @param string $layout Filename in theme folder
     * @param array<array-key,string> $vars Template data
     * @param int $code Response code
     * @param array<array-key, string> $headers Response headers
     * @param int|null $cacheTTL Cache TTL in seconds or null
     * @return ResponseInterface
     */
    public function render(string $layout, array $vars = array(), int $code = 200, array $headers = [], ?int $cacheTTL = null): ResponseInterface;

    /**
     * Fetch template data as string
     * Return string data that you can add to cache or display
     * @param string $layout Filename in theme folder
     * @param array<array-key, string> $vars Template data
     * @return string
     */
    public function fetch(string $layout, array $vars = array()): string;
    
    /**
     * Update the response inside current View
     * @param ResponseInterface $response New Response
     * @return self
     */
    public function updateResponse(ResponseInterface $response):self;
}
