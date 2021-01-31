<?php
declare(strict_types=1);

namespace Mty95\Core\Http\Page;

use Language;
use Loader;
use Mty95\Core\Api\SettingsInterface;
use Mty95\Core\Base\Admin\Traits\UrlTrait;
use Registry;
use Session;
use Url;

abstract class AbstractPage implements PageInterface
{
    use UrlTrait;

    /**
     * @var Url|null
     */
    protected $url = null;
    /**
     * @var Session|mixed|null
     */
    protected $session = null;
    /**
     * @var Loader|mixed|null
     */
    protected $load = null;
    /**
     * @var array
     */
    protected $data = [];
    /**
     * @var Language|mixed|null
     */
    protected $language = null;
    /**
     * @var Registry
     */
    private $registry;
    /**
     * @var null|SettingsInterface
     */
    protected $settings = null;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
        $this->url = $registry->get('url');
        $this->session = $registry->get('session');
        $this->load = $registry->get('load');
        $this->language = $registry->get('language');
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function pushData($key, $value): void
    {
        $this->data = array_merge($this->data, [$key => $value]);
    }

    public function pushDataArray(array $data = []): void
    {
        array_walk($data, function ($datum) {
            $this->data = array_merge($this->data, $datum);
        });

    }

    public function getModulePath(): string
    {
        return $this->settings->getModulePath();
    }

    public function setSettings(SettingsInterface $settings): void
    {
        $this->settings = $settings;
    }

    /**
     * @return string
     */
    protected function getModuleCode(): string
    {
        return $this->settings->getCode();
    }

    public function loadSessionMessages(): void
    {
        $keys = [
            'success',
            'warning',
            'danger',
        ];

        foreach ($keys as $key) {
            if (isset($this->session->data[$key])) {
                $this->pushData($key, $this->session->data[$key]);
                unset($this->session->data[$key]);
            }
        }

    }
}