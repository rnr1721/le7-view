<?php

declare(strict_types=1);

namespace App\View\Interfaces;

interface View
{

    public function render(string $layout, array $vars = array()): string;
}
