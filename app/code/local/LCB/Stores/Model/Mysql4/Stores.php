<?php

/**
 * Simple Magento CMS store location management
 *
 * @category   LCB
 * @package    LCB_Stores
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Stores_Model_Mysql4_Stores extends Mage_Core_Model_Mysql4_Abstract {

    protected function _construct()
    {
        $this->_init("lcb_stores/stores", "id");
    }

}
