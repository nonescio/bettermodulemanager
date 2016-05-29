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

/**
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$text = JText::_('JTOOLBAR_NEW');
?>
<button onclick="location.href='index.php?option=com_bettermodules&amp;view=select'" class="btn btn-small btn-success" title="<?php echo $text; ?>">
	<span class="icon-plus icon-white"></span>
	<?php echo $text; ?>
</button>
