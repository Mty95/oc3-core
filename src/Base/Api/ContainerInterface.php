<?php
declare(strict_types=1);

namespace Mty95\Core\Base\Api;

use Mty95\Core\Api\SettingsInterface;
use Mty95\Core\Base\AbstractContainer;
use Mty95\Core\Helper\ExtensionInterface;
use Mty95\Core\Http\Page\PageInterface;
use Psr\Log\LoggerInterface;
use Registry;

interface ContainerInterface
{
    public static function getInstance(Registry $registry): ?AbstractContainer;

    public function getSettings(): ?SettingsInterface;

    public function getPage(): ?PageInterface;

    public function getRegistry(): ?Registry;

    public function getExtension(): ?ExtensionInterface;

    public function getLogger(): ?LoggerInterface;
}