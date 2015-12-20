<?php

/**
 * Simple Magento CMS store location management
 *
 * @category   LCB
 * @package    LCB_Stores
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Stores_Block_Adminhtml_Stores_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct()
    {
        parent::__construct();
        $this->setId("stores_tabs");
        $this->setDestElementId("edit_form");
        $this->setTitle(Mage::helper("stores")->__("Item Information"));
    }

    protected function _beforeToHtml()
    {
        $this->addTab("form_section", array(
            "label" => Mage::helper("stores")->__("Item Information"),
            "title" => Mage::helper("stores")->__("Item Information"),
            "content" => $this->getLayout()->createBlock("stores/adminhtml_stores_edit_tab_form")->toHtml(),
        ));
        return parent::_beforeToHtml();
    }

}
