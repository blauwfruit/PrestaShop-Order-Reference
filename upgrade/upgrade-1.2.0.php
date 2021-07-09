<?php
/**
*   Orderreference
*
*   Do not copy, modify or distribute this document in any form.
*
*   @author     @gett-thijssimonis
*   @copyright  Copyright (c) 2013-2021 blauwfruit (http://blauwfruit.nl)
*   @license    Proprietary Software
*
*/

function upgrade_module_1_2_0(Module $module)
{
    $module->unregisterHook('actionObjectOrderUpdateAfter');
    $module->unregisterHook('actionPaymentConfirmation');
    $module->unregisterHook('actionValidateOrder');
    $module->unregisterHook('actionOrderStatusUpdate');
    $module->registerHook('actionObjectOrderAddAfter');
    return true;
}
