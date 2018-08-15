<?php 
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
 * @version   1.0.05
 * @file      default_stats.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage matchreport
 */

defined( '_JEXEC' ) or die( 'Restricted access' ); 
use Joomla\CMS\Language\Text;
?>

<!-- START: game stats -->
<?php
if (!empty($this->matchplayerpositions ))
{
	$hasMatchPlayerStats = false;
	$hasMatchStaffStats = false;
	foreach ( $this->matchplayerpositions as $pos )
	{
		if(isset($this->stats[$pos->position_id]) && count($this->stats[$pos->position_id])>0) {
			foreach ($this->stats[$pos->position_id] as $stat) {
				if ($stat->showInSingleMatchReports() && $stat->showInMatchReport()) {
					$hasMatchPlayerStats = true;
					break;
				}
			}
		}
	}	
	foreach ( $this->matchstaffpositions as $pos )
	{
		if(isset($this->stats[$pos->position_id]) && count($this->stats[$pos->position_id])>0) {
			foreach ($this->stats[$pos->position_id] as $stat) {
				if ($stat->showInSingleMatchReports() && $stat->showInMatchReport()) {
					$hasMatchStaffStats = true;
				}
			}
		}
	}
	if($hasMatchPlayerStats || $hasMatchStaffStats) :
	?>

	<h2><?php echo Text::_('COM_SPORTSMANAGEMENT_MATCHREPORT_STATISTICS'); ?></h2>
	
		<?php
// Define tabs options for version of Joomla! 4.0
$tabsOptions = array(
    "active" => "tabstats1_id" // It is the ID of the active tab.
);
echo JHtml::_('bootstrap.startTabSet', 'ID-Tabs-Group-Stats', $tabsOptions);
echo JHtml::_('bootstrap.addTab', 'ID-Tabs-Group-Stats', 'tabstats1_id', Text::_($this->team1->name));
echo $this->loadTemplate('stats_home');
echo JHtml::_('bootstrap.endTab');
echo JHtml::_('bootstrap.addTab', 'ID-Tabs-Group-Stats', 'tabstats2_id', Text::_($this->team2->name));
echo $this->loadTemplate('stats_away');
echo JHtml::_('bootstrap.endTab');
echo JHtml::_('bootstrap.endTabSet', 'ID-Tabs-Group-Stats');
    
	endif;
}
?>
<!-- END of game stats -->
