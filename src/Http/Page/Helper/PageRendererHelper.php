<?php
declare(strict_types=1);

namespace Mty95\Core\Http\Page\Helper;

use Mty95\Core\Base\Api\ContainerInterface;
use Mty95\Core\Base\Traits\RegistryAccessorTrait;
use Mty95\Core\Http\Page\PageInterface;
use Registry;

final class PageRendererHelper
{
    use RegistryAccessorTrait;

    /**
     * @var Registry
     */
    private $registry;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(Registry $registry, ContainerInterface $container)
    {
        $this->registry = $registry;
        $this->container = $container;
    }

    /**
     * @param PageInterface $page
     * @return mixed|bool|string
     */
    public function render(PageInterface $page)
    {
        $page->setSettings($this->container->getSettings());

        foreach ($page->getLangFiles() as $file) {
            $this->load->language($file);
        }

        $page->beforeRender();
        $page->loadSessionMessages();

        $this->response->setOutput($this->renderView($page->getView(), $page->getData()));

        return true;
    }

    /**
     * @param PageInterface $page
     * @return mixed|bool|string
     */
    public function renderCatalogPage(PageInterface $page)
    {
        $page->setSettings($this->container->getSettings());

        foreach ($page->getLangFiles() as $file) {
            $this->load->language($file);
        }

        $page->beforeRender();
        $page->loadSessionMessages();

        return $this->load->view($page->getView(), $page->getData());
    }

    /**
     * @param string $file
     * @param array $data
     * @return string
     */
    public function renderView(string $file, array $data = []): string
    {
        return $this->load->view($file, $data);
    }
}