<?php

declare(strict_types=1);

namespace App\View\Interfaces;

interface ViewAdapter
{

    /**
     * Get View element ready for use
     * @return View
     */
    public function getView(): View;
}
