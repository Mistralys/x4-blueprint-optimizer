<?php
/**
 * @package X4BlueprintsOptimizer
 * @subpackage UserInterface
 * @see \Mistralys\X4\BlueprintOptimizer\UI\Page
 */

declare(strict_types=1);

namespace Mistralys\X4\BlueprintOptimizer\UI;

use Mistralys\X4\BlueprintOptimizer;
use Mistralys\X4\BlueprintOptimizer\Pages\BlueprintsList;
use Mistralys\X4\UI\Page\BasePage;
use Mistralys\X4\UI\Page\PageNavItem;
use Mistralys\X4\UnexpectedClassException;
use Mistralys\X4\UserInterface\UIException;

/**
 * @package X4BlueprintsOptimizer
 * @subpackage UserInterface
 * @method BlueprintOptimizer getApplication()
 */
abstract class Page extends BasePage
{
    protected BlueprintOptimizer $optimizer;

    protected function init() : void
    {
        $this->optimizer = $this->getApplication();
    }

    public function getNavItems() : array
    {
        return array(
            new PageNavItem($this->getPageBlueprintsList())
        );
    }

    /**
     * @return BlueprintsList
     * @throws UnexpectedClassException
     * @throws UIException
     */
    public function getPageBlueprintsList() : BlueprintsList
    {
        $page = $this->ui->createPage(BlueprintsList::URL_NAME);
        if($page instanceof BlueprintOptimizer\Pages\BlueprintsList)
        {
            return $page;
        }

        throw new UnexpectedClassException(BlueprintOptimizer\Pages\BlueprintsList::class, $page);
    }
}
