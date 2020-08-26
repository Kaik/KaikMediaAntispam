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

/**
 * Module-wide constants for the Antispam Module module.
 *
 * NOTE: Do not define anything other than constants in this class!
 */
class Constant
{
    /**
     * The official internal module name.
     *
     * @var string
     */
    const MODNAME = 'KaikmediaAntispamModule';
    
    const ADMIN_FORM_PREFERENCES = 'kaikmedia_antispam_admin_form_preferences';
    const ADMIN_FORM_BANNED = 'kaikmedia_antispam_admin_form_banned';
    const ADMIN_FORM_QUESTION = 'kaikmedia_antispam_admin_form_question';
    const ADMIN_FORM_CAPTCHA = 'kaikmedia_antispam_admin_form_captcha';
    const ADMIN_FORM_RECAPTCHA = 'kaikmedia_antispam_admin_form_recaptcha';
    const ADMIN_FORM_HONEYPOT = 'kaikmedia_antispam_admin_form_honeypot';
}
