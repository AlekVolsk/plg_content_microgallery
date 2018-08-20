<?php defined('_JEXEC') or die;
/*
 * @package     Joomla.Plugin
 * @subpackage  Content.microgallery
 * @copyright   Copyright (C) 2017 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

$uid = uniqid();
$width = $this->params->get('width', '300px');
$height = ((int)$width * .75) . 'px';
?>

<div class="mgallery">

	<?php foreach($items as $item) { ?>
	<a
		class="item"
		href="<?php echo $item; ?>"
		style="background-image:url('<?php echo $item; ?>');width:<?php echo $width; ?>;height:<?php echo $height; ?>;"
		data-lightbox="mg_<?php echo $uid; ?>"
		data-title="<?php echo $item; ?>"
	></a>
	<?php } ?>

</div>
