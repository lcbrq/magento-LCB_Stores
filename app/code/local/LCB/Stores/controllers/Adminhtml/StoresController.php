<?php

/**
 * Simple Magento CMS store location management
 *
 * @category   LCB
 * @package    LCB_Stores
 * @author     Silpion Tomasz Gregorczyk <tom@leftcurlybracket.com>
 */
class LCB_Stores_Adminhtml_StoresController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu("stores/stores")->_addBreadcrumb(Mage::helper("adminhtml")->__("Stores  Manager"), Mage::helper("adminhtml")->__("Stores Manager"));
        return $this;
    }

    public function indexAction()
    {
        $this->_title($this->__("Stores"));
        $this->_title($this->__("Manager Stores"));

        $this->_initAction();
        $this->renderLayout();
    }

    public function editAction()
    {
        $this->_title($this->__("Stores"));
        $this->_title($this->__("Stores"));
        $this->_title($this->__("Edit Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("lcb_stores/stores")->load($id);
        if ($model->getId()) {
            Mage::register("stores_data", $model);
            $this->loadLayout();
            $this->_setActiveMenu("stores/stores");
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Stores Manager"), Mage::helper("adminhtml")->__("Stores Manager"));
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Stores Description"), Mage::helper("adminhtml")->__("Stores Description"));
            $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock("stores/adminhtml_stores_edit"))->_addLeft($this->getLayout()->createBlock("stores/adminhtml_stores_edit_tabs"));
            $this->renderLayout();
        } else {
            Mage::getSingleton("adminhtml/session")->addError(Mage::helper("stores")->__("Item does not exist."));
            $this->_redirect("*/*/");
        }
    }

    public function newAction()
    {

        $this->_title($this->__("Stores"));
        $this->_title($this->__("Stores"));
        $this->_title($this->__("New Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("lcb_stores/stores")->load($id);

        $data = Mage::getSingleton("adminhtml/session")->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register("stores_data", $model);

        $this->loadLayout();
        $this->_setActiveMenu("stores/stores");

        $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Stores Manager"), Mage::helper("adminhtml")->__("Stores Manager"));
        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Stores Description"), Mage::helper("adminhtml")->__("Stores Description"));


        $this->_addContent($this->getLayout()->createBlock("stores/adminhtml_stores_edit"))->_addLeft($this->getLayout()->createBlock("stores/adminhtml_stores_edit_tabs"));

        $this->renderLayout();
    }

    public function saveAction()
    {

        $post_data = $this->getRequest()->getPost();


        if ($post_data) {

            try {

                //save image
                try {

                    if ((bool) $post_data['photo']['delete'] == 1) {

                        $post_data['photo'] = '';
                    } else {

                        unset($post_data['photo']);

                        if (isset($_FILES)) {

                            if ($_FILES['photo']['name']) {

                                if ($this->getRequest()->getParam("id")) {
                                    $model = Mage::getModel("lcb_stores/stores")->load($this->getRequest()->getParam("id"));
                                    if ($model->getData('photo')) {
                                        $io = new Varien_Io_File();
                                        $io->rm(Mage::getBaseDir('media') . DS . implode(DS, explode('/', $model->getData('photo'))));
                                    }
                                }
                                $path = Mage::getBaseDir('media') . DS . 'stores' . DS . 'stores' . DS;
                                $uploader = new Varien_File_Uploader('photo');
                                $uploader->setAllowedExtensions(array('jpg', 'png', 'gif'));
                                $uploader->setAllowRenameFiles(false);
                                $uploader->setFilesDispersion(false);
                                $destFile = $path . $_FILES['photo']['name'];
                                $filename = $uploader->getNewFileName($destFile);
                                $uploader->save($path, $filename);

                                $post_data['photo'] = 'stores/stores/' . $filename;
                            }
                        }
                    }
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                    $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                    return;
                }
//save image


                $model = Mage::getModel("lcb_stores/stores")
                        ->addData($post_data)
                        ->setId($this->getRequest()->getParam("id"))
                        ->save();

                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Stores was successfully saved"));
                Mage::getSingleton("adminhtml/session")->setStoresData(false);

                if ($this->getRequest()->getParam("back")) {
                    $this->_redirect("*/*/edit", array("id" => $model->getId()));
                    return;
                }
                $this->_redirect("*/*/");
                return;
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                Mage::getSingleton("adminhtml/session")->setStoresData($this->getRequest()->getPost());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
                return;
            }
        }
        $this->_redirect("*/*/");
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam("id") > 0) {
            try {
                $model = Mage::getModel("lcb_stores/stores");
                $model->setId($this->getRequest()->getParam("id"))->delete();
                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
                $this->_redirect("*/*/");
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
            }
        }
        $this->_redirect("*/*/");
    }

    public function massRemoveAction()
    {
        try {
            $ids = $this->getRequest()->getPost('ids', array());
            foreach ($ids as $id) {
                $model = Mage::getModel("lcb_stores/stores");
                $model->setId($id)->delete();
            }
            Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
        } catch (Exception $e) {
            Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
    }

    /**
     * Export order grid to CSV format
     */
    public function exportCsvAction()
    {
        $fileName = 'stores.csv';
        $grid = $this->getLayout()->createBlock('stores/adminhtml_stores_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     *  Export order grid to Excel XML format
     */
    public function exportExcelAction()
    {
        $fileName = 'stores.xml';
        $grid = $this->getLayout()->createBlock('stores/adminhtml_stores_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

}
