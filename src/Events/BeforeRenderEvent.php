<?php

namespace Core\Events;

use Psr\EventDispatcher\StoppableEventInterface;

class BeforeRenderEvent implements StoppableEventInterface
{

    private bool $propagationStopped = false;
    private string $layout;
    private int $responseCode = 0;
    private array $vars;
    private array $headers;

    public function __construct(
            string $layout,
            array $vars,
            int $responseCode,
            array $headers
    )
    {
        $this->layout = $layout;
        $this->responseCode = $responseCode;
        $this->vars = $vars;
        $this->headers = $headers;
    }

    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }

    public function stopPropagation(): void
    {
        $this->propagationStopped = true;
    }

    public function getLayout(): string
    {
        return $this->layout;
    }

    public function getVars(): array
    {
        return $this->vars;
    }

    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

}
