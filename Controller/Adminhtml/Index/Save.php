<?php
namespace Training\Elogic\Controller\Adminhtml\Index;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\File\Uploader;
use RuntimeException;
use Training\Elogic\Model\Vendor;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Training\Elogic\Model\VendorRepository;

/**
 * Class Save
 * @package Training\Elogic\Controller\Adminhtml\Index
 */
class Save extends Action
{
    /**
     * @var Vendor
     */
    protected $_model;

    /**
     * @var UploaderFactory
     */
    protected $uploaderFactory;

    /**
     * @var VendorRepository
     */
    private $vendorRepository;

    protected $imageUploader;

    /**
     * @param Action\Context $context
     * @param Vendor $model
     * @param UploaderFactory $uploaderFactory
     * @param VendorRepository $vendorRepository
     */
    public function __construct(
        Action\Context $context,
        Vendor $model,
        UploaderFactory $uploaderFactory,
        VendorRepository $vendorRepository
    ) {
        parent::__construct($context);
        $this->_model = $model;
        $this->uploaderFactory = $uploaderFactory;
        $this->vendorRepository = $vendorRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Training_Elogic::elogic_save');
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var Vendor $model */
            $model = $this->_model;

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model = $this->vendorRepository->getById($id);
            }

            $model->setData($data);

            $this->_eventManager->dispatch(
                'elogic_vendor_prepare_save',
                ['vendor' => $model, 'request' => $this->getRequest()]
            );

            try {
                if (isset($data['logo'][0]['name']) && isset($data['logo'][0]['tmp_name'])) {
                    $data['image'] =$data['logo'][0]['name'];
                    $this->imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get(
                        'Training\Elogic\VendorImageUpload'
                    );
                    $this->imageUploader->moveFileFromTmp($data['image']);
                } elseif (isset($data['logo'][0]['image']) && !isset($data['logo'][0]['tmp_name'])) {
                    $data['image'] = $data['logo'][0]['image'];
                } else {
                    $data['image'] = null;
                }
                $model->setLogo($data['image']);
                $this->vendorRepository->save($model);

                $this->messageManager->addSuccess(__('Vendor saved'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the vendor'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param $input
     * @param $destinationFolder
     * @param $data
     * @return string
     */
    public function uploadFileAndGetName($input, $destinationFolder, $data)
    {
        try {
            if (isset($data[$input]['delete'])) {
                return '';
            } else {
                $uploader = $this->uploaderFactory->create(['fileId' => $input]);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(true);
                $uploader->setAllowCreateFolders(true);
                $result = $uploader->save($destinationFolder);
                return $result['file'];
            }
        } catch (Exception $e) {
            if ($e->getCode() != Uploader::TMP_NAME_EMPTY) {
                $this->messageManager->addError($e->getMessage());
            } else {
                if (isset($data[$input]['value'])) {
                    return $data[$input]['value'];
                }
            }
        }
        return '';
    }
}
