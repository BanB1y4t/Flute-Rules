<?php

namespace Flute\Modules\Rules\src\Services;

use Flute\Core\Page\PageEditorParser;
use Flute\Modules\Rules\database\Entities\RulesItem;
use Flute\Modules\Rules\database\Entities\RulesItemBlock;
use Nette\Utils\Json;

class RulesService
{
    public function find($id)
    {
        $rulesItem = rep(RulesItem::class)
            ->select()
            ->load('blocks')
            ->where(['id' => $id])
            ->fetchOne();

        if (!$rulesItem) {
            throw new \Exception(__('rules.not_found'));
        }

        return $rulesItem;
    }

    public function parseBlocks(RulesItem $rulesItem)
    {
        /** @var PageEditorParser $parser */
        $parser = app(PageEditorParser::class);

        $blocks = Json::decode($rulesItem->blocks->json ?? '[]', Json::FORCE_ARRAY);

        return $parser->parse($blocks);
    }

    public function store(string $question, $json)
    {
        $rulesItem = new RulesItem();

        $rulesItem->question = $question;

        $block = new RulesItemBlock();
        $block->json = $json;
        $block->rulesItem = $rulesItem;

        $rulesItem->blocks = $block;

        transaction($rulesItem)->run();
    }

    public function update(int $id, string $question, $json)
    {
        $rulesItem = $this->find($id);

        $rulesItem->question = $question;

        $block = new RulesItemBlock();
        $block->json = $json;
        $block->rulesItem = $rulesItem;

        $rulesItem->blocks = $block;

        transaction($rulesItem)->run();
    }

    public function delete(int $id): void
    {
        $rulesItem = $this->find($id);

        transaction($rulesItem, 'delete')->run();
    }
}
