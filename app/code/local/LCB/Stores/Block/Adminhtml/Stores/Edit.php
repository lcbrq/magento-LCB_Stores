<?php

/**
 * Simple Magento CMS store location management
 *
 * @category   LCB
 * @package    LCB_Stores
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Stores_Block_Adminhtml_Stores_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct()
    {

        parent::__construct();
        $this->_objectId = "id";
        $this->_blockGroup = "stores";
        $this->_controller = "adminhtml_stores";
        $this->_updateButton("save", "label", Mage::helper("stores")->__("Save Item"));
        $this->_updateButton("delete", "label", Mage::helper("stores")->__("Delete Item"));

        $this->_addButton("saveandcontinue", array(
            "label" => Mage::helper("stores")->__("Save And Continue Edit"),
            "onclick" => "saveAndContinueEdit()",
            "class" => "save",
                ), -100);



        $this->_formScripts[] = "function saveAndContinueEdit(){
				     editForm.submit($('edit_form').action+'back/edit/');";
    }

    public function getHeaderText()
    {
        if (Mage::registry("stores_data") && Mage::registry("stores_data")->getId()) {

            return Mage::helper("stores")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("stores_data")->getId()));
        } else {

            return Mage::helper("stores")->__("Add Item");
        }
    }

}
