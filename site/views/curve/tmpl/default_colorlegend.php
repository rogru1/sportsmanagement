<?php 
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
 * @version   1.0.05
 * @file      default_colorlegend.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 * @package   sportsmanagement
 * @subpackage curve
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<!-- colors legend -->
<?php
if ($this->config['show_colorlegend'])
{
	?>
	<table class="table">
		<tr>
			<?php
			sportsmanagementHelper::showColorsLegend($this->colors,$this->divisions);
			?>
		</tr>
	</table>
	<br />
	<?php
}
?>