<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nasirkhan\ModuleManager\Modules\Menu\Models\Menu;
use Nasirkhan\ModuleManager\Modules\Menu\Models\MenuItem;

class RemoveDemoDropdownMenuSeeder extends Seeder
{
    /**
     * Remove the default package demo dropdown from the frontend header menu.
     */
    public function run(): void
    {
        $frontendHeaderMenuIds = Menu::query()
            ->where('location', 'frontend-header')
            ->pluck('id');

        if ($frontendHeaderMenuIds->isEmpty()) {
            return;
        }

        $demoDropdownIds = MenuItem::query()
            ->whereIn('menu_id', $frontendHeaderMenuIds)
            ->where('slug', 'dropdown')
            ->pluck('id');

        if ($demoDropdownIds->isEmpty()) {
            return;
        }

        MenuItem::query()
            ->whereIn('parent_id', $demoDropdownIds)
            ->delete();

        MenuItem::query()
            ->whereIn('id', $demoDropdownIds)
            ->delete();

        Menu::clearMenuCache('frontend-header');
    }
}
