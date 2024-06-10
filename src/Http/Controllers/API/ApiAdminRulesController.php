<?php

namespace Flute\Modules\Rules\src\Http\Controllers\API;

use Flute\Core\Admin\Http\Middlewares\HasPermissionMiddleware;
use Flute\Core\Support\AbstractController;
use Flute\Core\Support\FluteRequest;
use Flute\Modules\Rules\src\Services\RulesService;
use Symfony\Component\HttpFoundation\Response;

class ApiAdminRulesController extends AbstractController
{
    protected $RulesService;

    public function __construct(RulesService $rulesService)
    {
        $this->rulesService = $rulesService;

        HasPermissionMiddleware::permission(['admin', 'admin.rules']);
    }

    public function store(FluteRequest $request): Response
    {
        try {
            $this->rulesService->store(
                $request->question,
                $request->input('blocks', '[]')
            );

            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function delete(FluteRequest $request, $id): Response
    {
        try {
            $this->rulesService->delete((int) $id);

            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(FluteRequest $request, $id): Response
    {
        try {
            $this->rulesService->update(
                (int) $id,
                $request->question,
                $request->input('blocks', '[]')
            );

            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
