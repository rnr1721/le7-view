<?php

declare(strict_types=1);

namespace App\View\Interfaces;

interface ViewAdapter
{

    public function getView(): View;
}
