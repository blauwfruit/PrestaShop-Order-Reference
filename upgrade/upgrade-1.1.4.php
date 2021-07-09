<?php

function upgrade_module_1_1_4(Module $module)
{
    return $module->unregisterHook('actionObjectOrderUpdateAfter')
        && $module->unregisterHook('actionPaymentConfirmation')
        && $module->unregisterHook('actionValidateOrder')
        && $module->unregisterHook('actionOrderStatusUpdate')
        && $module->registerHook('actionObjectOrderAddAfter')
    ;
}
