<?php
declare(strict_types=1);

namespace Mty95\Core\Base\Api;

interface ExtensionContainerInterface
{
    public function getContainer(): ContainerInterface;
}