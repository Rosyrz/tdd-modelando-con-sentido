<?php


namespace rosyrz\Mcs\CalculateShirtPrice\Repositories;
use rosyrz\Mcs\CalculateShirtPrice\Exceptions\ButtonNotFoundException;


/**
 * Class ButtonsArrayRepository
 * @package rosyrz\Mcs\CalculateShirtPrice\Repositories
 */
class ButtonsArrayRepository implements ButtonsRepositoryInterface
{

    /**
     * @var array
     */
    protected $buttons = [
    'BUT78' => 100
    ];

    /**
     * @param $sku
     * @return float
     */
    public function getButtonPriceBySku($sku)
    {
        if(isset($this->buttons[$sku])){
            return (float)$this->buttons[$sku];
        }
        throw new ButtonNotFoundException;
    }
}