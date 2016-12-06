<?php


namespace rosyrz\Mcs\CalculateShirtPrice;


/**
 * Class CalculateShirtPriceCommand
 * @package rosyrz\Mcs\CalculateShirtPrice
 */
class CalculateShirtPriceCommand{

    /** Metros de tela
     * @var int
     */
    public $mts;

    /**
     * Referencia de la tela
     * @var
     */
    public $fabricSku;

    /**
     * cantidad de botones
     * @var
     */
    public $buttons;

    /**
     * SKU del botón
     * @var null
     */
    public $buttonsSku;

    /**
     * Sku de la camisa
     * @var null
     */
    public $shirtSku;

    /**
     * CalculateShirtPriceCommand constructor.
     * @param int $mts
     */
    public function __construct(
        $mts = 0,
        $fabricSku = null,
        $buttons = 8,
        $buttonSku = null,
        $shirtSku = null
    )
    {
        $this->mts = $mts;
        $this->fabricSku = $fabricSku;
        $this->buttons = $buttons;
        $this->buttonSku = $buttonSku;
        $this->shirtSku = $shirtSku;
    }
}