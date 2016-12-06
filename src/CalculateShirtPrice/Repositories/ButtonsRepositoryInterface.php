<?php


namespace rosyrz\Mcs\CalculateShirtPrice\Repositories;


/**
 * Interface ButtonsRepositoryInterface
 * @package rosyrz\Mcs\CalculateShirtPrice\Repositories
 */
interface ButtonsRepositoryInterface
{

    /**
     * get the button price by Sku
     * @param $sku
     * @return float
     */
    public function getButtonPriceBySku($sku);

}