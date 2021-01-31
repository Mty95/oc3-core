<?php
declare(strict_types=1);

namespace Mty95\Core\Helper;

use Mty95\Core\Base\Api\ContainerInterface;

interface ExtensionInterface
{
    public function getSettingValue(string $key = '');

    public function getSettingValues(array $keys = []): array;

    public function getContainer(): ContainerInterface;

    public function _init(): void;

    /**
     * @return false|string
     */
    public function readLogFileContents();

    public function getLogFileLocation(): string;

    public function getImageUploadedPath(string $key): array;
}