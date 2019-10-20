<?php
namespace Training\Elogic\Block\Adminhtml\Vendor\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class DeleteButton
 * @package Training\Elogic\Block\Adminhtml\Vendor\Edit
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Delete Contact'),
            'on_click' => 'deleteConfirm(' . __('Are you sure you want to delete this vendor ?') . ', ' . $this->getDeleteUrl() . ')',
            'class' => 'delete',
            'sort_order' => 20
        ];
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        $urlInterface = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\UrlInterface');
        $url = $urlInterface->getCurrentUrl();

        $parts = explode('/', parse_url($url, PHP_URL_PATH));

        $id = $parts[6];

        return $this->getUrl('*/*/delete', ['id' => $id]);
    }
}