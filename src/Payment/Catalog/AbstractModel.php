<?php
declare(strict_types=1);

namespace Mty95\Core\Payment\Catalog;

use Model;
use Mty95\Core\Base\Api\ExtensionContainerInterface;

abstract class AbstractModel extends Model implements ExtensionContainerInterface
{
    abstract public function isAvailable(?array $address, $total): bool;

    abstract public function getMethod(?array $address, $total): array;
}