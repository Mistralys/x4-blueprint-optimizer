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

/**
 * @package X4BlueprintOptimizer
 * @subpackage UserInterface
 * @author Sebastian Mordziol <s.mordziol@mistralys.eu>
 */
class BlueprintsList extends Page
{
    public const URL_NAME = 'BlueprintsList';

    public function getTitle(): string
    {
        return 'Available blueprints';
    }

    public function getNavItems(): array
    {
        return array();
    }

    protected function getURLParams() : array
    {
        return array();
    }

    protected function _render(): void
    {
        $blueprints = $this->getApplication()->getBlueprints();

        $grid = $this->ui->createDataGrid();
        $grid->addColumn('label', 'File name')
            ->useObjectValues()->fetchByMethod(array(Blueprint::class, 'getFileName'))
            ->decorateWith()->linkByMethod(array(Blueprint::class, 'getURLEdit'));

        $grid->addRowsFromObjects($blueprints->getAll());

        echo $grid->render();
    }
}
