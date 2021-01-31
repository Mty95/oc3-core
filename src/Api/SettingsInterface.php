<?php
declare(strict_types=1);

namespace Mty95\Core\Api;

interface SettingsInterface
{
    public function getCode(): string;

    public function getModuleType(): string;

    public function getModuleNameLower(): string;

    public function getLoggerLevel(): int;

    public function getConfigurationFields(): array;

    public function getLogFileName(): string;

    public function getModulePath(): string;
}