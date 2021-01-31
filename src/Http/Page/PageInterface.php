<?php
declare(strict_types=1);

namespace Mty95\Core\Http\Page;

use Mty95\Core\Api\SettingsInterface;

interface PageInterface
{
    public function getView(): string;

    public function getData(): array;

    public function getLangFiles(): array;

    public function beforeRender(): void;

    public function loadSessionMessages(): void;

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function pushData($key, $value): void;

    public function getModulePath(): string;

    public function setSettings(SettingsInterface $settings): void;
}