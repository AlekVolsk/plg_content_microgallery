<?php defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Filesystem\Path;
use Joomla\CMS\Filesystem\Folder;

class JFormFieldPlugintemplates extends JFormField
{
    protected $type = 'plugintemplates';

    protected function getInput()
    {

        if ($this->form instanceof JForm) {
            $plugin = $this->form->getValue('element');
            $folder = $this->form->getValue('folder');
        } else {
            return '';
        }
        $plugin_path = '/plugins/' . $folder . '/' . $plugin;
        $layouts_overrided_path = 'plg_' . $folder . '_' . $plugin;

        $client = ApplicationHelper::getClientInfo(0);
        $client_admin = ApplicationHelper::getClientInfo(1);

        $lang = Factory::getLanguage();
        $lang->load($plugin . '.sys', $client_admin->path, null, false, true)
            || $lang->load($plugin . '.sys', $client_admin->path . $plugin_path, null, false, true);

        $layouts_path = Path::clean($client->path . $plugin_path . '/tmpl');

        $plugin_layouts = [];

        $groups = [];

        if (is_dir($layouts_path) && ($plugin_layouts = Folder::files($layouts_path, '^[^_]*\.php$'))) {
            $groups['_'] = [];
            $groups['_']['id'] = $this->id . '__';
            $groups['_']['text'] = Text::sprintf('JOPTION_FROM_MODULE');

            foreach ($plugin_layouts as $file) {
                $value = basename($file, '.php');
                $groups['_']['items'][] = HTMLHelper::_('select.option', '_:' . $value, $value);
            }
        }

        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query
            ->select('template')
            ->from('#__template_styles')
            ->where('client_id = 0')
            ->where('home = 1');

        $template = $db->setQuery($query)->loadResult();

        $template_style_id = '';
        $template_style_id = $this->form->getValue('template_style_id');
        $template_style_id = preg_replace('#\W#', '', $template_style_id);

        $query = $db->getQuery(true);

        $query
            ->select('element, name')
            ->from('#__extensions as e')
            ->where('e.client_id = 0')
            ->where('e.type = ' . $db->quote('template'))
            ->where('e.enabled = 1');

        if ($template) {
            $query->where('e.element = ' . $db->quote($template));
        }

        if ($template_style_id) {
            $query
                ->join('LEFT', '#__template_styles as s on s.template=e.element')
                ->where('s.id=' . (int)$template_style_id);
        }

        $templates = $db->setQuery($query)->loadObjectList('element');

        if ($templates) {
            foreach ($templates as $template) {
                $lang->load('tpl_' . $template->element . '.sys', $client->path, null, false, true)
                    || $lang->load('tpl_' . $template->element . '.sys', $client->path . '/templates/' . $template->element, null, false, true);

                $template_path = Path::clean($client->path . '/templates/' . $template->element . '/html/' . $layouts_overrided_path . '/');

                if (is_dir($template_path) && ($files = Folder::files($template_path, '^[^_]*\.php$'))) {

                    foreach ($files as $i => $file) {
                        if (in_array($file, $plugin_layouts)) {
                            unset($files[$i]);
                        }
                    }

                    if (count($files)) {
                        $groups[$template->element] = [];
                        $groups[$template->element]['id'] = $this->id . '_' . $template->element;
                        $groups[$template->element]['text'] = Text::sprintf('JOPTION_FROM_TEMPLATE', $template->name);
                        $groups[$template->element]['items'] = [];

                        foreach ($files as $file) {
                            $value = basename($file, '.php');
                            $groups[$template->element]['items'][] = HTMLHelper::_('select.option', $template->element . ':' . $value, $value);
                        }
                    }
                }
            }
        }

        $attr = $this->element['size'] ? ' size="' . (int)$this->element['size'] . '"' : '';
        $attr .= $this->element['class'] ? ' class="' . (string)$this->element['class'] . '"' : '';

        $html = [];
        $selected = [$this->value];
        $html[] = HTMLHelper::_('select.groupedlist', $groups, $this->name, ['id' => $this->id, 'group.id' => 'id', 'list.attr' => $attr, 'list.select' => $selected]);

        return implode($html);
    }
}
