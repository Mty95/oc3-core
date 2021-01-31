<?php
declare(strict_types=1);

namespace Mty95\Core\Base;

use Config;
use Language;
use Registry;

/**
 * Class LanguageLoader
 * @package Mty95\Core\Base
 */
final class LanguageLoader
{
    /**
     * @var Config|null
     */
    private $config;
    /**
     * @var Language|null
     */
    private $language;

    public function __construct(Registry $registry)
    {
        $this->config = $registry->get('config');
        $this->language = $registry->get('language');
    }

    public function load(string $getModulePath): void
    {
        $filePath = $getModulePath . $this->config->get('language_directory') . '.csv';

        if (is_file($filePath)) {
            $data = array_map('str_getcsv', file($filePath));

            foreach ($data as $datum) {
                $this->language->set($datum[0], $datum[1]);
            }
        }
    }
}
