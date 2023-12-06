<?php

namespace App\Command\Interfaces;

interface XmlImporterInterface
{

    public function import(string $xmlContent): void;

}