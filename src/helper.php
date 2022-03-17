<?php

use Pharaonic\Laravel\Menus\Models\Menu;

if (!function_exists('menu')) {
    function menu(string $section, bool $view = false)
    {
        $section = Menu::section(trim($section, '\'"'))->get();

        if ($section->isEmpty()) return;
        if (!$view) return $section;

        return view('laravel-menus::section', ['section' => $section]);
    }
}
