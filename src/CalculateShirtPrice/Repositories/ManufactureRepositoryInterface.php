<?php

namespace rosyrz\Mcs\CalculateShirtPrice\Repositories;


/**
 * Interface ManufactureRepositoryInterface
 * @package rosyrz\Mcs\CalculateShirtPrice\Repositories
 */
interface ManufactureRepositoryInterface
{

    /**
     * get Manufacture Cost
     * @param $sku
     * @return mixed
     */
    public function getManufactureCost($sku);

    /**
     * get Cut Cost
     * @param $ku
     * @return mixed
     */
    public function getCutCost($sku);

}