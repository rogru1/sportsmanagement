<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      view.html.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage club
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Uri\Uri; 
use Joomla\CMS\Language\Text;
use Joomla\CMS\Environment\Browser;
/**
 * sportsmanagementViewClub
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementViewClub extends sportsmanagementView
{
	
	
	/**
	 * sportsmanagementViewClub::init()
	 * 
	 * @return
	 */
	public function init ()
	{
		
        $starttime = microtime(); 
        $this->tmpl	= $this->jinput->get('tmpl');
 
		/**
         * Check for errors.
         */
		if (count($errors = $this->get('Errors'))) 
		{
			$this->app->enqueueMessage(implode("\n",$errors));
			return false;
		}
        
        if ( $this->item->latitude != 255 )
        {
            $this->googlemap = true;
        }
        else
        {
            $this->googlemap = false;
        }
       

        if ( $this->item->id )
        {
            // alles ok
            if ( $this->item->founded == '0000-00-00' )
            {
                $this->item->founded = '';
                $this->form->setValue('founded','');
            }
            if ( $this->item->dissolved == '0000-00-00' )
            {
                $this->item->dissolved = '';
                $this->form->setValue('dissolved','');
            }
            
        }
        else
        {
            $this->form->setValue('founded', '');
            $this->form->setValue('dissolved', '');
        }
        
        if ( $this->item->latitude == 255 )
        {
            $this->app->enqueueMessage(JText::_('COM_SPORTSMANAGEMENT_NO_GEOCODE'),'Error');
            $this->map = false;
        }
        else
        {
            $this->map = true;
        }
		
		$extended = sportsmanagementHelper::getExtended($this->item->extended, 'club');
		$this->extended	= $extended;
        $extendeduser = sportsmanagementHelper::getExtendedUser($this->item->extendeduser, 'club');		
		$this->extendeduser	= $extendeduser;
        
        $this->checkextrafields	= sportsmanagementHelper::checkUserExtraFields();
        $lists = array();
        if ( $this->checkextrafields )
        {
            $lists['ext_fields'] = sportsmanagementHelper::getUserExtraFields($this->item->id);
        }
        
        /**
         * die mannschaften zum verein
         */
        if ( $this->item->id )
        {
            $this->teamsofclub = $this->model->teamsofclub($this->item->id);
        }
        
        $this->lists = $lists;
        
$this->document->addScript((Browser::getInstance()->isSSLConnection() ? "https" : "http") . '://maps.googleapis.com/maps/api/js?libraries=places&language=de');
$this->document->addScript(Uri::base() . 'components/'.$this->option.'/assets/js/geocomplete.js');

        if( version_compare(JSM_JVERSION,'4','eq') ) 
{
	}
		else
		{
$this->document->addScript(Uri::base() . 'components/'.$this->option.'/views/club/tmpl/edit.js');
		}
                            
	}
 
	
	/**
	 * sportsmanagementViewClub::addToolBar()
	 * 
	 * @return void
	 */
	protected function addToolBar() 
	{
		$this->jinput->set('hidemainmenu', true);
		$isNew = $this->item->id ? $this->title = Text::_('COM_SPORTSMANAGEMENT_ADMIN_CLUB_EDIT') : $this->title = Text::_('COM_SPORTSMANAGEMENT_ADMIN_CLUB_ADD_NEW');
        $this->icon = 'club';
       
        parent::addToolbar();
	}
    
	
}
