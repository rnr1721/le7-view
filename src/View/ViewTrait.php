<?php

declare(strict_types=1);

namespace Core\View;

use Psr\SimpleCache\CacheInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use \Exception;
use function array_key_exists,
             is_array,
             is_object,
             md5;

trait ViewTrait
{

    protected ResponseInterface $response;
    protected ServerRequestInterface $request;
    protected CacheInterface $cache;
    protected array $vars = [];

    public function clear(): void
    {
        $this->vars = [];
    }

    /**
     * Assign variable to template
     * @param array|string|object $key Key as string or array $key=>$value
     * @param mixed $value Value of assigned element
     * @param bool $check Check if var defined in page variables
     * @return self
     * @throws Exception
     */
    public function assign(array|string|object $key, mixed $value = null, bool $check = true): self
    {
        if (is_array($key) || is_object($key)) {
            foreach ($key as $k => $v) {
                if ($check && array_key_exists($k, $this->vars)) {
                    throw new Exception(_('This variable can not be used in this place:') . ' ' . $k);
                }
                $this->vars[$k] = $v;
            }
        } else {
            if ($check && array_key_exists($key, $this->vars)) {
                throw new Exception('This variable can not be used in this place:' . ' ' . $key);
            }
            $this->vars[$key] = $value;
        }
        return $this;
    }

    public function renderFromCache(?ResponseInterface $response = null): ResponseInterface|null
    {
        if ($response) {
            $this->response = $response;
        } else {
            $response = $this->response;
        }
        $result = $this->fetchFromCache();
        if ($result) {
            $response->getBody()->write($result);
            return $response->withStatus(200)
                            ->withHeader('Content-Type', 'text/html');
        }
        return null;
    }

    public function fetchFromCache(): string|null
    {
        $cacheName = $this->getCacheName();
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        }
        return null;
    }

    /**
     * Try to add to cache
     * @param string $rendered Html content
     * @param int|null $cacheTimeSec Cache time, 0 or null or int
     * @return bool If success
     */
    protected function tryAddToCache(string $rendered, int $code, int|null $cacheTimeSec = null): bool
    {
        if ($cacheTimeSec !== null && !empty($this->cache) && $code === 200) {
            $cacheName = $this->getCacheName();
            if ($cacheTimeSec === 0) {
                $this->cache->set($cacheName, $rendered);
            } else {
                $this->cache->set($cacheName, $rendered, $cacheTimeSec);
            }
            return true;
        }
        return false;
    }

    private function getCacheName()
    {
        return 'page_' . md5((string) $this->request->getUri());
    }

    public function render(string $layout, array $vars = [], int $code = 200, array $headers = [], ?int $cacheTTL = null): ResponseInterface
    {

        $rendered = $this->fetch($layout, $vars);

        // if cache
        $this->tryAddToCache($rendered, $code, $cacheTTL);

        foreach ($headers as $headerKey => $headerValue) {
            $this->response = $this->response->withHeader($headerKey, $headerValue);
        }

        if (!$this->response->hasHeader('Content-Type')) {
            $this->response = $this->response->withHeader('Content-Type', 'text/html');
        }

        $this->response->getBody()->write($rendered);

        return $this->response->withStatus($code);
    }

    public function updateResponse(ResponseInterface $response): self
    {
        $this->response = $response;
        return $this;
    }

}
