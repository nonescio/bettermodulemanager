<?php
/**
 * @package         Better Module Manager
 *
 * @author          NoNescio
 * @link            https://www.github.com/nonescio/bettermodulemanager
 * @copyright       Copyright 2016 NoNescio All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */


/**
 * FORKED FROM:
 */


/**
 * @package         Advanced Module Manager
 * @version         6.xPRO
 *
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2016 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

jimport('joomla.filesystem.file');

class PlgSystemBetterModulesHelper
{
	var $params     = null;
	var $use_legacy = false;

	function __construct(&$params)
	{
		$this->params = $params;
	}

	public function loadModuleHelper()
	{
		if (!$this->moduleHelperNeedsLegacy())
		{
			return;
		}

		$this->use_legacy = true;

		// No need to load the JModuleHelper again
		if ($this->moduleHelperModuleHelperIsLoaded())
		{
			return;
		}

		require_once JPATH_PLUGINS . '/system/bettermodules/modulehelper_legacy.php';
	}

	private function moduleHelperNeedsLegacy()
	{
		require_once JPATH_LIBRARIES . '/regularlabs/helpers/versions.php';

		// Return true if old JModuleHelper will be loaded by one of the following extensions
		if (
			(JPluginHelper::isEnabled('system', 't3') && version_compare(RLVersions::getPluginXMLVersion('t3'), '2.4.6', '<'))
			|| (JPluginHelper::isEnabled('system', 'helix') && version_compare(RLVersions::getPluginXMLVersion('helix'), '2.1.9', '<'))
			|| (JPluginHelper::isEnabled('system', 'jsntplframework') && version_compare(RLVersions::getPluginXMLVersion('jsntplframework'), '2.3.4', '<'))
			|| (JPluginHelper::isEnabled('system', 'magebridge') && version_compare(RLVersions::getPluginXMLVersion('magebridge'), '1.9.5295', '<'))
			|| (JPluginHelper::isEnabled('system', 'metamod'))
		)
		{
			return true;
		}

		return false;
	}

	private function moduleHelperModuleHelperIsLoaded()
	{
		$classes = get_declared_classes();
		if (!in_array('JModuleHelper', $classes) && !in_array('jmodulehelper', $classes))
		{
			return false;
		}

		return true;
	}

	public function registerEvents()
	{
		if ($this->use_legacy)
		{
			require_once JPATH_PLUGINS . '/system/bettermodules/bettermodulehelper_legacy.php';
			$class = new PlgSystemBetterModuleHelper;

			JFactory::getApplication()->registerEvent('onRenderModule', array($class, 'onRenderModule'));
			JFactory::getApplication()->registerEvent('onCreateModuleQuery', array($class, 'onCreateModuleQuery'));
			JFactory::getApplication()->registerEvent('onPrepareModuleList', array($class, 'onPrepareModuleList'));

			return;
		}

		require_once JPATH_PLUGINS . '/system/bettermodules/bettermodulehelper.php';
		$class = new PlgSystemBetterModuleHelper;

		JFactory::getApplication()->registerEvent('onRenderModule', array($class, 'onRenderModule'));
		JFactory::getApplication()->registerEvent('onPrepareModuleList', array($class, 'onPrepareModuleList'));
	}

	public function loadFrontEditScript()
	{
		if (JFactory::getUser()->authorise('core.edit', 'com_menus')
			&& JFactory::getApplication()->get('frontediting', 1) == 2
		)
		{
			JHtml::_('jquery.framework');

			require_once JPATH_LIBRARIES . '/regularlabs/helpers/functions.php';
			RLFunctions::script('bettermodules/frontediting.min.js', '6.0.1');
		}
	}

	public function replaceLinks()
	{
		if (JFactory::getApplication()->isAdmin() && JFactory::getApplication()->input->get('option') == 'com_modules')
		{
			$this->replaceLinksInCoreModuleManager();

			return;
		}

		$body = JFactory::getApplication()->getBody();

		if (!JFactory::getApplication()->isAdmin())
		{
			$this->replaceLinksInFrontend($body);
		}

		$this->replaceLinksModules($body);

		JFactory::getApplication()->setBody($body);
	}

	private function replaceLinksModules(&$string)
	{
		$string = preg_replace(
			'#(\?option=com_)(modules[^a-z-_])#',
			'\1better\2',
			$string
		);

		$string = str_replace(
			array(
				'?option=com_bettermodules&force=1',
				'?option=com_bettermodules&amp;force=1',
			),
			'?option=com_modules',
			$string
		);
	}

	private function replaceLinksInFrontend(&$string)
	{
		if (strpos($string, 'jmodediturl=') === false)
		{
			return;
		}

		$url = 'index.php?option=com_bettermodules&view=edit&task=edit';

		if (JFactory::getUser()->authorise('core.manage', 'com_modules') && $this->params->use_admin_from_frontend)
		{
			$url = 'administrator/index.php?option=com_bettermodules&task=module.edit';
		}

		$frontend_urls = array(
			'index.php?option=com_config&controller=config.display.modules',
			'administrator/index.php?option=com_modules&view=module&layout=edit',
		);

		array_walk($frontend_urls, function (&$value)
		{
			$value = preg_quote($value, '#');
		});

		$string = preg_replace(
			'#(jmodediturl="[^"]*)(' . implode('|', $frontend_urls) . ')#',
			'\1' . $url,
			$string
		);
	}

	private function replaceLinksInCoreModuleManager()
	{
		require_once JPATH_LIBRARIES . '/regularlabs/helpers/functions.php';

		RLFunctions::loadLanguage('com_bettermodules');

		$body = JFactory::getApplication()->getBody();

		$url = 'index.php?option=com_bettermodules';
		if (JFactory::getApplication()->input->get('view') == 'module')
		{
			$url .= '&task=module.edit&id=' . (int) JFactory::getApplication()->input->get('id');
		}

		$link = '<a style="float:right;" href="' . JRoute::_($url) . '">' . JText::_('BMM_SWITCH_TO_BETTER_MODULE_MANAGER') . '</a><div style="clear:both;"></div>';
		$body = preg_replace('#(</div>\s*</form>\s*(<\!--.*?-->\s*)*</div>)#', $link . '\1', $body);

		JFactory::getApplication()->setBody($body);
	}
}
