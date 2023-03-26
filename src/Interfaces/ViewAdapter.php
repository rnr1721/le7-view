<?php

declare(strict_types=1);

namespace Core\Interfaces;

interface ViewAdapter
{

    /**
     * Get View element ready for use
     * @return View
     */
    public function getView(): View;
}
