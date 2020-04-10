<?php
/**
 *
 * SportsManagement ein Programm zur Verwaltung für alle Sportarten
 *
 * @version    1.0.05
 * @package    Sportsmanagement
 * @subpackage predictionentry
 * @file       default_view_welcome.php
 * @author     diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright  Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die(Text::_('Restricted access'));

use Joomla\CMS\Language\Text;

?><p><?php
	echo Text::_('COM_SPORTSMANAGEMENT_PRED_ENTRY_WELCOME_INFO_01');
	?></p><p><?php
	echo Text::sprintf('COM_SPORTSMANAGEMENT_PRED_ENTRY_WELCOME_INFO_02', $this->config['ownername'], '<b>' . $this->websiteName . '</b>');
	?></p>
<hr><br/>
