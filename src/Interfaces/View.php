<?php

declare(strict_types=1);

namespace App\View\Interfaces;

interface View
{

    /**
     * Render the template
     * Return string data that you can add to cache or display
     * @param string $layout Filename in theme folder
     * @param array $vars Template data
     * @return string
     */
    public function render(string $layout, array $vars = array()): string;
}
