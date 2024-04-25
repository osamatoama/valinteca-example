<?php

namespace App\Services\Yuque;

interface YuqueClientInterface
{
    public function postHttpRequest(string $url, array $body = []): mixed;
}
