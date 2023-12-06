<?php

namespace App\Command\Services;

use App\Command\Interfaces\DataStorageInterface;
use App\Command\Interfaces\XmlImporterInterface;
use App\Entity\Product;
use Psr\Log\LoggerInterface;

class XmlImporter implements XmlImporterInterface
{

    private $dataStorage;

    private $logger;


    public function __construct(DataStorageInterface $dataStorage, LoggerInterface $logger)
    {
        $this->dataStorage = $dataStorage;
        $this->logger = $logger;
    }


    public function import(string $xmlContent): void
    {
        try {
            $xml = simplexml_load_string($xmlContent);

            foreach ($xml->item as $itemData) {
                $product = new Product();
                $product->setEntityId((int)$itemData->entity_id)
                    ->setCategoryName((string)$itemData->CategoryName)
                    ->setSku((string)$itemData->sku)
                    ->setName((string)$itemData->name)
                    ->setDescription((string)$itemData->description)
                    ->setShortdesc((string)$itemData->shortdesc)
                    ->setPrice((float)$itemData->price)
                    ->setLink((string)$itemData->link)
                    ->setImage((string)$itemData->image)
                    ->setBrand((string)$itemData->Brand)
                    ->setRating((int)$itemData->Rating)
                    ->setCaffeineType((string)$itemData->CaffeineType)
                    ->setCount((int)$itemData->Count)
                    ->setFlavored((string)$itemData->Flavored)
                    ->setSeasonal((string)$itemData->Seasonal)
                    ->setInstock((string)$itemData->Instock)
                    ->setFacebook((int)$itemData->Facebook)
                    ->setIsKCup((bool)$itemData->IsKCup);

                $this->dataStorage->save($product);
            }
        } catch (\Exception $e) {
            $this->logger->error('Error importing data from XML: ' . $e->getMessage());
        }
    }

}