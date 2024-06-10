<?php

namespace Flute\Modules\Rules\src\Widgets;

use Flute\Core\Widgets\AbstractWidget;
use Flute\Modules\Rules\database\Entities\RulesItem;
use Flute\Modules\Rules\src\Services\RulesService;

class RulesWidget extends AbstractWidget
{
    public function __construct()
    {
        $this->setAssets([
            mm('Rules', 'Resources/assets/styles/rules.scss'),
            mm('Rules', 'Resources/assets/js/rules.js'),
        ]);
    }

    public function render(array $data = []): string
    {
        return render(mm('Rules', 'Resources/views/rules'), [
            'rules' => $this->getRules(),
            'service' => app(RulesService::class)
        ]);
    }

    public function getName(): string
    {
        return 'Rules widget';
    }

    public function isLazyLoad(): bool
    {
        return false;
    }

    protected function getRules()
    {
        return rep(RulesItem::class)->select()->load('blocks')->orderBy('id', 'ASC')->fetchAll();
    }
}