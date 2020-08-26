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

use Kaikmedia\AntispamModule\Form\Type\PreferencesType;
use Kaikmedia\AntispamModule\Form\Type\AdminBannedType;
use Kaikmedia\AntispamModule\Form\Type\AdminQuestionType;
use Kaikmedia\AntispamModule\Form\Type\AdminCaptchaType;
use Kaikmedia\AntispamModule\Form\Type\AdminReCaptchaType;
use Kaikmedia\AntispamModule\Form\Type\AdminHoneypotType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Zikula\Core\Controller\AbstractController;
use Zikula\ThemeModule\Engine\Annotation\Theme;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/index")
     *
     * @Theme("admin")
     *
     * the main administration function
     *
     * @return RedirectResponse
     */
    public function indexAction()
    {
        // access throw component instance user
        $this->get('kaikmedia_antispam_module.access_manager')->hasPermission(ACCESS_ADMIN, true);

        return $this->render('@KaikmediaAntispamModule/Admin/index.html.twig', [

        ]);
    }

    /**
     * @Route("/banned")
     *
     * @Theme("admin")
     *
     * the main administration function
     *
     * @return RedirectResponse
     */
    public function bannedAction(Request $request)
    {
        // access throw component instance user
        $this->get('kaikmedia_antispam_module.access_manager')->hasPermission(ACCESS_ADMIN, true);

        $settings = $this->getVars();
        $formBuilder = $this->get('form.factory')
            ->createBuilder(AdminBannedType::class, $settings)
            // ->setMethod('POST')
        ;
        $formBuilder
            ->add('save', SubmitType::class)
        ;
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            foreach ($data as $key => $value) {
                $this->setVar($key, $value);
            }
            $request->getSession()
                ->getFlashBag()
                ->add('status', $this->__('Setting changes.'));

            $this->redirect($this->generateUrl('kaikmediaantispammodule_admin_banned'));    
        }

        return $this->render('@KaikmediaAntispamModule/Banned/admin.form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/question")
     *
     * @Theme("admin")
     *
     * the main administration function
     *
     * @return RedirectResponse
     */
    public function questionAction(Request $request)
    {
        // access throw component instance user
        $this->get('kaikmedia_antispam_module.access_manager')->hasPermission(ACCESS_ADMIN, true);

        $settings = $this->getVars();
        $formBuilder = $this->get('form.factory')
            ->createBuilder(AdminQuestionType::class, $settings)
            // ->setMethod('POST')
        ;
        $formBuilder
            ->add('save', SubmitType::class)
        ;
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            foreach ($data as $key => $value) {
                $this->setVar($key, $value);
            }
            $request->getSession()
                ->getFlashBag()
                ->add('status', $this->__('Setting changes.'));

            $this->redirect($this->generateUrl('kaikmediaantispammodule_admin_question'));    
        }

        return $this->render('@KaikmediaAntispamModule/Question/admin.form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/captcha")
     *
     * @Theme("admin")
     *
     * the main administration function
     *
     * @return RedirectResponse
     */
    public function captchaAction(Request $request)
    {
        // access throw component instance user
        $this->get('kaikmedia_antispam_module.access_manager')->hasPermission(ACCESS_ADMIN, true);

        $settings = $this->getVars();
        $formBuilder = $this->get('form.factory')
            ->createBuilder(AdminCaptchaType::class, $settings)
            // ->setMethod('POST')
        ;
        $formBuilder
            ->add('save', SubmitType::class)
        ;
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            foreach ($data as $key => $value) {
                $this->setVar($key, $value);
            }
            $request->getSession()
                ->getFlashBag()
                ->add('status', $this->__('Setting changes.'));

            $this->redirect($this->generateUrl('kaikmediaantispammodule_admin_captcha'));    
        }

        return $this->render('@KaikmediaAntispamModule/Captcha/admin.form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/recaptcha")
     *
     * @Theme("admin")
     *
     * the main administration function
     *
     * @return RedirectResponse
     */
    public function recaptchaAction(Request $request)
    {
        // access throw component instance user
        $this->get('kaikmedia_antispam_module.access_manager')->hasPermission(ACCESS_ADMIN, true);

        $settings = $this->getVars();
        $formBuilder = $this->get('form.factory')
            ->createBuilder(AdminReCaptchaType::class, $settings)
            // ->setMethod('POST')
        ;
        $formBuilder
            ->add('save', SubmitType::class)
        ;
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            foreach ($data as $key => $value) {
                $this->setVar($key, $value);
            }
            $request->getSession()
                ->getFlashBag()
                ->add('status', $this->__('Setting changes.'));

            $this->redirect($this->generateUrl('kaikmediaantispammodule_admin_recaptcha'));    
        }

        return $this->render('@KaikmediaAntispamModule/Recaptcha/admin.form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/honeypot")
     *
     * @Theme("admin")
     *
     * the main administration function
     *
     * @return RedirectResponse
     */
    public function honeypotAction(Request $request)
    {
        // access throw component instance user
        $this->get('kaikmedia_antispam_module.access_manager')->hasPermission(ACCESS_ADMIN, true);

        $settings = $this->getVars();
        $formBuilder = $this->get('form.factory')
            ->createBuilder(AdminHoneypotType::class, $settings)
            // ->setMethod('POST')
        ;
        $formBuilder
            ->add('save', SubmitType::class)
        ;
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            foreach ($data as $key => $value) {
                $this->setVar($key, $value);
            }
            $request->getSession()
                ->getFlashBag()
                ->add('status', $this->__('Setting changes.'));

            $this->redirect($this->generateUrl('kaikmediaantispammodule_admin_honeypot'));    
        }

        return $this->render('@KaikmediaAntispamModule/Honeypot/admin.form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/preferences")
     *
     * @Theme("admin")
     *
     * @return Response symfony response object
     * @throws AccessDeniedException Thrown if the user doesn't have admin access to the module
     */
    public function preferencesAction(Request $request)
    {
        // access throw component instance user
        $this->get('kaikmedia_antispam_module.access_manager')->hasPermission(ACCESS_ADMIN, true);

        $settings = $this->getVars();
        $formBuilder = $this->get('form.factory')
            ->createBuilder(AdminPreferencesType::class, $settings)
            // ->setMethod('POST')
        ;
        $formBuilder
            ->add('save', SubmitType::class)
        ;
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            foreach ($data as $key => $value) {
                $this->setVar($key, $value);
            }
            $request->getSession()
                ->getFlashBag()
                ->add('status', $this->__('Setting changes.'));

            $this->redirect($this->generateUrl('kaikmediaantispammodule_admin_preferences'));    
        }

        return $this->render('@KaikmediaAntispamModule/Admin/preferences.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
