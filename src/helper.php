<?php

use Pharaonic\Laravel\Menus\Models\Menu;

if (!function_exists('menu')) {
    function menu(string $section, $view = true)
    {
        $section = Menu::section(trim($section, '\'"'))->get();

        if ($section->isEmpty()) return;
        if (!$view) return $section;

        return view($view === true ? 'laravel-menus::section' : $view, ['section' => $section]);
    }
}
