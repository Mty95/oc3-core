<?php
declare(strict_types=1);

namespace Mty95\Core\Base;

use Controller;
use Mty95\Core\Http\Page\PageInterface;

/**
 * Class BaseController
 * @package Mty95\Core\Base
 */
abstract class BaseController extends Controller
{
    public function __construct($registry)
    {
        parent::__construct($registry);

        $this->_init();
    }

    public abstract function _init(): void;

    /**
     * @param string $path
     */
    public function loadLang(string $path): void
    {
        $this->load->language($path);
    }

    /**
     * @param string $file
     * @param array $data
     * @return mixed|bool|string
     * @deprecated
     */
    public function render(string $file, array $data = [])
    {
        $this->response->setOutput($this->renderView($file, $data));

        return true;
    }

    /**
     * @param string $file
     * @param array $data
     * @return string
     * @deprecated
     */
    public function renderView(string $file, array $data = []): string
    {
        return $this->load->view($file, $data);
    }

    protected function renderPage(PageInterface $page)
    {
        return $this->getContainer()->getExtension()->renderPage($page);
    }

    protected function renderCatalogPage(PageInterface $page)
    {
        return $this->getContainer()->getExtension()->renderCatalogPage($page);
    }

    protected function storeSettingsFromForm()
    {
        $extension = $this->getContainer()->getExtension();

        foreach ($this->request->post as $key => $value) {
            $extension->storeSetting($key, $value);
        }

        $this->session->data['success'] = $this->language->get('text_success');
    }
}
