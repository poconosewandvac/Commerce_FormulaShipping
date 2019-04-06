# Formula Shipping for Commerce

Allows creation of shipping methods that calculate the cost of shipping with a user inputted math formula. Powered by [mossadal/math-parser](https://github.com/mossadal/math-parser).

## Setup

1. Install from the MODX provider
2. Enable in Commerce Dashboard -> Configuration -> Modules
3. Create "Formula Shipping Method" shipping method in Commerce Dashboard -> Configuration -> Shipping Methods

## Variables

Inside the math formula, you can use variables which are accessible by putting the variable name between square brackets (ex. [qty]). These variables are dynamically entered when the shipping method cost is calculated.

- qty: number of items in the shipment
- value: price value of all items in the shipment
- value_ex_tax: price value of all items in the shipment excluding tax
- weight: weight in units desired (set in the weight unit field)
- fee: shipment cost
- fee_incl_tax: shipment cost including tax
- base_fee: price field on the shipping method
- base_fee_percent: price percentage field on the shipping method

**All price units must be in cents!** Price variables are in cents and price returned must be in cents.

## Math Parser

See  https://github.com/mossadal/math-parser for available math parser functionality.