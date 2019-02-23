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

Factory::getDocument()->addScriptDeclaration("
document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('#mg_$uid')) {
        lightGallery(document.querySelector('#mg_$uid'), {download: false});
    }
});
");

?>

<div id="mg_<?php echo $uid; ?>" class="mgallery">

    <?php foreach ($items as $item) { ?>
    <a class="item" href="<?php echo $item; ?>" style="width:<?php echo $width; ?>">
        <span
            class="item-img lazyload"
            <?php if ($lazysizes) { ?>
            data-bgset="<?php echo $item; ?>"
            <?php } else { ?>
            style="background-image:url(<?php echo $item; ?>);"
            <?php } ?>
        ></span>
    </a>
    <?php } ?>

</div>