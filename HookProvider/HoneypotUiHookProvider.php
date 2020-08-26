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
class HoneypotUiHookProvider implements HookProviderInterface
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

        $fields = $this->variableApi->get($this->getOwner(), 'honeypot_fields', '');
        $this->fields = explode(',', str_replace(' ', '', $fields));
        $this->enabled = $this->variableApi->get($this->getOwner(), 'honeypot_enabled', false)
                && !empty($fields)
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
        return $this->translator->__('Honeypot ui hook provider');
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
            $content = $this->renderEngine->render('KaikmediaAntispamModule:Honeypot:hook.edit.html.twig', [
                'fields' => $this->fields
            ]);
            $hook->setResponse(new DisplayHookResponse('provider.kaikmediaantispammodule.ui_hooks.honeypot', $content));
        }
    }

    public function validateEdit(ValidationHook $hook)
    {
        if ($this->enabled) {
            $data = $this->requestStack->getCurrentRequest()->request->all();
            foreach ($this->fields as $field) {
                if (!isset($data['ant_your_'. $field]) || !empty($data['ant_your_'. $field])) {
                    throw new RedirectBotException(
                        new RedirectResponse($this->router->generate('kaikmediaantispammodule_registered_registered', [], RouterInterface::ABSOLUTE_URL))
                    );
                }
            }
        }

        return true;
    }
}
