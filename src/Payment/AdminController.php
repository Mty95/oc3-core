<?php
declare(strict_types=1);

namespace Mty95\Core\Payment;

use Mty95\Core\Base\Admin\Api\ExtensionInterface;
use Mty95\Core\Base\Admin\Traits\UrlTrait;
use Registry;

abstract class AdminController extends AbstractController implements ExtensionInterface
{
    use UrlTrait;

    public function __construct(Registry $registry)
    {
        parent::__construct($registry);
    }

    public function install(): void
    {
        $this->getContainer()->getExtension()->install();
    }

    public function uninstall(): void
    {
        $this->getContainer()->getExtension()->uninstall();
    }

    protected function redirect(string $url)
    {
        $this->response->redirect(
            $this->buildUrl($url, [], true)
        );
    }

    /**
     * Clear the log file contents from Admin Configuration page.
     */
    public function clear()
    {
        $extension = $this->getContainer()->getExtension();
        $handle = fopen($extension->getLogFileLocation(), 'w+');

        fclose($handle);

        $this->session->data['success'] = $this->language->get('text_success');

        $this->redirect('extension/payment/' . $this->getContainer()->getSettings()->getModuleNameLower());
    }
}
