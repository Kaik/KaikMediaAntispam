<?php

/**
 * KaikMedia AntispamModule
 *
 * @package    KaikmediaAntispamModule
 * @author     Kaik <contact@kaikmedia.com>
 * @copyright  KaikMedia
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @link       https://github.com/Kaik/KaikMediaAntispam.git
 */

namespace Kaikmedia\AntispamModule\Listener;

use Kaikmedia\AntispamModule\Exception\RedirectBotException;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class RedirectBotExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if ($event->getException() instanceof RedirectBotException) {
            $event->setResponse($event->getException()->getRedirectResponse());
        }
    }
}