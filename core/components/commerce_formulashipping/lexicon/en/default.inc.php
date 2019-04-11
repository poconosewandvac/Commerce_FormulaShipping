<?php

// General
$_lang['commerce_formulashipping'] = 'Formula Shipping';
$_lang['commerce_formulashipping.description'] = 'Calculate shipping costs with a formula.';
$_lang['commerce.add_FormulaShippingMethod'] = 'Add Formula Shipping Method';
$_lang['commerce.FormulaShippingMethod'] = 'Formula Shipping Method';

// Fields
$_lang['commerce_formulashipping.formula'] = 'Formula';
$_lang['commerce.formulashipping.formula_desc'] = 'The mathematic formula used to calculate cost of shipping. Availabile variables: qty (total items in order), value (total item value), value_ex_tax, weight, fee (shipment cost), fee_incl_tax, base_fee (base shipping method cost, price field) base_fee_percent. Enclose variables in square brackets [variable_name]. All price units are in cents. Returned price must be in cents. Math parser documentation: https://github.com/mossadal/math-parser.';

$_lang['commerce_formulashipping.formula_weight_unit'] = 'Formula Weight Unit';
$_lang['commerce_formulashipping.formula_weight_unit_desc'] = 'Weight unit used in formula.';

$_lang['commerce_formulashipping.formula_max_qty'] = 'Max Item Quantity';
$_lang['commerce_formulashipping.formula_max_qty_desc'] = 'The maximum amount of items allowed in a shipment (not order) for this shipping method to apply.';

$_lang['commerce_formulashipping.formula_min_qty'] = 'Min Item Quantity';
$_lang['commerce_formulashipping.formula_min_qty_desc'] = 'The minimum amount of items required in a shipment (not order) for this shipping method to apply.';