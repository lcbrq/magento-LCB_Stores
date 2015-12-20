<?php

/**
 * Simple Magento CMS store location management
 *
 * @category   LCB
 * @package    LCB_Stores
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Stores_Block_Adminhtml_Stores extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {
        $this->_controller = "adminhtml_stores";
        $this->_blockGroup = "stores";
        $this->_headerText = Mage::helper("stores")->__("Stores Manager");
        $this->_addButtonLabel = Mage::helper("stores")->__("Add New Item");
        parent::__construct();
    }

}
