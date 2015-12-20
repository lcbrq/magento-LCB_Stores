<?php

/**
 * Simple Magento CMS store location management
 *
 * @category   LCB
 * @package    LCB_Stores
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Stores_Block_Adminhtml_Stores_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm()
    {

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset("stores_form", array("legend" => Mage::helper("stores")->__("Item information")));


        $fieldset->addField("name", "text", array(
            "label" => Mage::helper("stores")->__("Name"),
            "name" => "name",
        ));

        $fieldset->addField("city", "text", array(
            "label" => Mage::helper("stores")->__("City"),
            "name" => "city",
        ));

        $fieldset->addField("x", "text", array(
            "label" => Mage::helper("stores")->__("Position X"),
            "name" => "x",
        ));

        $fieldset->addField("y", "text", array(
            "label" => Mage::helper("stores")->__("Position Y"),
            "name" => "y",
        ));

        $fieldset->addField("address", "textarea", array(
            "label" => Mage::helper("stores")->__("Address"),
            "name" => "address",
        ));

        $fieldset->addField('photo', 'image', array(
            'label' => Mage::helper('stores')->__('Photo'),
            'name' => 'photo',
            'note' => '(*.jpg, *.png, *.gif)',
        ));

        if (Mage::getSingleton("adminhtml/session")->getStoresData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getStoresData());
            Mage::getSingleton("adminhtml/session")->setStoresData(null);
        } elseif (Mage::registry("stores_data")) {
            $form->setValues(Mage::registry("stores_data")->getData());
        }
        return parent::_prepareForm();
    }

}
