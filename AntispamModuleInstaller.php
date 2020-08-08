<?php

/**
 * KaikMedia AntispamModule
 *
 * @package    KaikmediaAntispamModule
 * @author     Kaik <contact@kaikmedia.com>
 * @copyright  KaikMedia
 * @link       https://github.com/Kaik/KaikMediaAntispam.git
 */

namespace Kaikmedia\AntispamModule;

use Zikula\Core\AbstractExtensionInstaller;

class AntispamModuleInstaller extends AbstractExtensionInstaller
{
    public function install()
    {
        return true;
    }

    public function upgrade($oldversion)
    {
        return true;
    }

    public function uninstall()
    {
        return true;
    }
}
