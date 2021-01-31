<?php
declare(strict_types=1);

namespace Mty95\Core\Base\Admin\Api;

interface ExtensionInterface
{
    public function install(): void;

    public function uninstall(): void;
}