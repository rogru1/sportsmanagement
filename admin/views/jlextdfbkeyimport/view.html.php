<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      view.html.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage jlextdfbkeyimport
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/**
 * sportsmanagementViewjlextdfbkeyimport
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2013
 * @access public
 */
class sportsmanagementViewjlextdfbkeyimport extends sportsmanagementView {

    /**
     * sportsmanagementViewjlextdfbkeyimport::init()
     * 
     * @return
     */
    public function init() {
        $tpl = '';
        
        if ( $this->getLayout() == 'default' || $this->getLayout() == 'default_3' ) {
            $this->setLayout('default');
            $this->_displayDefault($tpl);
            return;
        }

        if ( $this->getLayout() == 'default_createdays' || $this->getLayout() == 'default_createdays_3' ) {
            $this->setLayout('default_createdays');
            $this->_displayDefaultCreatedays($tpl);
            return;
        }


        if ( $this->getLayout() == 'default_firstmatchday' || $this->getLayout() == 'default_firstmatchday_3' ) {
            $this->setLayout('default_firstmatchday');
            $this->_displayDefaultFirstMatchday($tpl);
            return;
        }

        if ( $this->getLayout() == 'default_savematchdays' || $this->getLayout() == 'default_savematchdays_3' ) {
            $this->setLayout('default_savematchdays');
            $this->_displayDefaultSaveMatchdays($tpl);
            return;
        }
    }

    /**
     * sportsmanagementViewjlextdfbkeyimport::_displayDefault()
     * 
     * @param mixed $tpl
     * @return void
     */
    function _displayDefault($tpl) {
        //$app = JFactory::getApplication();
//		$jinput = $app->input;
//		$option = $jinput->getCmd('option');

//        $db = sportsmanagementHelper::getDBConnection();
//		$uri 	= JFactory::getURI();
//		$user 	= JFactory::getUser();
//		$model	= $this->getModel();
        //get the project
//		$projectid = $model->getProject();
//		$this->assignRef( 'projectid',		$projectid );

if (empty($this->project_id)) {
        $this->project_id = $this->app->getUserState("$this->option.pid", '0');
}

        $istable = $this->model->checkTable();

        if (empty($this->project_id)) {
            JError::raiseWarning(500, JText::_('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_1'));
            $this->app->redirect('index.php?option=' . $this->option . '&view=projects');
        } else {
            // project selected. projectteams available ?
            //build the html options for projectteams
            if ($res = $this->model->getProjectteams($this->project_id)) {
                $projectteams[] = JHtml::_('select.option', '0', '- ' . JText::_('Select projectteams') . ' -');
                $projectteams = array_merge($projectteams, $res);
                $lists['projectteams'] = $projectteams;


                $dfbteams = count($projectteams) - 1;

                //$app->enqueueMessage(JText::_(get_class($this).' '.__FUNCTION__.'<br><pre>'.print_r($dfbteams,true).'</pre>'),'');

                if ($resdfbkey = $this->model->getDFBKey($dfbteams, 'FIRST')) {
                    $dfbday = array();
                    $dfbday = array_merge($dfbday, $resdfbkey);
                    $lists['dfbday'] = $dfbday;
                    unset($dfbday);

                    // matchdays available ?
                    if ($resmatchdays = $this->model->getMatchdays($this->project_id)) {

                        // matches available
                        if ($resmatches = $this->model->getMatches($this->project_id)) {
                            JError::raiseNotice(500, JText::_('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_2'));
                            JError::raiseWarning(500, JText::sprintf('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_7', $resmatches));
                            $this->app->redirect('index.php?option=' . $this->option . '&view=rounds');
                        } else {
//        JError::raiseWarning( 500, JText::_( 'COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_3' ) );
//        JError::raiseNotice( 500, JText::_( 'COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_4' ) );
                            $this->app->redirect('index.php?option=' . $this->option . '&view=jlextdfbkeyimport&layout=default_firstmatchday');
                        }
                    } else {
                        JError::raiseWarning(500, JText::_('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_3'));
                        JError::raiseNotice(500, JText::_('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_4'));
                        $this->app->redirect('index.php?option=' . $this->option . '&view=jlextdfbkeyimport&layout=default_createdays');
                    }
                } else {
                    $procountry = $this->model->getCountry($this->project_id);
                    //JError::raiseWarning( 500, JText::_( '[DFB-Key Tool] Error: No DFB-Key for '.$dfbteams.'  Teams available!' ) );
                    JError::raiseWarning(500, JText::sprintf('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_6', $dfbteams, JSMCountries::getCountryFlag($procountry), $procountry));
                    $this->app->redirect('index.php?option=' . $this->option . '&view=projects');
                }

                unset($projectteams);
            } else {
//    JError::raiseNotice( 500, JText::_( '[DFB-Key Tool] Notice: No Teams assigned!' ) );
                JError::raiseError(500, JText::_('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_5'));
                $this->app->redirect('index.php?option=' . $this->option . '&view=projectteams');
            }
        }
    }

