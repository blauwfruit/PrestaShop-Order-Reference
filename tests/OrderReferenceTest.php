<?php

namespace Blauwfruit\OrderReference\Tests;

use PHPUnit\Framework\TestCase;
use Order;
use Configuration;
use Module;

/**
 * Test Order Reference functionality
 */
class OrderReferenceTest extends TestCase
{
    /**
     * Create a minimal test order
     */
    private function createTestOrder(): Order
    {
        $order = new Order();
        $order->id_customer = 1;
        $order->id_cart = 0;
        $order->id_currency = Configuration::get('PS_CURRENCY_DEFAULT');
        $order->id_lang = Configuration::get('PS_LANG_DEFAULT');
        $order->id_address_delivery = 0;
        $order->id_address_invoice = 0;
        $order->id_carrier = 0;
        $order->payment = 'Test Payment';
        $order->module = 'test_module';
        $order->total_paid = 0;
        $order->total_paid_real = 0;
        $order->total_products = 0;
        $order->total_products_wt = 0;
        $order->total_shipping = 0;
        $order->total_shipping_tax_incl = 0;
        $order->total_shipping_tax_excl = 0;
        $order->conversion_rate = 1.0;
        $order->current_state = Configuration::get('PS_OS_PAYMENT');
        $order->secure_key = md5(uniqid(rand(), true));
        $order->reference = Order::generateReference();
        
        $result = $order->add();
        $this->assertTrue($result, 'Failed to create test order');
        
        // Give hooks time to execute
        sleep(1);
        
        return new Order($order->id);
    }
    
    /**
     * Test default PrestaShop order reference behavior (without module)
     */
    public function testDefaultOrderReference()
    {
        // Check if module is configured
        $module_installed = Module::isInstalled('orderreference');
        $module_enabled = Module::isEnabled('orderreference');
        $format_config = Configuration::get('ORDERREFERENCE_format');
        
        if ($module_installed && $module_enabled && !empty($format_config)) {
            $this->markTestSkipped('Module is already configured. Run this test before module configuration.');
        }
        
        // Create test order
        $order = $this->createTestOrder();
        
        // Assert reference uses default PrestaShop format
        $this->assertMatchesRegularExpression(
            '/^[A-Z0-9]{9}$/',
            $order->reference,
            'Reference should be 9-character alphanumeric (default PrestaShop format)'
        );
        
        // Assert reference is NOT equal to order ID (default behavior)
        $this->assertNotEquals(
            $order->id,
            $order->reference,
            'Default PrestaShop reference should NOT equal order ID'
        );
        
        echo "\n✓ Order ID: {$order->id}\n";
        echo "✓ Reference: {$order->reference} (default PrestaShop format)\n";
    }
    
    /**
     * Test order reference with module configured
     */
    public function testModuleOrderReference()
    {
        // Verify module is installed and configured
        $this->assertTrue(
            Module::isInstalled('orderreference'),
            'Module should be installed'
        );
        
        $this->assertTrue(
            Module::isEnabled('orderreference'),
            'Module should be enabled'
        );
        
        $format_config = Configuration::get('ORDERREFERENCE_format');
        
        $this->assertNotEmpty(
            $format_config,
            'Module should be configured with a format'
        );
        
        echo "\n✓ Module configured with format: {$format_config}\n";
        
        // Create test order
        $order = $this->createTestOrder();
        
        echo "Order created with ID: {$order->id}, initial reference: {$order->reference}\n";
        
        // Manually trigger the module's reference change (hooks may not fire in test environment)
        $module = \Module::getInstanceByName('orderreference');
        if ($module && method_exists($module, 'changeReference')) {
            $new_reference = $module->changeReference($order->id);
            echo "Module changeReference() returned: {$new_reference}\n";
            
            // Check database directly
            $db_reference = \Db::getInstance()->getValue('SELECT `reference` FROM `' . _DB_PREFIX_ . 'orders` WHERE `id_order` = ' . (int)$order->id);
            echo "Database reference value: {$db_reference}\n";
            
            // Use database value directly (Order object caching issue)
            $order->reference = $db_reference;
            echo "After module update, reference is: {$order->reference}\n";
        }
        
        // If format is {order->id:%d}, reference should equal order ID
        if ($format_config === '{order->id:%d}') {
            $this->assertEquals(
                $order->id,
                $order->reference,
                'With format {order->id:%d}, reference should equal order ID'
            );
            
            echo "✓ Order ID: {$order->id}\n";
            echo "✓ Reference: {$order->reference} (matches order ID)\n";
        } else {
            // For other formats, just verify it's a valid reference
            $this->assertNotEmpty($order->reference, 'Reference should not be empty');
            $this->assertLessThanOrEqual(9, strlen($order->reference), 'Reference should be max 9 characters');
            
            echo "✓ Order ID: {$order->id}\n";
            echo "✓ Reference: {$order->reference}\n";
        }
    }
}

