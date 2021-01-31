<?php
declare(strict_types=1);

namespace Mty95\Core\Base\Admin\Traits;

use Loader;
use Session;
use Url;

/**
 * Trait UrlTrait
 * @package Mty95\Core\Base\Admin\Traits
 *
 * @property Session $session
 * @property Url $url
 * @property Loader $load
 */
trait UrlTrait
{
    public function buildUrl(string $path, array $args = [], bool $secure = true): string
    {
        $args = array_merge($args, ['user_token' => $this->getUserToken()]);

        return $this->url->link($path, $args, $secure);
    }

    public function getUserToken(): string
    {
        return $this->session->data['user_token'];
    }
}
