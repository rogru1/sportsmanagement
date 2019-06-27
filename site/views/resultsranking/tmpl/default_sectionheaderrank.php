<?php 
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
 * @version   1.0.05
 * @file      default_sectionheaderrank.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 * @package   sportsmanagement
 * @subpackage resultsranking
 */

defined( '_JEXEC' ) or die( 'Restricted access' ); 
use Joomla\CMS\Language\Text;
?>

<!-- START: Contentheading -->
<table class="table">
    <tr>
        <td class="contentheading">
            <?php
            echo Text::_('COM_SPORTSMANAGEMENT_RANKING_PAGE_TITLE' );
            ?>
        </td>
    </tr>
</table>
<br />
<!-- END: Contentheading -->