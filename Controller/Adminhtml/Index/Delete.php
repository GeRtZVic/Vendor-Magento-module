<?php
namespace Training\Elogic\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Training\Elogic\Model\Vendor;

/**
 * Class Delete
 * @package Training\Elogic\Controller\Adminhtml\Index
 */
class Delete extends Action
{
    protected $modelVendor;

    /**
     * @param Action\Context $context
     * @param Vendor $model
     */
    public function __construct(
        Action\Context $context,
        Vendor $model
    ) {
        parent::__construct($context);
        $this->modelVendor = $model;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Training_Elogic::vendor_delete');
    }

    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->modelVendor;
                $model->load($id);
                $model->delete();
                $this->messageManager->addComplexSuccessMessage(__('Vendor deleted'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addComplexErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addComplexErrorMessage(__('Vendor does not exist'));
        return $resultRedirect->setPath('*/*/');
    }
}
