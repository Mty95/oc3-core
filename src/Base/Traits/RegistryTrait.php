<?php
declare(strict_types=1);

namespace Mty95\Core\Base\Traits;

use Registry;

/**
 * @method _init(): void
 *
 * Trait RegistryTrait
 * @package Mty95\Core\Base\Traits
 */
trait RegistryTrait
{
    use RegistryAccessorTrait;

    /**
     * @var Registry
     */
    protected $registry;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }
}