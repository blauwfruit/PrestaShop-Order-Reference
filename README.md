# Order reference module for PrestaShop

This module aims to easily create custom order reference. It can be customized using variables from the following PrestaShop Objects:

* Order => `order->id`
* Cart => `cart->id`
* Shop => `shop->id`
* Delivery => `delivery_address->id`
* Invoice => `invoice_address->id`
* Customer => `customer->name`


## Configuration

In the configuration page you can define a format. Let's take the example format:


### Example 1: Just the cart id

**Config value**: `{cart->id:%d}`

**Output**: `5424`

### Example 2: First letter of the shop's name in capital and the order nummer with 6 preceding zeroes

**Config value**: `{shop->name:%1.1s:capitalize}{order->id:%06d}`

**Output**: `S003638`

### Example 3: A hardcoded string

**Config value**: `{20}{order->id:%06d}`

**Output**: `20000161`

The random example is shown once you save the configuration.

Every format needs a modifier, like `%d` (digit) and `%s` (string).