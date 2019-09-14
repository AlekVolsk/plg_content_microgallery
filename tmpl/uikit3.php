<?php defined('_JEXEC') or die;
/*
 * @package     Joomla.Plugin
 * @subpackage  Content.microgallery
 * @copyright   Copyright (C) 2019 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

?>

<div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l uk-grid-small" data-uk-grid="masonry:true" data-uk-lightbox>

    <?php foreach ($items as $item) { ?>
    <div>
        <a
            href="<?php echo $item->full; ?>"
            <?php echo ($caption ? ' data-alt="' . $caption . '"' : ''); ?>
            <?php echo ($caption ? ' data-caption="' . $caption . '"' : ''); ?>
        >
            <img data-src="<?php echo $item->small; ?>"<?php echo ($caption ? ' data-caption="' . $caption . '"' : ''); ?> alt="<?php echo $caption; ?>" class="uk-width" data-uk-img>
        </a>
    </div>
    <?php } ?>

</div>
