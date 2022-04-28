<?php

declare(strict_types=1);

namespace Mistralys\X4\BlueprintOptimizer;

use AppUtils\FileHelper;

class Collection
{
    /**
     * @var Blueprint[]
     */
    private array $blueprints = array();

    public function __construct(string $blueprintsFolder)
    {
        $this->load($blueprintsFolder);
    }

    /**
     * @return Blueprint[]
     */
    public function getAll() : array
    {
        return $this->blueprints;
    }

    private function load(string $blueprintsFolder) : void
    {
        $files = FileHelper::createFileFinder($blueprintsFolder)
            ->includeExtension('xml')
            ->setPathmodeAbsolute()
            ->getAll();

        foreach($files as $filePath)
        {
            $this->blueprints[] = new Blueprint($filePath);
        }
    }
}
