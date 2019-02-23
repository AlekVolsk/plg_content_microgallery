<?php defined('_JEXEC') or die;
/*
 * @package     Joomla.Plugin
 * @subpackage  Content.microgallery
 * @copyright   Copyright (C) 2019 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Plugin\PluginHelper;

class plgContentMicrogallery extends CMSPlugin
{

    public function onContentPrepare($context, $article, $params, $page = 0)
    {
        if ($context == 'com_finder.indexer') {
            return;
        }

        $regex = '/{microgallery\s(.*?)}/U';

        $results = [];
        preg_match_all($regex, $article->text, $results);

        if (!$results) {
            return;
        }

        $layout = PluginHelper::getLayoutPath('content', 'microgallery');

        if ($this->params->get('includes') == '1') {
            $css = str_replace(JPATH_ROOT . DIRECTORY_SEPARATOR, '', dirname($layout) . DIRECTORY_SEPARATOR . basename($layout, '.php') . '.css');
            if (!file_exists(JPATH_ROOT . $css)) {
                $css = 'plugins/content/microgallery/assets/microgallery.css';
            }
            $css = str_replace('\\', '/', $css);
            HTMLHelper::stylesheet($css);
        }

        $lazysizes = $this->params->get('lazysizes') == '1';
        if ($lazysizes) {
            HTMLHelper::script('plugins/content/microgallery/assets/lazysizes/ls.bgset.min.js');
            HTMLHelper::script('plugins/content/microgallery/assets/lazysizes/lazysizes.min.js');
        }

        if ($this->params->get('lightbox') == '1') {
            HTMLHelper::stylesheet('plugins/content/microgallery/assets/lightgallery/css/lightgallery.min.css');
            HTMLHelper::script('plugins/content/microgallery/assets/lightgallery/js/lightgallery.min.js');
        }

        foreach ($results[1] as $key => $result) {
            if ($result && $result[0] != '/') {
                $result = '/' . $result;
            }
            if ($result && $result[strlen($result) - 1] != '/') {
                $result .= '/';
            }
            $items = glob(str_replace('\\', '/', JPATH_ROOT . $result . '*.{jpg,jpeg,png,gif,svg}'), GLOB_BRACE);
            foreach ($items as $i => $item) {
                $items[$i] = str_replace(str_replace('\\', '/', JPATH_ROOT) . '/', '', $item);
            }

            ob_start();
            include $layout;
            $article->text = str_replace($results[0][$key], ob_get_clean(), $article->text);
        }
    }
}

