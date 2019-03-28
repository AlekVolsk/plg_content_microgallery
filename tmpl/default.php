<?php defined('_JEXEC') or die;
/*
 * @package     Joomla.Plugin
 * @subpackage  Content.microgallery
 * @copyright   Copyright (C) 2019 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

use Joomla\CMS\Factory;

$uid = uniqid();
$width = $this->params->get('width', '25%');

if ($lightbox) {
    Factory::getDocument()->addScriptDeclaration("
    document.addEventListener('DOMContentLoaded', function() {
        if (document.querySelector('#mg_$uid')) {
            lightGallery(document.querySelector('#mg_$uid'), {download: false});
        }
    });
    ");
}

if (strpos($width, '%') !== false) {
    $widthLarge = (int)$width;
    $widthMiddle = (int)( 100 / ((100 / $widthLarge) - 1));
    $widthSmall = (int)(100 / (100 / $widthLarge / 2));
    Factory::getDocument()->addStyleDeclaration("
    #mg_$uid .item { width: 100%; }
    @media (min-width: 480px) { #mg_$uid .item { width: $widthSmall%; } }
    @media (min-width: 640px) { #mg_$uid .item { width: $widthMiddle%; } }
    @media (min-width: 960px) { #mg_$uid .item { width: $widthLarge%; } }
    ");
} else {
    Factory::getDocument()->addStyleDeclaration("#mg_$uid .item { width: $width; }");
}

?>

<?php if ($caption) { ?>
<h3><?php echo $caption; ?></h3>
<?php } ?>

<div id="mg_<?php echo $uid; ?>" class="mgallery">

    <?php foreach ($items as $item) { ?>
    <a class="item" href="<?php echo $item; ?>">
        <span
            class="item-img<?php if ($lazysizes) { echo ' lazyload'; } ?>"
            <?php if ($lazysizes) { ?>
            data-bgset="<?php echo $item; ?>"
            <?php } else { ?>
            style="background-image:url(<?php echo $item; ?>);"
            <?php } ?>
        ></span>
    </a>
    <?php } ?>

</div>