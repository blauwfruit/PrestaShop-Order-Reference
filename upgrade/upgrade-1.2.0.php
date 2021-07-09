<?php

function upgrade_module_1_2_0(Module $module)
{
    $module->unregisterHook('actionObjectOrderUpdateAfter');
    $module->unregisterHook('actionPaymentConfirmation');
    $module->unregisterHook('actionValidateOrder');
    $module->unregisterHook('actionOrderStatusUpdate');
    $module->registerHook('actionObjectOrderAddAfter');
    return true;
}
