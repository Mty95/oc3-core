<?php
declare(strict_types=1);

namespace Mty95\Core\Http;

final class Request
{
    /**
     * @var \Request
     */
    private $request;

    public function __construct(
        \Request $request
    )
    {
        $this->request = $request;
    }

    public function isPost(): bool
    {
        return $this->request->server['REQUEST_METHOD'] === 'POST';
    }

    public function isGet(): bool
    {
        return $this->request->server['REQUEST_METHOD'] === 'GET';
    }
}