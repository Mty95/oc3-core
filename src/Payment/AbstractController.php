<?php
declare(strict_types=1);

namespace Mty95\Core\Payment;

use Exception;
use Registry;

abstract class AbstractController extends \Mty95\Core\Base\AbstractController implements \Mty95\Core\Base\Api\ControllerInterface
{
    /**
     * AbstractController constructor.
     * @param Registry $registry
     * @throws Exception
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry);
    }
}
