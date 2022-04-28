<?php

declare(strict_types=1);

namespace Mistralys\X4\BlueprintOptimizer;

use AppUtils\XMLHelper;

class BlueprintParser
{
    private Blueprint $blueprint;

    public function __construct(Blueprint $blueprint)
    {
        $this->blueprint = $blueprint;
    }

    public function getData() : array
    {
        return XMLHelper::convertFile($this->blueprint->getPath())->toArray();
    }
}
