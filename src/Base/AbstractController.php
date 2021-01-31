<?php
declare(strict_types=1);

namespace Mty95\Core\Base;

use Exception;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Mty95\Core\Http\Request;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractController
 * @package Mty95\Core\Base
 *
 * @property $extensionModel
 */
abstract class AbstractController extends BaseController implements \Mty95\Core\Base\Api\ControllerInterface
{
//    use RegistryTrait;

    /**
     * @var Request|null
     */
    protected $requestModel = null;
    /**
     * @var Logger|null
     */
    private $logger = null;

    /**
     * @throws Exception
     */
    public function _init(): void
    {
        /*$this->loadExtensionModel();*/
        $this->requestModel = new Request($this->request);
    }

    /**
     * @throws Exception
     */
    private function loadExtensionModel(): void
    {
        $settings = $this->getContainer()->getSettings();
        $this->load->model('setting/setting');

        $moduleRoute = sprintf(
            'extension/%s/%s',
            $settings->getModuleType(),
            $settings->getModuleNameLower()
        );
        $this->load->model($moduleRoute);
        $className = 'model_' . str_replace('/', '_', $moduleRoute);
        $this->extensionModel = $this->$className;

        $this->extensionModel->_init();
    }

    protected function getLogger(): ?LoggerInterface
    {
        return $this->getContainer()->getLogger();
    }
}