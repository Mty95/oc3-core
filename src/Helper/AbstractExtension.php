<?php
declare(strict_types=1);

namespace Mty95\Core\Helper;

use Mty95\Core\Base\Api\ContainerInterface;
use Mty95\Core\Base\LanguageLoader;
use Mty95\Core\Base\Traits\RegistryAccessorTrait;
use Mty95\Core\Http\Page\Helper\PageRendererHelper;
use Mty95\Core\Http\Page\PageInterface;
use Registry;

abstract class AbstractExtension implements ExtensionInterface
{
    use RegistryAccessorTrait;

    /**
     * @var PageRendererHelper
     */
    private $pageRendererHelper;
    /**
     * @var ContainerInterface|null
     */
    private $container = null;
    /**
     * @var Registry|null
     */
    private $registry = null;

    public function __construct(
        PageRendererHelper $pageRendererHelper,
        ContainerInterface $container
    )
    {
        $this->pageRendererHelper = $pageRendererHelper;
        $this->container = $container;
        $this->registry = $container->getRegistry();
    }

    public function _init(): void
    {
        $this->load->model('setting/setting');

        $page = $this->container->getPage();
        (new LanguageLoader($this->registry))->load($page->getModulePath());
    }

    /**
     * @param PageInterface $page
     * @return mixed|bool|string
     */
    public function renderPage(PageInterface $page)
    {
        return $this->pageRendererHelper->render($page);
    }

    /**
     * @param PageInterface $page
     * @return mixed|bool|string
     */
    public function renderCatalogPage(PageInterface $page)
    {
        return $this->pageRendererHelper->renderCatalogPage($page);
    }

    public function getSettingValues(array $keys = []): array
    {
        return array_map(function ($key) {
            return [$key => $this->getSettingValue($key)];
        }, $keys);
    }

    public function getSettingValue(string $key = '')
    {
        return $this->model_setting_setting->getSettingValue(
            "{$this->getContainer()->getSettings()->getCode()}_{$key}"
        );
    }
    private function hasSettingValue($key): bool
    {
        return null !== $this->model_setting_setting->getSettingValue("{$key}");
    }

    public function storeSetting($key, $value)
    {
        $code = $this->getContainer()->getSettings()->getCode();

        if (!(strpos($key, $code) !== false))
        {
            $key = "{$code}_{$key}";
        }

        if ($this->hasSettingValue($key)) {
            $this->model_setting_setting->editSettingValue($code, $key, $value);
        } else {
            $this->insertSettingValue($key, $value);
        }
    }

    /**
     * @param $key
     * @param $value
     * @param int $store_id
     */
    private function insertSettingValue($key, $value, $store_id = 0): void
    {
        $code = $this->getContainer()->getSettings()->getCode();

        if (!is_array($value)) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
            return;
        }

        $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(json_encode($value, true)) . "', serialized = '1'");
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @return false|string
     */
    public function readLogFileContents()
    {
        $file = $this->getLogFileLocation();

        if (!file_exists($file)) {
            return '';
        }

        return file_get_contents(
            $file,
            true,
            null
        );
    }

    public function getLogFileLocation(): string
    {
        return DIR_LOGS . $this->getContainer()->getSettings()->getLogFileName();
    }

    public function getImageUploadedPath(string $key): array
    {
        $placeholder = $this->getSettingValue($key);
        $thumb = $this->model_tool_image->resize($placeholder, 120, 40);

        if ($thumb === '') {
            $thumb = $this->model_tool_image->resize('no_image.png', 120, 40);
            $placeholder = $this->model_tool_image->resize('no_image.png', 120, 40);
        }

        return [
            $key . '_thumb' => $thumb,
            $key . '_placeholder' => $placeholder,
        ];
    }

    public function install(): void
    {
        $this->beforeInstall();

        $this->installSettings();

        $this->afterInstall();
    }

    protected function beforeInstall(): void
    {

    }

    protected function installSettings(): void
    {
        $this->cleanDefaultConfigData();
    }

    private function cleanDefaultConfigData(): void
    {
        $tmp = [];
        $configurationFields = $this->getContainer()->getSettings()->getConfigurationFields();
        $code = $this->getContainer()->getSettings()->getCode();

        if (empty($configurationFields) || null === $code)
            return;

        foreach ($configurationFields as $key => $value)
            $tmp["{$code}_{$key}"] = $value;

        $this->model_setting_setting->editSetting($code, $tmp);
    }

    protected function afterInstall(): void
    {

    }

    public function uninstall(): void
    {
        $this->beforeUninstall();

        $this->uninstallSettings();
        $this->model_setting_setting->deleteSetting($this->getContainer()->getSettings()->getCode());

        $this->afterUninstall();
    }

    protected function beforeUninstall(): void
    {

    }

    protected function uninstallSettings(): void
    {
        $this->cleanDefaultConfigData();
    }

    protected function afterUninstall(): void
    {

    }

    public function getBaseUrl(string $uri = ''): string
    {
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            return $this->config->get('config_ssl') . $uri;
        }

        return $this->config->get('config_url') . $uri;
    }
}