<?php

declare(strict_types=1);

namespace Mistralys\X4\BlueprintOptimizer;

use AppUtils\FileHelper;
use DateTime;
use Mistralys\X4\BlueprintOptimizer\Blueprint\Module;
use Mistralys\X4\BlueprintOptimizer\Pages\EditBlueprint;
use Mistralys\X4\Database\Modules\ModuleCategories;
use Mistralys\X4\Database\Races\RaceDef;

class Blueprint
{
    public const REQUEST_PARAM_BLUEPRINT_ID = 'blueprint_id';

    private string $xmlFile;
    private bool $parsed = false;
    private Collection $collection;

    /**
     * @var array<string,string>
     */
    private array $data;

    /**
     * @var Module[]
     */
    private array $modules = array();

    public function __construct(Collection $collection, string $xmlFile)
    {
        $this->collection = $collection;
        $this->xmlFile = $xmlFile;
    }

    public function getFileName() : string
    {
        return FileHelper::getFilename($this->xmlFile);
    }

    public function getDateModified() : DateTime
    {
        return FileHelper::getModifiedDate($this->getPath());
    }

    public function getRacesList() : string
    {
        $list = array();
        $races = $this->getRaces(false);

        foreach($races as $race)
        {
            $list[] = $race->getLabel();
        }

        return implode(', ', $list);
    }

    /**
     * @return RaceDef[]
     */
    public function getRaces(bool $includeGeneric=true) : array
    {
        $result = array();
        $modules = $this->getModules();

        foreach($modules as $module)
        {
            $race = $module->getRace();
            $id = $race->getID();

            if(!$includeGeneric && $race->isGeneric())
            {
                continue;
            }

            if(!isset($result[$id]))
            {
                $result[$id] = $race;
            }
        }

        return array_values($result);
    }

    public function getPath() : string
    {
        return $this->xmlFile;
    }

    public function getURLEdit(array $params=array()) : string
    {
        $page = $this->collection->getApp()->getUI()->createPage(EditBlueprint::URL_NAME);

        $params[self::REQUEST_PARAM_BLUEPRINT_ID] = $this->getID();

        return $page->getURL($params);
    }

    public function getID() : string
    {
        $this->parse();

        return $this->data['id'];
    }

    public function getLabel() : string
    {
        $this->parse();

        return $this->data['name'];
    }

    private function parse() : void
    {
        if($this->parsed)
        {
            return;
        }

        $this->parsed = true;

        $parser = new BlueprintParser($this);
        $data = $parser->getData();

        $this->data = $data['plan']['@attributes'];

        if(!isset($data['plan']['entry']))
        {
            return;
        }

        foreach($data['plan']['entry'] as $moduleData)
        {
            $this->modules[] = new Module($this, $moduleData);
        }
    }

    /**
     * @return Module[]
     */
    public function getModules() : array
    {
        return $this->modules;
    }

    public function countModules() : int
    {
        return count($this->modules);
    }

    public function countProductions() : int
    {
        return count($this->getProductions());
    }

    /**
     * @return Module[]
     */
    public function getProductions() : array
    {
        $result = array();
        $modules = $this->getModules();

        foreach ($modules as $module)
        {
            if($module->isProduction())
            {
                $result[] = $module;
            }
        }

        return $result;
    }

    public function countStorages() : int
    {
        return count($this->getStorages());
    }

    /**
     * @return Module[]
     */
    public function getStorages() : array
    {
        $modules = $this->getModules();
        $result = array();

        foreach($modules as $module)
        {
            if($module->getCategory()->getID() === ModuleCategories::CATEGORY_STORAGE)
            {
                $result[] = $module;
            }
        }

        return $result;
    }
}
