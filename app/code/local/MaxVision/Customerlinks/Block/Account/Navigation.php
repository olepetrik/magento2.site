<?php
/**
 * Customerlinks Block Account Navigation
 *
 * @category   MaxVision
 * @package    MaxVision_Customerlinks
 * @author     MaxVision Team <maxyvision@gmail.com>
 */
class MaxVision_Customerlinks_Block_Account_Navigation extends Mage_Customer_Block_Account_Navigation {

    /* У файлі customerlinks.xml(див. config.xml модуля або у загальному local.xml) добавити блок для видалення лінків з My Account
    <customer_account>
        <reference name="customer_account_navigation">
          <action method="removeLinkByName"><name>billing_agreements</name></action>
          <action method="removeLinkByName"><name>recurring_profiles</name></action>
          <action method="removeLinkByName"><name>tags</name></action>
          <action method="removeLinkByName"><name>wishlist</name></action>
          <action method="removeLinkByName"><name>OAuth Customer Tokens</name></action>
          <action method="removeLinkByName"><name>downloadable_products</name></action>
      </reference>
    </customer_account>
    */

    /* This is a list of all names for navigation links in account dashboard (in default order of their appearance):
        account
        account_edit
        address_book
        orders
        billing_agreements
        recurring_profiles
        reviews
        tags
        wishlist
        OAuth Customer Tokens
        newsletter
        downloadable_products
    */

    /* У файлі customerlinks.xml(див. config.xml модуля або у загальному local.xml) вставити блок щоб добавити власний лінк (наприклад на checkout) в My Account
        <customer_account translate="label">
            <reference name="customer_account_navigation">
                <action method="addLink"><name>test checkout</name><path>checkout</path><label>MaxVision Checkout</label></action>
            </reference>
        </customer_account>
    */

    public function removeLinkByName($name) {
        unset($this->_links[$name]);
    }
}
