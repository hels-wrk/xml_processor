<?php

namespace App\Command\Interfaces;

use App\Entity\Product;

interface DataStorageInterface
{

    public function save(Product $product): void;

}