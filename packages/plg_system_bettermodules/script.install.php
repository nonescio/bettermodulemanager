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

require_once __DIR__ . '/script.install.helper.php';

class PlgSystemBetterModulesInstallerScript extends PlgSystemBetterModulesInstallerScriptHelper
{
	public $name           = 'BETTER_MODULE_MANAGER';
	public $alias          = 'bettermodulemanager';
	public $extname        = 'bettermodules';
	public $extension_type = 'plugin';

	public function uninstall($adapter)
	{
		$this->uninstallComponent($this->extname);
	}

	public function onAfterInstall()
	{
		$this->setPluginOrdering();
	}

	private function setPluginOrdering()
	{
		$query = $this->db->getQuery(true)
			->update('#__extensions')
			->set($this->db->quoteName('ordering') . ' = -1')
			->where($this->db->quoteName('type') . ' = ' . $this->db->quote('plugin'))
			->where($this->db->quoteName('element') . ' = ' . $this->db->quote('bettermodules'))
			->where($this->db->quoteName('folder') . ' = ' . $this->db->quote('system'));
		$this->db->setQuery($query);
		$this->db->execute();

		JFactory::getCache()->clean('_system');
	}
}
