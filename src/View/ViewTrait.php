<?php

namespace Core\View;

use Psr\Http\Message\ServerRequestInterface;
use \Exception;
use function array_key_exists,
             is_array,
             is_object,
             md5;

class ViewTrait
{

    protected array $vars = [];

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

    /**
     * Try to add to cache
     * @param ServerRequestInterface $request Server Request
     * @param string $rendered Html content
     * @param int|null $cacheTimeSec Cache time, 0 or null or int
     * @return bool If success
     */
    protected function tryAddToCache(ServerRequestInterface $request, string $rendered, int $code, int|null $cacheTimeSec = null): bool
    {
        if ($code !== 200) {
            throw new Exception("You can only cache pages with a 200 server response code");
        }
        if ($cacheTimeSec !== null && !empty($this->cache)) {
            $currentUri = $request->getUri();
            $cacheName = 'page_' . md5((string) $currentUri);
            if ($cacheTimeSec === 0) {
                $this->cache->set($cacheName, $rendered);
            } else {
                $this->cache->set($cacheName, $rendered, $cacheTimeSec);
            }
            return true;
        }
        return false;
    }

}
