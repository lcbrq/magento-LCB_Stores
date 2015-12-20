<?php

/**
 * Simple Magento CMS store location management
 *
 * @category   LCB
 * @package    LCB_Stores
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Stores_Block_Adminhtml_Stores_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct()
    {
        parent::__construct();
        $this->setId("storesGrid");
        $this->setDefaultSort("id");
        $this->setDefaultDir("DESC");
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel("lcb_stores/stores")->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn("id", array(
            "header" => Mage::helper("stores")->__("ID"),
            "align" => "right",
            "width" => "50px",
            "type" => "number",
            "index" => "id",
        ));

        $this->addColumn("name", array(
            "header" => Mage::helper("stores")->__("Name"),
            "index" => "name",
        ));
        $this->addColumn("city", array(
            "header" => Mage::helper("stores")->__("City"),
            "index" => "city",
        ));
        $this->addColumn("x", array(
            "header" => Mage::helper("stores")->__("Position X"),
            "index" => "x",
        ));
        $this->addColumn("y", array(
            "header" => Mage::helper("stores")->__("Position Y"),
            "index" => "y",
        ));
        $this->addColumn("address", array(
            "header" => Mage::helper("stores")->__("Address"),
            "index" => "address",
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl("*/*/edit", array("id" => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('ids');
        $this->getMassactionBlock()->setUseSelectAll(true);
        $this->getMassactionBlock()->addItem('remove_stores', array(
            'label' => Mage::helper('stores')->__('Remove Stores'),
            'url' => $this->getUrl('*/adminhtml_stores/massRemove'),
            'confirm' => Mage::helper('stores')->__('Are you sure?')
        ));
        return $this;
    }

}
