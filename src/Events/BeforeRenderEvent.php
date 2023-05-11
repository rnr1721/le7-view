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

    public function setLayout(string $layout): self
    {
        $this->layout = $layout;
        return $this;
    }

    public function setVars(array $vars): self
    {
        $this->vars = $vars;
        return $this;
    }

    public function setVar(string $key, mixed $value): self
    {
        $this->vars[$key] = $value;
        return $this;
    }

    public function setResponse(int $responseCode): self
    {
        $this->responseCode = $responseCode;
        return $this;
    }

    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }

    public function setHeader(string $headerKey, string $headerValue): self
    {
        $this->headers[$headerKey] = $headerValue;
        return $this;
    }

}