    /**
     * sportsmanagementViewjlextdfbkeyimport::_displayDefaultCreatedays()
     * 
     * @param mixed $tpl
     * @return void
     */
    function _displayDefaultCreatedays($tpl) {
        $app = JFactory::getApplication();
        $jinput = $app->input;
        //$option = $jinput->getCmd('option');

        $db = sportsmanagementHelper::getDBConnection();

        if (version_compare(JSM_JVERSION, '4', 'eq')) {
            $uri = JUri::getInstance();
        } else {
            $uri = JFactory::getURI();
        }
        $user = JFactory::getUser();
        $model = $this->getModel();
        //$projectid =& $this->projectid;
        //get the project
        //echo '_displayDefaultCreatedays project -> '.$projectid.'<br>';

        $projectid = $app->getUserState("$this->option.pid", '0');
        ;
        $this->projectid = $projectid;

        if ($res = $model->getProjectteams($projectid)) {
            $projectteams[] = JHtml::_('select.option', '0', '- ' . JText::_('Select projectteams') . ' -');
            $projectteams = array_merge($projectteams, $res);
            //$lists['projectteams'] = $projectteams;


            $dfbteams = count($projectteams) - 1;
            if ($resdfbkey = $model->getDFBKey($dfbteams, 'ALL')) {
                /*
                  echo '<pre>';
                  print_r($resdfbkey);
                  echo '</pre>';
                 */
                $this->newmatchdays = $resdfbkey;
            }
            unset($projectteams);
        }

        $this->request_url = $uri->toString();

        // Get a refrence of the page instance in joomla
        $document = JFactory::getDocument();
        // Set toolbar items for the page
        $stylelink = '<link rel="stylesheet" href="' . JURI::root() . 'administrator/components/'.$this->option.'/assets/css/jlextusericons.css' . '" type="text/css" />' . "\n";
        $document->addCustomTag($stylelink);

        // Set toolbar items for the page
        JToolbarHelper::title(JText::_('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_MATCHDAY_INFO_1'), 'dfbkey');
        JToolBarHelper::back('JPREV','index.php?option='.$this->option.'&view=projects'); 
        JToolbarHelper::save('jlextdfbkeyimport.save', 'JTOOLBAR_SAVE');
        JToolbarHelper::divider();
        sportsmanagementHelper::ToolbarButtonOnlineHelp();
        JToolbarHelper::preferences($this->option);
    }

    /**
     * sportsmanagementViewjlextdfbkeyimport::_displayDefaultFirstMatchday()
     * 
     * @param mixed $tpl
     * @return void
     */
    function _displayDefaultFirstMatchday($tpl) {
        $app = JFactory::getApplication();
        $jinput = $app->input;
        //$option = $jinput->getCmd('option');

        $db = sportsmanagementHelper::getDBConnection();
        $uri = JFactory::getURI();
        $user = JFactory::getUser();
        $model = $this->getModel();

        $projectid = $app->getUserState("$this->option.pid", '0');
        ;

        if ($res = $model->getProjectteams($projectid)) {
            $projectteams[] = JHtml::_('select.option', '0', '- ' . JText::_('Select projectteams') . ' -');
            $projectteams = array_merge($projectteams, $res);
            $lists['projectteams'] = $projectteams;


            $dfbteams = count($projectteams) - 1;
            if ($resdfbkey = $model->getDFBKey($dfbteams, 'FIRST')) {
                $dfbday = array();
                $dfbday = array_merge($dfbday, $resdfbkey);
                $lists['dfbday'] = $dfbday;
                unset($dfbday);
            }
        }

        $this->lists = $lists;
        $this->dfbteams = $dfbteams;
        $this->request_url = $uri->toString();

        // Get a refrence of the page instance in joomla
        $document = JFactory::getDocument();
        // Set toolbar items for the page
        $stylelink = '<link rel="stylesheet" href="' . JURI::root() . 'administrator/components/'.$this->option.'/assets/css/jlextusericons.css' . '" type="text/css" />' . "\n";
        $document->addCustomTag($stylelink);

        // Set toolbar items for the page
        JToolbarHelper::title(JText::_('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_FIRST_MATCHDAY_INFO_1'), 'dfbkey');
        JToolBarHelper::back('JPREV','index.php?option='.$this->option.'&view=projects');
        JToolbarHelper::apply('jlextdfbkeyimport.apply', 'JTOOLBAR_APPLY');
        JToolbarHelper::divider();
        sportsmanagementHelper::ToolbarButtonOnlineHelp();
        JToolbarHelper::preferences($this->option);
    }

    /**
     * sportsmanagementViewjlextdfbkeyimport::_displayDefaultSaveMatchdays()
     * 
     * @param mixed $tpl
     * @return void
     */
    function _displayDefaultSaveMatchdays($tpl) {
        $app = JFactory::getApplication();
        $jinput = $app->input;
        //$option = $jinput->getCmd('option');

        $db = sportsmanagementHelper::getDBConnection();
        $uri = JFactory::getURI();
        $user = JFactory::getUser();
        $model = $this->getModel();

        $projectid = $app->getUserState("$this->option.pid", '0');
        $this->projectid = $projectid;
        $post = $input->post;
        $this->import = $model->getSchedule($post, $projectid);
        $this->request_url = $uri->toString();

        // Get a refrence of the page instance in joomla
        $document = JFactory::getDocument();
        // Set toolbar items for the page
        $stylelink = '<link rel="stylesheet" href="' . JURI::root() . 'administrator/components/'.$this->option.'/assets/css/jlextusericons.css' . '" type="text/css" />' . "\n";
        $document->addCustomTag($stylelink);

        // Set toolbar items for the page
        JToolbarHelper::title(JText::_('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_SAVE_MATCHDAY_INFO_1'), 'dfbkey');
        JToolBarHelper::back('JPREV','index.php?option='.$this->option.'&view=projects');
        JToolbarHelper::save('jlextdfbkeyimport.insert', 'JTOOLBAR_SAVE');
        JToolbarHelper::divider();
        sportsmanagementHelper::ToolbarButtonOnlineHelp();
        JToolbarHelper::preferences($this->option);
    }

}

?>