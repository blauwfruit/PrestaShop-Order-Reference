{*
* 2007-2018 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2018 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="panel">
    {if !$module_position_is_hight}
        <p class="alert alert-danger">
            {l s='The position of this module is not at the top of the hook "actionValidateOrder".' mod='orderreference'}
            <br>
            {l s='Go to ' mod='orderreference'} <a href="{$module_position_link}" target="_blank">{$module_position_link}</a> {l s=' and search for "actionValidateOrder" and check "Display non-positionable hooks", drag the Order Reference module all the way to the top!' mod='orderreference'}
            <br>
            {l s='Make sure that this module\'s position is as high as possible, so that all processes happening later will find a formatted order reference!' mod='orderreference'}
        </p>
    {/if}
    <h2>Preview</h2>
    <p>
        <code>
            {$preview_reference}
        </code>
        <h2>Examples</h2>
        <code>
            {literal}{delivery_address->company:%4.4s:capitalize}{cart->id:%06d}{_}{customer->firstname:%5.5s:capitalize}{/literal}
        </code>
        <code>
            {literal}{shop->name:%1.1s:capitalize}{order->id:%06d}{/literal}
        </code>
    </p>
    {if $module_position_is_hight}
        <p class="alert alert-info">
            {l s='The hook "actionValidateOrder" is configured properly.' mod='module'}
        </p>
    {/if}

</div>

