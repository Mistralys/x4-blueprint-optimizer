<?php
/**
 * @package X4BlueprintsOptimizer
 * @subpackage UserInterface
 * @see \Mistralys\X4\BlueprintOptimizer\UI\Page
 */

declare(strict_types=1);

namespace Mistralys\X4\BlueprintOptimizer\UI;

use Mistralys\X4\BlueprintOptimizer;
use Mistralys\X4\UI\BasePage;

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
}
