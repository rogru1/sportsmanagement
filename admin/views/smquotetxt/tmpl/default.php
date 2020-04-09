<?php
/**
 *
 * SportsManagement ein Programm zur Verwaltung für alle Sportarten
 *
 * @version    1.0.05
 * @package    Sportsmanagement
 * @subpackage smquotetxt
 * @file       default.php
 * @author     diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright  Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

.
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

// HTMLHelper::addIncludePath(JPATH_COMPONENT.'/helpers/html');


HTMLHelper::_('behavior.keepalive');

$templatesToLoad = array('footer', 'listheader');
sportsmanagementHelper::addTemplatePaths($templatesToLoad, $this);

?>
    <script type="text/javascript">
        Joomla.submitbutton = function (task) {
            if (task == 'source.cancel' || document.formvalidator.isValid(document.id('source-form'))) {
				<?php echo $this->form->getField('source')->save(); ?>
                Joomla.submitform(task, document.getElementById('source-form'));
            } else {
                alert('<?php echo $this->escape(Text::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
            }
        }
    </script>

    <form action="<?php echo Route::_('index.php?option=com_sportsmanagement&layout=default'); ?>" method="post"
          name="adminForm" id="source-form" class="form-validate">

        <fieldset class="adminform">
            <legend></legend>

			<?php echo $this->form->getLabel('source'); ?>
            <div class="clr"></div>
            <div class="editor-border">
				<?php echo $this->form->getInput('source'); ?>
            </div>
            <input type="hidden" name="task" value=""/>
			<?php echo HTMLHelper::_('form.token'); ?>
        </fieldset>


		<?php echo $this->form->getInput('filename'); ?>

    </form>
<?PHP
echo "<div>";
echo $this->loadTemplate('footer');
echo "</div>";
