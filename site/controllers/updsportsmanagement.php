<?php
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
 * @version   1.0.05
 * @file      updsportsmanagement.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage controllers
 */

// No direct access.
defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Language\Text;

/**
 * sportsmanagementControllerUpdsportsmanagement
 * 
 * @package 
 * @author diddi
 * @copyright 2014
 * @version $Id$
 * @access public
 */
class sportsmanagementControllerUpdsportsmanagement extends FormController
{

	/**
	 * sportsmanagementControllerUpdsportsmanagement::getModel()
	 * 
	 * @param string $name
	 * @param string $prefix
	 * @param mixed $config
	 * @return
	 */
	public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, array('ignore_request' => false));
	}

	/**
	 * sportsmanagementControllerUpdsportsmanagement::submit()
	 * 
	 * @return
	 */
	public function submit()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app	= Factory::getApplication();
		$model	= $this->getModel('updsportsmanagement');

		// Get the data from the form POST
		$data = Factory::getApplication()->input->getVar('jform', array(), 'post', 'array');

        // Now update the loaded data to the database via a function in the model
        $upditem	= $model->updItem($data);

    	// check if ok and display appropriate message.  This can also have a redirect if desired.
        if ($upditem) {
            echo "<h2>Updated Greeting has been saved</h2>";
        } else {
            echo "<h2>Updated Greeting failed to be saved</h2>";
        }

		return true;
	}

}
