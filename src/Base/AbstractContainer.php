<?php
declare(strict_types=1);

namespace Mty95\Core\Base;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Mty95\Core\Api\SettingsInterface;
use Mty95\Core\Base\Api\ContainerInterface;
use Mty95\Core\Helper\ExtensionInterface;
use Mty95\Core\Http\Page\Helper\PageRendererHelper;
use Mty95\Core\Http\Page\PageInterface;
use Psr\Log\LoggerInterface;
use Registry;

abstract class AbstractContainer implements ContainerInterface
{
    private static $instance = null;
    /**
     * @var SettingsInterface|null
     */
    protected $settings = null;
    /**
     * @var PageInterface|null
     */
    protected $page = null;
    /**
     * @var ExtensionInterface|null
     */
    protected $extension = null;
    /**
     * @var array
     */
    private $objects = [];
    /**
     * @var Registry|null
     */
    private $registry = null;
    /**
     * @var PageRendererHelper|null
     */
    private $pageRendererHelper = null;
    /**
     * @var LoggerInterface|null
     */
    private $logger = null;

    protected function __construct(Registry $registry)
    {
        $this->registry = $registry;
        $this->pageRendererHelper = new PageRendererHelper($this->registry, $this);

        $this->_construct($registry, $this->pageRendererHelper);
    }

    /**
     * @param Registry $registry
     * @return static|null
     */
    public static function getInstance(Registry $registry): ?AbstractContainer
    {
        if (null === self::$instance) {
            self::$instance = new static($registry);
        }

        return self::$instance;
    }

    /**
     * @return SettingsInterface|null
     */
    public function getSettings(): ?SettingsInterface
    {
        return $this->settings;
    }

    /**
     * @return PageInterface|null
     */
    public function getPage(): ?PageInterface
    {
        return $this->page;
    }

    /**
     * @return Registry|null
     */
    public function getRegistry(): ?Registry
    {
        return $this->registry;
    }

    /**
     * @return ExtensionInterface|null
     */
    public function getExtension(): ?ExtensionInterface
    {
        return $this->extension;
    }

    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    protected function _init(
        SettingsInterface $settings,
        PageInterface $page,
        ExtensionInterface $extension
    )
    {
        $this->settings = $settings;
        $this->page = $page;
        $this->extension = $extension;
        $this->logger = $this->createLoggerObject();

        $page->setSettings($this->settings);

        $this->extension->_init();
    }

    private function createLoggerObject(): LoggerInterface
    {
        $dateFormat = "Y-m-d | H:i:s";
        $output = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";
        $formatter = new LineFormatter($output, $dateFormat);

        $stream = new StreamHandler(
            DIR_LOGS . $this->getSettings()->getLogFileName(),
            $this->getSettings()->getLoggerLevel()
        );
        $stream->setFormatter($formatter);

        $logger = new Logger('logs');
        $logger->pushHandler($stream);

        return $logger;
    }
}