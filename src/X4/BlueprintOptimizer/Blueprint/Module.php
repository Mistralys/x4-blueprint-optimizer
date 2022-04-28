<?php

declare(strict_types=1);

namespace Mistralys\X4\BlueprintOptimizer\Blueprint;

use Mistralys\X4\BlueprintOptimizer\Blueprint;
use Mistralys\X4\Database\Modules\ModuleCategory;
use Mistralys\X4\Database\Modules\ModuleDef;
use Mistralys\X4\Database\Modules\ModuleDefs;
use Mistralys\X4\Database\Races\RaceDef;

class Module
{
    private Blueprint $blueprint;
    private int $index;
    private string $moduleID;
    private string $connection = '';

    /**
     * @var array<string,string>
     */
    private array $attributes;

    /**
     * @var array{x:float,y:float,z:float}
     */
    private array $position = array(
        'x' => 0,
        'y' => 0,
        'z' => 0
    );

    /**
     * @var array{yaw:float,pitch:float,roll:float}|NULL
     */
    private array $rotation = array(
        'yaw' => 0,
        'pitch' => 0,
        'roll' => 0
    );

    /**
     * @var array{index:string,connection:string}|null
     */
    private ?array $predecessor = null;
    private ModuleDef $moduleDef;

    public function __construct(Blueprint $blueprint, array $xmlData)
    {
        $this->blueprint = $blueprint;

        $this->parseAttributes($xmlData['@attributes']);

        $this->moduleDef = ModuleDefs::getInstance()->getByID($this->getID());

        if(isset($xmlData['offset']['position']['@attributes']))
        {
            $this->parsePosition($xmlData['offset']['position']['@attributes']);
        }

        if(isset($xmlData['offset']['rotation']['@attributes']))
        {
            $this->parseRotation($xmlData['offset']['rotation']['@attributes']);
        }
    }

    public function getBlueprint() : Blueprint
    {
        return $this->blueprint;
    }

    /**
     * @param array<string,string> $attributes
     * @return void
     */
    private function parseAttributes(array $attributes) : void
    {
        $this->index = (int)$attributes['index'];
        $this->moduleID = $attributes['macro'];

        if(isset($attributes['connection']))
        {
            $this->connection = $attributes['connection'];
        }
    }

    /**
     * @param array<string,string> $position
     * @return void
     */
    private function parsePosition(array $position) : void
    {
        $this->position['x'] = (float)$position['x'];
        $this->position['z'] = (float)$position['z'];

        if(isset($position['y']))
        {
            $this->position['y'] = (float)$position['y'];
        }
    }

    private function parseRotation(array $rotation) : void
    {

    }

    public function getIndex() : int
    {
        return $this->index;
    }

    public function getID() : string
    {
        return $this->moduleID;
    }

    public function getRace() : RaceDef
    {
        return $this->moduleDef->getRace();
    }

    public function getCategory() : ModuleCategory
    {
        return $this->moduleDef->getCategory();
    }

    public function getLabel() : string
    {
        return $this->moduleDef->getLabel();
    }
}
