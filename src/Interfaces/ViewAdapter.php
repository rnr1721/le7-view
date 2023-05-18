<?php

declare(strict_types=1);

namespace Core\Interfaces;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface for factory that give us ready-to-config View interface
 */
interface ViewAdapter
{

    /**
     * Get View element ready for use
     * @param array|string|null $templatePath Optional path to templates
     * @param ResponseInterface|null Optional PSR ResponseInterface
     * @return View
     */
    public function getView(array|string|null $templatePath = null, ?ResponseInterface $response = null): View;
}
