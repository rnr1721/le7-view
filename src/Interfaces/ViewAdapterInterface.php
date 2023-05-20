<?php

declare(strict_types=1);

namespace Core\Interfaces;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface for factory that give us ready-to-config ViewInterface
 */
interface ViewAdapterInterface
{

    /**
     * Get View element ready for use
     * @param array|string|null $templatePath Optional path to templates
     * @param ResponseInterface|null Optional PSR ResponseInterface
     * @return ViewInterface
     */
    public function getView(array|string|null $templatePath = null, ?ResponseInterface $response = null): ViewInterface;
}
