<?php

declare(strict_types = 1);

namespace Free2er\Controller;

use Carbon\Carbon;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Контроллер проверки работоспособности
 */
class PingController
{
    /**
     * Обрабатывает запрос
     *
     * @return Response
     */
    public function __invoke(): Response
    {
        return new JsonResponse(['pong' => Carbon::now()->toRfc3339String()]);
    }
}
