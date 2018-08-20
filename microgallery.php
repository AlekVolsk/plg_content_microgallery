<?php defined( '_JEXEC' ) or die;
/*
 * @package     Joomla.Plugin
 * @subpackage  Content.microgallery
 * @copyright   Copyright (C) 2018 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

class plgContentMicrogallery extends JPlugin
{
	
	public function onContentPrepare( $context, $article, $params )
	{
		if ( $context == 'com_finder.indexer' )
		{
			return;
		}
		
		$regex = '|<[^>]+>{microgallery\s(.*?)}</[^>]+>|U';
		
		preg_match_all( $regex, $article->text, $results );
		
		if ( !$results )
		{
			return;
		}
		
		$layout = JPluginHelper::getLayoutPath( 'content', 'microgallery' );
		
		$doc = JFactory::getDocument();
		
		if ( $this->params->get( 'includes' ) == '1' )
		{
			$css = str_replace( JPATH_ROOT, '', dirname( $layout ) . '/' . basename( $layout, '.php' ) . '.css' );
			if ( !file_exists( JPATH_ROOT . $css ) )
			{
				$css = '/plugins/content/microgallery/assets/microgallery.css';
			}
			$css = str_replace( '\\', '/', $css );
			$doc->addStyleSheet( $css );
		}
		
		if ( $this->params->get( 'lightbox' ) == '1' )
		{
			JHtml::_( 'jquery.framework', false, null, false );
			$doc->addStyleSheet( '/plugins/content/microgallery/assets/lightbox2/css/lightbox.min.css' );
			$doc->addScript( '/plugins/content/microgallery/assets/lightbox2/js/lightbox.min.js', 'text/javascript', true );
		}
		
		foreach ( $results[ 1 ] as $key => $result )
		{
			$items = glob( JPATH_ROOT . '/' . $result . '/*.{jpg,jpeg,png,gif,svg}', GLOB_BRACE );
			foreach ( $items as $i => $item )
			{
				$items[ $i ] = str_replace( JPATH_ROOT, '', $item );
			}
			
			ob_start();
			include $layout;
			$article->text = str_replace( $results[ 0 ][ $key ], ob_get_clean(), $article->text );
		}
	}
	
}