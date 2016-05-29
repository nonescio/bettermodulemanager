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

require_once JPATH_ADMINISTRATOR . '/components/com_bettermodules/views/module/view.html.php';
require_once JPATH_ADMINISTRATOR . '/components/com_bettermodules/helpers/modules.php';

class BetterModulesViewEdit extends BetterModulesViewModule
{
	protected $form;

	protected $item;

	protected $state;

	/**
	 * Display the view
	 *
	 * @param   string $tpl The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	public function display($tpl = null)
	{
		$this->setLayout('edit');

		parent::display($tpl);
	}

	/**
	 * Function that gets the config settings
	 *
	 * @return    Object
	 */
	protected function addToolbar()
	{
		return;
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array   $data     Data for the form.
	 * @param   boolean $loadData True if the form is to load its own data (default case), false if not.
	 *
	 * @return  JForm  A JForm object on success, false on failure
	 */
	public function getForm($data = array(), $loadData = true)
	{
		return $this->getModel()->getForm($data, $loadData);
	}

}
