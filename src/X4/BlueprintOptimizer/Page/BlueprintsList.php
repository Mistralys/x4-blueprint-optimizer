<?php
/**
 * @package X4BlueprintOptimizer
 * @subpackage UserInterface
 * @see \Mistralys\X4\BlueprintOptimizer\Pages\BlueprintsList
 */

declare(strict_types=1);

namespace Mistralys\X4\BlueprintOptimizer\Pages;

use Mistralys\X4\BlueprintOptimizer\Blueprint;
use Mistralys\X4\BlueprintOptimizer\UI\Page;
use function AppUtils\t;

/**
 * @package X4BlueprintOptimizer
 * @subpackage Pages
 * @author Sebastian Mordziol <s.mordziol@mistralys.eu>
 */
class BlueprintsList extends Page
{
    public const URL_NAME = 'BlueprintsList';

    public function getTitle(): string
    {
        return t('Available blueprints');
    }

    public function getNavItems(): array
    {
        return array();
    }

    protected function getURLParams() : array
    {
        return array();
    }

    protected function preRender() : void
    {

    }

    protected function _render(): void
    {
        $blueprints = $this->getApplication()->getBlueprints();

        $grid = $this->ui->createDataGrid();

        $grid->addColumn('label', t('Label'))
            ->useObjectValues()->fetchByMethod(array(Blueprint::class, 'getLabel'))
            ->decorateWith()->linkByMethod(array(Blueprint::class, 'getURLEdit'));

        $grid->addColumn('name', t('File name'))
            ->useObjectValues()->fetchByMethod(array(Blueprint::class, 'getFileName'));

        $grid->addRowsFromObjects($blueprints->getAll());

        echo $grid->render();
    }
}
