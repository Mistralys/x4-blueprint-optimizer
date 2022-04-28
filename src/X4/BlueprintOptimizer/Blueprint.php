<?php

declare(strict_types=1);

namespace Mistralys\X4\BlueprintOptimizer;

use AppUtils\FileHelper;

class Blueprint
{
    private string $xmlFile;
    private bool $parsed = false;
    private array $data;

    public function __construct(string $xmlFile)
    {
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
        return 'https://yoyo.com';
    }

    public function getLabel() : string
    {
        $this->parse();

        return $this->data['label'];
    }

    private function parse() : void
    {
        if($this->parsed)
        {
            return;
        }

        $this->parsed = true;

        $parser = new BlueprintParser($this);
        $this->data = $parser->getData();
    }
}
