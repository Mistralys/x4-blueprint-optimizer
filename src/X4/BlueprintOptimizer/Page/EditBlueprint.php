<?php
/**
 * @package X4BlueprintOptimizer
 * @subpackage UserInterface
 * @see \Mistralys\X4\BlueprintOptimizer\Pages\EditBlueprint
 */

declare(strict_types=1);

namespace Mistralys\X4\BlueprintOptimizer\Pages;

use Mistralys\X4\BlueprintOptimizer\Blueprint;
use Mistralys\X4\BlueprintOptimizer\Collection;
use Mistralys\X4\BlueprintOptimizer\UI\Page;use function AppLocalize\pt;
use function AppUtils\t;

/**
 * @package X4BlueprintOptimizer
 * @subpackage Pages
 * @author Sebastian Mordziol <s.mordziol@mistralys.eu>
 */
class EditBlueprint extends Page
{
    public const URL_NAME = 'EditBlueprint';

    private Collection $collection;
    private Blueprint $blueprint;

    public function getTitle() : string
    {
        return $this->blueprint->getLabel();
    }

    public function getNavTitle() : string
    {
        return t('Edit');
    }

    public function getSubtitle(): string
    {
        return '';
    }

    public function getAbstract(): string
    {
        return '';
    }

    protected function getURLParams() : array
    {
        return array();
    }

    protected function preRender() : void
    {
        $this->collection = $this->optimizer->getBlueprints();
        $blueprint = $this->collection->getByRequest();

        if($blueprint === null)
        {
            $this->redirect($this->collection->getURLList());
        }

        $this->blueprint = $blueprint;
    }

    protected function _render() : void
    {
        ?>
        <p>
            <?php pt('The blueprint contains %1$s modules:', $this->blueprint->countModules()) ?>
        </p>
        <table class="table">
            <thead>
                <tr>
                    <th><?php pt('Label') ?></th>
                    <th><?php pt('Race') ?></th>
                    <th><?php pt('Category') ?></th>
                </tr>
            </thead>
            <tbody>
            <?php
            $modules = $this->blueprint->getModules();

            foreach($modules as $module)
            {
                ?>
                <tr>
                    <td><?php echo $module->getLabel() ?></td>
                    <td><?php echo $module->getRace()->getLabel() ?></td>
                    <td><?php echo $module->getCategory()->getLabel() ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <?php
    }
}
