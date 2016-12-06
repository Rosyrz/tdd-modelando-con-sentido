<?php


namespace rosyrz\Mcs\CalculateShirtPrice\Repositories;


/**
 * Interface FabricRepositoryInterface
 * @package rosyrz\Mcs\CalculateShirtPrice\Repositories
 */
interface FabricRepositoryInterface
{

    /**
     * obtiene el precio de la tela usando el SKU
     * @param $fabriSku
     * @return float Precio de la tela del fabricante
     */
    public function getFabricPrice($fabriSku);

}