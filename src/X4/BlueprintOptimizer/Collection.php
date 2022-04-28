<?php
/**
 * @package X4BlueprintsOptimizer
 * @subpackage Blueprints
 * @see \Mistralys\X4\BlueprintOptimizer\Collection
 */

declare(strict_types=1);

namespace Mistralys\X4\BlueprintOptimizer;

use AppUtils\FileHelper;
use AppUtils\FileHelper_Exception;
use Mistralys\X4\BlueprintOptimizer;
use Mistralys\X4\BlueprintOptimizer\Pages\BlueprintsList;
use Mistralys\X4\UI\UserInterface;
use Mistralys\X4\UserInterface\UIException;

/**
 * Handles the available blueprint collection, as stored
 * in the game folder. Offers methods to retrieve blueprint
 * instances for all files found in the folder.
 *
 * @package X4BlueprintsOptimizer
 * @subpackage Blueprints
 */
class Collection
{
    public const ERROR_UNKNOWN_BLUEPRINT_ID = 106101;

    /**
     * @var Blueprint[]
     */
    private array $blueprints = array();
    private BlueprintOptimizer $app;

    /**
     * @param BlueprintOptimizer $app
     * @param string $blueprintsFolder
     * @throws FileHelper_Exception
     */
    public function __construct(BlueprintOptimizer $app, string $blueprintsFolder)
    {
        $this->app = $app;

        $this->load($blueprintsFolder);
    }

    public function getApp() : BlueprintOptimizer
    {
        return $this->app;
    }

    /**
     * @return Blueprint[]
     */
    public function getAll() : array
    {
        return $this->blueprints;
    }

    /**
     * @param array<string,string> $params
     * @return string
     * @throws UIException
     */
    public function getURLList(array $params=array()) : string
    {
        return $this->app
            ->getUI()
            ->createPage(BlueprintsList::URL_NAME)
            ->getURL($params);
    }

    /**
     * @param string $blueprintsFolder
     * @return void
     * @throws FileHelper_Exception
     */
    private function load(string $blueprintsFolder) : void
    {
        $files = FileHelper::createFileFinder($blueprintsFolder)
            ->includeExtension('xml')
            ->setPathmodeAbsolute()
            ->getAll();

        foreach($files as $filePath)
        {
            $this->blueprints[] = new Blueprint($this, $filePath);
        }
    }

    /**
     * @return Blueprint|null
     * @throws OptimizerException
     */
    public function getByRequest() : ?Blueprint
    {
        $id = (string)$this->app->getUI()
            ->getRequest()
            ->registerParam(Blueprint::REQUEST_PARAM_BLUEPRINT_ID)
            ->get();

        if(!empty($id) && $this->idExists($id))
        {
            return $this->getByID($id);
        }

        return null;
    }

    public function idExists(string $id) : bool
    {
        foreach($this->blueprints as $blueprint)
        {
            if($blueprint->getID() === $id)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $id
     * @return Blueprint
     *
     * @throws OptimizerException
     * @see Collection::ERROR_UNKNOWN_BLUEPRINT_ID
     */
    public function getByID(string $id) : Blueprint
    {
        foreach($this->blueprints as $blueprint)
        {
            if($blueprint->getID() === $id)
            {
                return $blueprint;
            }
        }

        throw new OptimizerException(
            'Blueprint ID not found.',
            sprintf(
                'Unknown blueprint ID [%s].',
                $id
            ),
            self::ERROR_UNKNOWN_BLUEPRINT_ID
        );
    }
}
