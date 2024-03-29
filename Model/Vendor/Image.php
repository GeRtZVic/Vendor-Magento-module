<?php
namespace Training\Elogic\Model\Vendor;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;

/**
 * Class Image
 * @package Training\Elogic\Model\Vendor
 */
class Image
{
    /**
     * media sub folder
     * @var string
     */
    protected $subDir = 'training/elogic/vendor';
    /**
     * url builder
     *
     * @var UrlInterface
     */
    protected $urlBuilder;
    /**
     * @var Filesystem
     */
    protected $fileSystem;
    /**
     * @param UrlInterface $urlBuilder
     * @param Filesystem $fileSystem
     */
    public function __construct(
        UrlInterface $urlBuilder,
        Filesystem $fileSystem
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->fileSystem = $fileSystem;
    }
    /**
     * get images base url
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $this->subDir . '/image';
    }

    /**
     * get base image dir
     *
     * @return string
     * @throws FileSystemException
     */
    public function getBaseDir()
    {
        return $this->fileSystem->getDirectoryWrite(DirectoryList::MEDIA)->getAbsolutePath($this->subDir . '/image');
    }
}
