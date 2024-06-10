<?php

namespace Flute\Modules\Rules\src\Http\Controllers\View;

use Flute\Core\Admin\Http\Middlewares\HasPermissionMiddleware;
use Flute\Core\Admin\Services\PageGenerator\AdminFormPage;
use Flute\Core\Admin\Services\PageGenerator\AdminInput;
use Flute\Core\Admin\Services\PageGenerator\AdminTablePage;
use Flute\Core\Support\AbstractController;
use Flute\Core\Support\FluteRequest;
use Flute\Modules\Rules\database\Entities\RulesItem;
use Flute\Modules\Rules\src\Services\RulesService;

class RulesView extends AbstractController
{
    protected RulesService $rulesService;

    public function __construct(RulesService $rulesService)
    {
        HasPermissionMiddleware::permission(['admin', 'admin.rules']);
        $this->middleware(HasPermissionMiddleware::class);

        $this->rulesService = $rulesService;
    }

    public function list(FluteRequest $request)
    {
        $table = table();

        $table->setPhrases([
            'question' => __('rules.admin.question')
        ]);

        $table->fromEntity(rep(RulesItem::class)->findAll(), ['blocks'])->withActions('rules');

        $pageGenerator = new AdminTablePage();
        $pageContent = $pageGenerator
            ->setTitle('rules.admin.header')
            ->setHeader('rules.admin.header')
            ->setDescription('rules.admin.description')
            ->setContent($table->render())
            ->setWithAddBtn(true)
            ->setBtnAddPath('/admin/rules/add');

        return $pageContent->generatePage();
    }

    public function add(FluteRequest $request)
    {
        $question = new AdminInput('question', 'rules.admin.question', 'rules.admin.question_desc', 'text', true);
        $editor = new AdminInput('editor', 'rules.admin.content', '', 'editorjs');

        $formPage = new AdminFormPage(
            'rules.admin.add_title',
            'rules.admin.add_desc',
            '/admin/rules/list',
            'add',
            'rules'
        );

        $formPage->addInput($question);
        $formPage->addInput($editor);

        return $formPage->render();
    }

    public function edit(FluteRequest $request, $id)
    {
        try {
            $rules = $this->rulesService->find((int) $id);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 404);
        }

        $id = new AdminInput('id', '', '', 'hidden', true, $rules->id, true);
        $question = new AdminInput('question', 'rules.admin.question', 'rules.admin.question_desc', 'text', true, $rules->question);
        $editor = new AdminInput('editor', 'rules.admin.content', '', 'editorjs', true, $rules->blocks->json);

        $formPage = new AdminFormPage(
            'rules.admin.edit_title',
            'rules.admin.edit_desc',
            '/admin/rules/list',
            'edit',
            'rules'
        );

        $formPage->addInput($id);
        $formPage->addInput($question);
        $formPage->addInput($editor);

        return $formPage->render();
    }
}