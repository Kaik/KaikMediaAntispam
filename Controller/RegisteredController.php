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

namespace Kaikmedia\AntispamModule\Controller;

// use Kaikmedia\AntispamModule\Form\Type\SettingsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Zikula\Core\Controller\AbstractController;
use Zikula\ThemeModule\Engine\Annotation\Theme;

/**
 * Class RegisteredController
 * @Route("")
 */
class RegisteredController extends AbstractController
{
    /**
     * @Route("/registered", methods = {"GET", "POST"}, options={"zkNoBundlePrefix"=1})
     *
     * fake registered controller so bots do not know wtf
     *
     * @return RedirectResponse
     */
    public function registeredAction()
    {
        // access throw component instance user
        // $this->get('kaikmedia_antispam_module.access_manager')->hasPermission(ACCESS_ADMIN, true);
        $happy_text = 'Thank you come again!';
    
        return $this->render('@KaikmediaAntispamModule/Registered/index.html.twig', [
            'happy_text' => $happy_text
        ]);
    }
}
