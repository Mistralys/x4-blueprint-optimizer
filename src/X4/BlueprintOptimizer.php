<?php
/**
 * @package X4BlueprintOptimizer
 * @subpackage Application
 * @see \Mistralys\X4\BlueprintOptimizer
 */

declare(strict_types=1);

namespace Mistralys\X4;

use AppUtils\FileHelper;
use Mistralys\X4\BlueprintOptimizer\Collection;
use Mistralys\X4\BlueprintOptimizer\Pages\BlueprintsList;
use Mistralys\X4\UI\UserInterface;

/**
 * @package X4BlueprintOptimizer
 * @subpackage Application
 * @author Sebastian Mordziol <s.mordziol@mistralys.eu>
 */
class BlueprintOptimizer extends X4Application
{
    private string $blueprintsFolder;
    private ?Collection $collection;

    public function __construct(string $blueprintsFolder)
    {
        $this->blueprintsFolder = $blueprintsFolder; 
    }

    public function getTitle() : string
    {
        return 'X4 Blueprint optimizer';
    }

    public function getBlueprintsFolder() : string
    {
        return $this->blueprintsFolder;
    }

    public function getBlueprints() : Collection
    {
        if(isset($this->collection))
        {
            return $this->collection;
        }

        $collection = new Collection($this->getBlueprintsFolder());

        $this->collection = $collection;

        return $collection;
    }

    public function registerPages(UserInterface $ui) : void
    {
        $ui->registerPage(BlueprintsList::URL_NAME, BlueprintsList::class);
    }

    public function getDefaultPageID() : ?string
    {
        return BlueprintsList::URL_NAME;
    }

    public function getVersion() : string
    {
        return FileHelper::readContents(__DIR__.'/../../VERSION');
    }
}
