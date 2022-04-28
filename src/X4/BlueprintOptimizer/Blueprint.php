<?php

declare(strict_types=1);

namespace Mistralys\X4\BlueprintOptimizer;

use AppUtils\FileHelper;
use Mistralys\X4\BlueprintOptimizer\Blueprint\Module;
use Mistralys\X4\BlueprintOptimizer\Pages\EditBlueprint;

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
}
