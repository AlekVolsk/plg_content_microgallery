<?php defined('_JEXEC') or die;
/*
 * @package     Joomla.Plugin
 * @subpackage  Content.microgallery
 * @copyright   Copyright (C) 2019 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

class plgContentMicrogalleryInstallerScript
{
	function postflight( $type, $parent )
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery( true )
			->update( '#__extensions' )
			->set( 'enabled=1' )
			->where( 'type=' . $db->quote( 'plugin' ) )
			->where( 'element='.$db->quote( 'microgallery' ) );
		$db->setQuery( $query )->execute();
	}
}