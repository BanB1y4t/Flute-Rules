<?php

namespace Flute\Modules\Rules\src\ServiceProviders\Extensions;

use Flute\Core\Admin\Builders\AdminSidebarBuilder;

class AdminExtension implements \Flute\Core\Contracts\ModuleExtensionInterface
{
    public function register(): void
    {
        $this->addSidebar();
    }

    private function addSidebar(): void
    {
        AdminSidebarBuilder::add('additional', [
            'title' => 'rules.admin.header',
            'icon' => 'ph-question',
            'permission' => 'admin.rules',
            'url' => '/admin/rules/list'
        ]);
    }
}