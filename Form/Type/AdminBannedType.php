<?php

/**
 * KaikMedia AntispamModule
 *
 * @package    KaikmediaAntispamModule
 * @author     Kaik <contact@kaikmedia.com>
 * @copyright  KaikMedia
 * @link       https://github.com/Kaik/KaikMediaAntispam.git
 */

namespace Kaikmedia\AntispamModule\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Zikula\Common\Translator\IdentityTranslator;
use Kaikmedia\AntispamModule\Constant;

class AdminBannedType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('banned_usernames_enabled', CheckboxType::class,[
                'required' => false,
            ])
            ->add('banned_usernames', TextareaType::class,[
                'required' => false,
            ])
            ->add('banned_emails_enabled', CheckboxType::class,[
                'required' => false,
            ])
            ->add('banned_emails', TextareaType::class,[
                'required' => false,
            ])
            ->add('banned_domains_enabled', CheckboxType::class,[
                'required' => false,
            ])
            ->add('banned_domains', TextareaType::class,[
                'required' => false,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return Constant::ADMIN_FORM_BANNED;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translator' => new IdentityTranslator(),
        ]);
    }
}
