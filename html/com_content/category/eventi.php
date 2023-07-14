<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

use Joomla\CMS\Uri\Uri;

$url = Uri::root();

$app = Factory::getApplication();

$this->category->text = $this->category->description;
$app->triggerEvent('onContentPrepare', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]);
$this->category->description = $this->category->text;

$results = $app->triggerEvent('onContentAfterTitle', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]);
$afterDisplayTitle = trim(implode("\n", $results));

$results = $app->triggerEvent('onContentBeforeDisplay', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]);
$beforeDisplayContent = trim(implode("\n", $results));

$results = $app->triggerEvent('onContentAfterDisplay', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]);
$afterDisplayContent = trim(implode("\n", $results));

$htag    = $this->params->get('show_page_heading') ? 'h2' : 'h1';

//echo json_encode($this->category);
//echo $this->category->parent_id;
$catactive =  $this->category->title;

$baseImagePath = Uri::root(false) . "media/templates/site/joomla-italia-theme/images/";

?>

<div class="blogj4a blog-category" itemscope itemtype="https://schema.org/Blog">
    <section class="section bg-greendark bg-greendarkgradient py-5 position-relative d-flex align-items-center overflow-hidden">
        <div class="green-square-forms">
            <svg width="100%" height="100%" viewBox="0 0 726 360" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;"><g id="Group" opacity="0.32"><path id="Rectangle" d="M627.751,245.625l-396.368,-193.321l-193.322,396.368l396.368,193.321l193.322,-396.368Z" style="fill:url(#_Linear1);"></path><path id="Rectangle1" serif:id="Rectangle" d="M583.359,-179.506l-264.865,159.147l159.147,264.865l264.865,-159.147l-159.147,-264.865Z" style="fill:url(#_Linear2);"></path><path id="Rectangle2" serif:id="Rectangle" d="M210.182,-54.565l-213.341,33.79l33.79,213.34l213.341,-33.79l-33.79,-213.34Z" style="fill:url(#_Linear3);"></path></g><defs><linearGradient id="_Linear1" x1="0" y1="0" x2="1" y2="0" gradientUnits="userSpaceOnUse" gradientTransform="matrix(203.046,589.69,-589.69,203.046,231.383,52.3035)"><stop offset="0" style="stop-color:#0f842e;stop-opacity:1"></stop><stop offset="1" style="stop-color:#00838f;stop-opacity:1"></stop></linearGradient><linearGradient id="_Linear2" x1="0" y1="0" x2="1" y2="0" gradientUnits="userSpaceOnUse" gradientTransform="matrix(344.438,-26.7144,26.7144,344.438,398.068,112.073)"><stop offset="0" style="stop-color:#0e8a5f;stop-opacity:1"></stop><stop offset="1" style="stop-color:#00838f;stop-opacity:1"></stop></linearGradient><linearGradient id="_Linear3" x1="0" y1="0" x2="1" y2="0" gradientUnits="userSpaceOnUse" gradientTransform="matrix(230.236,72.8805,-72.8805,230.236,13.7359,85.8949)"><stop offset="0" style="stop-color:#0e8a5f;stop-opacity:1"></stop><stop offset="1" style="stop-color:#00838f;stop-opacity:1"></stop></linearGradient></defs>
            </svg>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="hero-title text-left">
                        <?php if ($this->params->get('show_category_title', 1)) : ?>
                            <h1><?php echo $this->category->title; ?></h1>
                        <?php endif; ?>
                        <?php if ($this->params->get('show_page_heading')) : ?>
                            <h1><?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
                        <?php endif; ?>
                        <?php echo $afterDisplayTitle; ?>
                        <?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
                            <?php $this->category->tagLayout = new FileLayout('joomla.content.tags'); ?>
                            <?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
                        <?php endif; ?>
                    </div>

                    <?php if ($beforeDisplayContent || $afterDisplayContent || $this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
                        <div class="category-desc clearfix h4 font-weight-normal">
                            <?php echo $beforeDisplayContent; ?>
                            <?php if ($this->params->get('show_description') && $this->category->description) : ?>
                                <?php echo HTMLHelper::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
                            <?php endif; ?>

                            <?php echo $afterDisplayContent; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <div class="wrapperblog redbrown <?php echo $this->params->get('blog_class') ?>">
        <?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
            <?php if ($this->params->get('show_no_articles', 1)) : ?>
            <div class="container">
                <div class="alert alert-info">
                    <span class="icon-info-circle" aria-hidden="true"></span><span class="visually-hidden"><?php echo Text::_('INFO'); ?></span>
                        <?php echo Text::_('COM_CONTENT_NO_ARTICLES'); ?>
                </div>
            </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($this->children[$this->category->id]) : ?>
            <div class="wrapper-subcategorie">
                <?php foreach ($this->children[$this->category->id] as $kategorie) : ?>
                    <section class="py-5">
                        <div class="container">
                            <div class="title-section ms-3 mb-2">
                                <h2 class="h4"><?php echo $kategorie->title; ?></h2>
                            </div>
                            <div class="row">
                                <?php $kategoriereset = 0; ?>
                                <?php if (!empty($this->intro_items)) : ?>
                                    <?php if ($kategorie->title == "Notizie") {
                                        ?>
                                        <div class="col-12">
                                            <div class="owl-carousel owl-theme carousel-theme" id="carosellonotizie">
                                                <?php foreach ($this->intro_items as $key => $item) :
                                                    if ($item->catid !== $kategorie->id) {
                                                        continue;
                                                    }
                                                    $this->item = $item;
                                                    echo $this->loadTemplate('itemsottocategorie');
                                                endforeach; ?>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($kategorie->title == "Circolari") {
                                        ?>
                                        <div class="col-12">
                                            <div class="owl-carousel owl-theme carousel-theme" id="carosellocircolari">
                                                <?php foreach ($this->intro_items as $key => $item) :
                                                    if ($item->catid !== $kategorie->id) {
                                                        continue;
                                                    } ?>

                                                            <?php
                                                        $this->item = $item;
                                                    echo $this->loadTemplate('itemsottocategorienoimg'); ?>

                                                    <?php
                                                endforeach; ?>
                                            </div>
                                        </div>
                                    <?php
                                    } elseif ($kategorie->title == "Eventi") {
                                        ?>
                                        <div class="col-12">
                                            <div class="owl-carousel owl-theme carousel-theme" id="caroselloeventi">
                                                <?php foreach ($this->intro_items as $key => $item) :
                                                    if ($item->catid !== $kategorie->id) {
                                                        continue;
                                                    } ?>

                                                            <?php
                                                        $this->item = $item;
                                                    echo $this->loadTemplate('itemsottocategorienoimg'); ?>

                                                    <?php
                                                endforeach; ?>
                                            </div>
                                        </div>
                                    <?php
                                    } ?>
                                <?php endif; ?>

                            </div>
                            <div class="text-center pt-3">
                                <a href="<?php echo Route::_(RouteHelper::getCategoryRoute($kategorie->id, $kategorie->language)); ?>" class="text-underline small">Vedi tutti</a>
                            </div>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
        <?php elseif (!empty($this->intro_items)) : ?>
            <section class="bg-white border-top border-bottom d-block d-lg-none">
                <div class="container d-flex justify-content-between align-items-center py-3">
                    <h3 class="h6 text-uppercase mb-0 label-filter"><strong>Filtri</strong></h3>
                    <a class="toggle-filtri" href="#" aria-label="filtri" id="filtri-tipologia" title="Filtra per tipologia">
                    <svg class="icon icon-sm">
                        <use xlink:href="<?= $baseImagePath ?>sprites.svg#it-funnel"></use>
                    </svg>
                    </a>
                </div>
		    </section>
            <section class="bg-gray-light">
            <div class="container">
                    <div class="row">
                        <div class="tipologia-menu col-lg-3 bg-white bg-white-left">
                            <aside class="aside-list aside-sticky">
                                <div class="d-flex d-lg-none mb-3 align-items-center">
                                    <a class="toggle-filtri pe-2" href="#" aria-label="chiudi filtri" id="back-filtri-tipologia" title="Chiudi i filtri per tipologia">
                                        <svg class="icon">
                                            <use xlink:href="<?= $baseImagePath ?>sprites.svg#it-arrow-left"></use>
                                        </svg>
                                    </a>
                                    <p class="h6 mb-0 label-filter lh100"><strong>Filtri</strong></p>
                                </div>
                                <h2 class="h6 text-uppercase"><strong>Tipologia</strong></h2>
                                <?php
                                                                    // Mostro le categorie che hanno la stessa categoria parent
                                                                    $db = Factory::getContainer()->get('DatabaseDriver');
            $query = $db->getQuery(true);

            $query->select($db->quoteName(array('title', 'id','language')))
                ->from($db->quoteName('#__categories'))
                ->where($db->quoteName('parent_id') . ' = '. $this->category->parent_id)
                ->where($db->quoteName('extension') . ' = ' . $db->quote('com_content'));
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            ?>

                                <ul class="">
                                    <?php foreach ($rows as $row) : ?>
                                        <div class="form-check my-0">
                                            <li class="catsamelevel">
                                                <input type="RADIO" value="<?php echo Route::_(RouteHelper::getCategoryRoute($row->id, $row->language)); ?>" onchange="window.open(this.value, '_self')" name="<?php echo $row->title; ?>" id="check-<?php echo $row->title; ?>" <?php echo ($catactive == $row->title) ? ('checked') :''; ?>>
                                                <label class="mb-0" for="check-<?php echo $row->title; ?>"><?php echo $row->title; ?></label>
                                            </li>
                                        </div>
                                    <?php endforeach ?>
                                </ul>
                            </aside>
                        </div>
                        <div class="col-lg-8 col-xl-7 offset-lg-1 pt84">
                                <?php foreach ($this->intro_items as $key => $item) :
                                    $this->item = $item;
                                    echo $this->loadTemplate('item');
                                endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if (!empty($this->link_items)) : ?>
            <div class="items-more">
                <?php echo $this->loadTemplate('links'); ?>
            </div>
        <?php endif; ?>

        <?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
            <div class="com-content-category-blog__navigation w-100">
                <?php if ($this->params->def('show_pagination_results', 1)) : ?>
                    <p class="com-content-category-blog__counter counter float-end pt-3 pe-2">
                        <?php echo $this->pagination->getPagesCounter(); ?>
                    </p>
                <?php endif; ?>
                <div class="com-content-category-blog__pagination">
                    <?php echo $this->pagination->getPagesLinks(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
