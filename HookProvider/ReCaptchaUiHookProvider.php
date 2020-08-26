<?php

/**
 * KaikMedia AntispamModule
 *
 * @package    KaikmediaAntispamModule
 * @author     Kaik <contact@kaikmedia.com>
 * @copyright  KaikMedia
 * @link       https://github.com/Kaik/KaikMediaAntispam.git
 */

namespace Kaikmedia\AntispamModule\HookProvider;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Zikula\Bundle\HookBundle\Category\UiHooksCategory;
use Zikula\Bundle\HookBundle\Hook\DisplayHook;
use Zikula\Bundle\HookBundle\Hook\DisplayHookResponse;
use Zikula\Bundle\HookBundle\Hook\ProcessHook;
use Zikula\Bundle\HookBundle\Hook\ValidationHook;
use Zikula\Bundle\HookBundle\Hook\ValidationResponse;
use Zikula\Bundle\HookBundle\HookProviderInterface;
use Zikula\Bundle\HookBundle\ServiceIdTrait;

use Zikula\Common\Translator\TranslatorInterface;
use Zikula\ExtensionsModule\Api\VariableApi;

use Kaikmedia\AntispamModule\Exception\RedirectBotException;

/**
 * HonneyPot hook provider
 */
class ReCaptchaUiHookProvider implements HookProviderInterface
{
    use ServiceIdTrait;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var EngineInterface
     */
    protected $renderEngine;

    /**
     * @var VariableApi
     */
    private $variableApi;

    /**
     * CommentFormAwareHookProvider constructor.
     *
     * @param TranslatorInterface  $translator
     * @param SessionInterface     $session
     * @param RequestStack $requestStack
     * @param RouterInterface $router
     * @param EngineInterface $renderEngine
     * @param VariableApi $variableApi
     */
    public function __construct(
        TranslatorInterface $translator,
        SessionInterface $session,
        RequestStack $requestStack,
        RouterInterface $router,
        EngineInterface $renderEngine,
        VariableApi $variableApi
    ) {
        $this->translator = $translator;
        $this->session = $session;
        $this->requestStack = $requestStack;
        $this->router = $router;
        $this->renderEngine = $renderEngine;
        $this->variableApi = $variableApi;
        $this->sitekey = $this->variableApi->get($this->getOwner(), 'recaptcha_sitekey', false);
        $this->secretkey = $this->variableApi->get($this->getOwner(), 'recaptcha_secretkey', false);
        $this->enabled = $this->variableApi->get($this->getOwner(), 'recaptcha_enabled', false) 
            && isset($this->sitekey)
            && isset($this->secretkey)
            ;
    }

    /**
     * @inheritDoc
     */
    public function getOwner()
    {
        return 'KaikmediaAntispamModule';
    }
    
    /**
     * @inheritDoc
     */
    public function getCategory()
    {
        return UiHooksCategory::NAME;
    }
    
    /**
     * @inheritDoc
     */
    public function getTitle()
    {
        return $this->translator->__('ReCaptcha ui hook provider');
    }

    public function getProviderTypes()
    {
        return [
            UiHooksCategory::TYPE_FORM_EDIT => 'edit',
            UiHooksCategory::TYPE_VALIDATE_EDIT => 'validateEdit',
        ];
    }

    public function edit(DisplayHook $hook)
    {
        if ($this->enabled) {
            $content = $this->renderEngine->render('KaikmediaAntispamModule:Recaptcha:hook.edit.html.twig', [
                'sitekey' => $this->sitekey
            ]);
            $hook->setResponse(new DisplayHookResponse('provider.kaikmediaantispammodule.ui_hooks.recaptcha', $content));
        }
    }

    public function validateEdit(ValidationHook $hook)
    {
        if ($this->enabled) {
            $data = $this->requestStack->getCurrentRequest()->request->all();
            $captcha = isset($data['g-recaptcha-response']) ? $data['g-recaptcha-response'] : false;
            if (!$captcha) {
                $error = $this->translator->__("Please click on a box next to 'I'm not a robot' text");
                // below commented code works only with symfony forms not custom "external" fields
                // $response = new ValidationResponse('g-recaptcha-response', $data['g-recaptcha-response']);
                // $response->addError('g-recaptcha-response', $error);
                // $hook->setValidator('provider.kaikmediaantispammodule.ui_hooks.recaptcha', $response);
                $this->session->getFlashBag()->add('error', $error);

                return false;
            }

            // post request to server
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($this->secretkey) .  '&response=' . urlencode($captcha);
            $response = file_get_contents($url);
            $responseKeys = json_decode($response, true);
            // should return JSON with success as true
            if(!$responseKeys["success"]) {
                throw new RedirectBotException(
                    new RedirectResponse($this->router->generate('kaikmediaantispammodule_registered_registered', [], RouterInterface::ABSOLUTE_URL))
                );
            }
        }

        return true;
    }
}
