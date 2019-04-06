<?php

use modmore\Commerce\Admin\Widgets\Form\TextField;
use modmore\Commerce\Admin\Widgets\Form\WeightUnitField;
use modmore\Commerce\Admin\Widgets\Form\Validation\Required;
use MathParser\StdMathParser;
use MathParser\Interpreting\Evaluator;

/**
 * Formula Shipping for Commerce.
 *
 * Copyright 2019 by Tony Klapatch <tony@klapatch.net>
 *
 * This file is meant to be used with Commerce by modmore. A valid Commerce license is required.
 *
 * @package commerce_formulashipping
 * @license See core/components/commerce_formulashipping/docs/license.txt
 */
class FormulaShippingMethod extends comShippingMethod
{
    // Map fields to single character variables for use in math parser
    protected $fieldMap = [
        'qty' => 'a',
        'value' => 'b',
        'value_ex_tax' => 'c',
        'weight' => 'd',
        'fee' => 'f',
        'fee_incl_tax' => 'g',
        'base_fee' => 'h',
    ];

    public function getPriceForShipment(comOrderShipment $shipment)
    {
        $price = parent::getPriceForShipment($shipment);
        $formula = $this->getProperty('formula');
        $weightUnit = $this->getProperty('weight_unit');

        // Default to price if formula not set
        if (!$formula) {
            return $price;
        }

        // Attempt to calculate the math formula for shipping
        try {
            $parsedPrice = $this->parse($formula, $shipment, $weightUnit);
        } catch (Exception $e) {
            $this->adapter->log(1, '[FormulaShipping] Could not mathematically parse inputted formula "' . $formula . '" for shipping method ' . $this->get('id') . ' with shipment ' . $shipment->get('id'));
            return $price;
        }

        return $parsedPrice;
    }

    public function getModelFields()
    {
        $fields = parent::getModelFields();

        $fields[] = new WeightUnitField($this->commerce, [
            'name' => 'properties[weight_unit]',
            'label' => $this->adapter->lexicon('commerce_formulashipping.formula_weight_unit'),
            'default' => 'kg',
            'value' => $this->getProperty('weight_unit', $this->commerce->getOption('commerce_formulashipping.formula_weight_unit_desc')),
        ]);

        $fields[] = new TextField($this->commerce, [
            'label' => $this->adapter->lexicon('commerce_formulashipping.formula'),
            'description' => $this->adapter->lexicon('commerce.formulashipping.formula_desc'),
            'name' => 'properties[formula]',
            'value' => $this->getProperty('formula'),
            'validation' => [
                new Required()
            ],
        ]);

        return $fields;
    }

    /**
     * Parse a mathematic formula
     *
     * @param string $formula
     * @param comOrderShipment $shipment
     * @param string $weightUnit
     * @return float
     * @throws Exception
     */
    protected function parse($formula, comOrderShipment $shipment)
    {
        $order = $shipment->getOrder();
        $weightUnit = $this->getProperty('weight_unit');

        // Parse templates into single character mapped variables
        foreach ($this->fieldMap as $key => $value) {
            $formula = str_replace('[' . $key . ']', $value, $formula);
        }

        $parser = new StdMathParser();
        $ast = $parser->parse($formula);
        
        $evaluator = new Evaluator();
        $evaluator->setVariables([
            $this->fieldMap['qty'] => $shipment->get('product_quantity'),
            $this->fieldMap['value'] => $shipment->get('product_value'),
            $this->fieldMap['value_ex_tax'] => $shipment->get('product_value_ex_tax'),
            $this->fieldMap['weight'] => $shipment->getWeight()->toUnit($weightUnit),
            $this->fieldMap['fee'] => $shipment->get('fee'),
            $this->fieldMap['fee_incl_tax'] => $shipment->get('fee_incl_tax'),
            $this->fieldMap['base_fee'] => $this->get('price'),
            $this->fieldMap['base_fee_percent'] => $this->get('price_percentage'),
        ]);

        return $ast->accept($evaluator);
    }
}
