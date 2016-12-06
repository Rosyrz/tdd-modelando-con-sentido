<?php


namespace rosyrz\Mcs\CalculateShirtPrice\Repositories;


use rosyrz\Mcs\CalculateShirtPrice\Exceptions\FabricNotFoundException;

/**
 * Class FabricArrayRepository
 * @package rosyrz\Mcs\CalculateShirtPrice\Repositories
 */
class FabricArrayRepository implements FabricRepositoryInterface
{
    /**
     * @var array
     */
    protected $Sku = [
        'RET490' => 2500,
        'RET480' => 2000,
        'RET470' => 3000,
    ];


    /**
     * @param $fabriSku
     * @return mixed
     * @throws FabricNotFoundException
     */
    public function getFabricPrice($fabriSku)
    {
       if (isset($this->Sku[$fabriSku])){
           return $this->Sku[$fabriSku];
       }
        throw new FabricNotFoundException;
    }

}