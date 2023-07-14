<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;

/** @var \Joomla\Component\Users\Site\View\Login\HtmlView $cookieLogin */

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate');

$usersConfig = ComponentHelper::getParams('com_users');

?>
<div class="container">
    <div class="com-users-login login mb-5">
        <?php if ($this->params->get('show_page_heading')) : ?>
        <div class="page-header">
            <h1>
                <?php echo $this->escape($this->params->get('page_heading')); ?>
            </h1>
        </div>
        <?php endif; ?>

        <?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description', '')) != '') || $this->params->get('login_image') != '') : ?>
        <div class="com-users-login__description login-description mb-3">
        <?php endif; ?>

            <?php if ($this->params->get('logindescription_show') == 1) : ?>
                <?php echo $this->params->get('login_description'); ?>
            <?php endif; ?>

            <?php if ($this->params->get('login_image') != '') : ?>
                <?php echo HTMLHelper::_('image', $this->params->get('login_image'), empty($this->params->get('login_image_alt')) && empty($this->params->get('login_image_alt_empty')) ? false : $this->params->get('login_image_alt'), ['class' => 'com-users-login__image login-image']); ?>
            <?php endif; ?>

        <?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description', '')) != '') || $this->params->get('login_image') != '') : ?>
        </div>
        <?php endif; ?>

        <form action="<?php echo Route::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="com-users-login__form form-validate form-horizontal well" id="com-users-login__form">

            <fieldset>
                <legend></legend>
                <?php echo $this->form->renderFieldset('credentials', ['class' => 'com-users-login__input']); ?>



                <?php foreach ($this->extraButtons as $button) :
                    $dataAttributeKeys = array_filter(array_keys($button), function ($key) {
                        return substr($key, 0, 5) == 'data-';
                    });
                    ?>
                    <div class="com-users-login__submit control-group">
                        <div class="controls">
                            <button type="button"
                                    class="btn btn-secondary w-100 <?php echo $button['class'] ?? '' ?>"
                                    <?php foreach ($dataAttributeKeys as $key) : ?>
                                        <?php echo $key ?>="<?php echo $button[$key] ?>"
                                    <?php endforeach; ?>
                                    <?php if ($button['onclick']) : ?>
                                    onclick="<?php echo $button['onclick'] ?>"
                                    <?php endif; ?>
                                    title="<?php echo Text::_($button['label']) ?>"
                                    id="<?php echo $button['id'] ?>"
                            >
                                <?php if (!empty($button['icon'])) : ?>
                                    <span class="<?php echo $button['icon'] ?>"></span>
                                <?php elseif (!empty($button['image'])) : ?>
                                    <?php echo HTMLHelper::_('image', $button['image'], Text::_($button['tooltip'] ?? ''), [
                                        'class' => 'icon',
                                    ], true) ?>
                                <?php elseif (!empty($button['svg'])) : ?>
                                    <?php echo $button['svg']; ?>
                                <?php endif; ?>
                                <?php echo Text::_($button['label']) ?>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="row">
                    <div class="col text-right mb-3 text-login-reset">
                        <a class="com-users-login__reset" href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>" title="Vai alla pagina del reset password">Password<?php //echo Text::_('COM_USERS_LOGIN_RESET');?></a> o <a class="com-users-login__remind" href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>" title="Vai alla pagina recupero nome utente">Utente<?php //echo Text::_('COM_USERS_LOGIN_REMIND');?></a> dimenticati?<?php if ($usersConfig->get('allowUserRegistration')) : ?> Oppure <a class="com-users-login__register" href="<?php echo Route::_('index.php?option=com_users&view=registration'); ?>" title="Vai alla pagina di registrazione">Registrati<?php //echo Text::_('COM_USERS_LOGIN_REGISTER');?></a>
            <?php endif; ?>
                    </div>
                </div>
                <div class="row align-items-center mb-3">
                    <?php if (PluginHelper::isEnabled('system', 'remember')) : ?>
                        <div class="col-4">
                            <div class="com-users-login__remember">
                                <div class="form-check mt-0">
                                    <input class="form-check-input" id="remember" type="checkbox" name="remember" value="yes">
                                    <label class="form-check-label" for="remember">
                                        <?php echo Text::_('COM_USERS_LOGIN_REMEMBER_ME'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col">
                        <div class="com-users-login__submit control-group">
                            <div class="controls">
                                <button type="submit" class="btn btn-secondary w-100">
                                    <?php echo Text::_('JLOGIN'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php $return = $this->form->getValue('return', '', $this->params->get('login_redirect_url', $this->params->get('login_redirect_menuitem', ''))); ?>
                <input type="hidden" name="return" value="<?php echo base64_encode($return); ?>">
                <?php echo HTMLHelper::_('form.token'); ?>
            </fieldset>
        </form>
    </div>
</div>
