<?php
/**
 * @package X4BlueprintOptimizer
 * @subpackage Application
 * @see \Mistralys\X4\BlueprintOptimizer
 */

declare(strict_types=1);

namespace Mistralys\X4;

use AppUtils\FileHelper;
use AppUtils\FileHelper_Exception;
use Mistralys\ChangelogParser\ChangelogParser;
use Mistralys\X4\BlueprintOptimizer\Collection;
use Mistralys\X4\BlueprintOptimizer\Pages\BlueprintsList;
use Mistralys\X4\BlueprintOptimizer\Pages\EditBlueprint;
use Mistralys\X4\UI\UserInterface;
use function AppUtils\t;

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
        parent::__construct();

        $this->blueprintsFolder = $blueprintsFolder;
    }

    public function getTitle() : string
    {
        return t('X4 Blueprint optimizer');
    }

    public function getBlueprintsFolder() : string
    {
        return $this->blueprintsFolder;
    }

    /**
     * @throws FileHelper_Exception
     */
    public function getBlueprints() : Collection
    {
        if(isset($this->collection))
        {
            return $this->collection;
        }

        $collection = new Collection($this, $this->getBlueprintsFolder());

        $this->collection = $collection;

        return $collection;
    }

    public function registerPages(UserInterface $ui) : void
    {
        $ui->registerPage(BlueprintsList::URL_NAME, BlueprintsList::class);
        $ui->registerPage(EditBlueprint::URL_NAME, EditBlueprint::class);
    }

    public function getDefaultPageID() : ?string
    {
        return BlueprintsList::URL_NAME;
    }

    private ?string $version = null;

    public function getVersion() : string
    {
        if(isset($this->version))
        {
            return $this->version;
        }

        $this->version = ChangelogParser::parseMarkdownFile(__DIR__.'/../../changelog.md')
            ->requireLatestVersion()
            ->getNumber();

        return $this->version;
    }
}
