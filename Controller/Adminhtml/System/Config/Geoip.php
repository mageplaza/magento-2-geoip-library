<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_GeoIP
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\GeoIP\Controller\Adminhtml\System\Config;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Filesystem\DriverInterface;
use Magento\Framework\Exception\LocalizedException;
use Mageplaza\GeoIP\Helper\Data as HelperData;
use Psr\Log\LoggerInterface;
use PharData;
use RecursiveIteratorIterator;
use function stream_get_wrappers;
use function stream_wrapper_restore;
use function stream_wrapper_unregister;

/**
 * Class Geoip
 * @package Mageplaza\GeoIP\Controller\Adminhtml\System\Config
 */
class Geoip extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Mageplaza_GeoIP::configuration';

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var DirectoryList
     */
    protected $_directoryList;

    /**
     * @var HelperData
     */
    protected $_helperData;

    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * Geoip constructor.
     *
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param DirectoryList $directoryList
     * @param HelperData $helperData
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        DirectoryList $directoryList,
        HelperData $helperData,
        LoggerInterface $logger
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->_directoryList    = $directoryList;
        $this->_helperData       = $helperData;
        $this->_logger           = $logger;

        parent::__construct($context);
    }

    /**
     * @return $this
     */
    public function execute()
    {
        $status = false;
        try {
            $path = $this->_directoryList->getPath('var') . '/Mageplaza/GeoIp/GeoIp';
            if (!file_exists($path)) {
                mkdir($path, DriverInterface::WRITEABLE_DIRECTORY_MODE, true);
            }
            $folder   = scandir($path, true);
            $pathFile = $path . '/' . $folder[0] . '/GeoLite2-City.mmdb';
            if (file_exists($pathFile)) {
                foreach (scandir($path . '/' . $folder[0], true) as $filename) {
                    if ($filename == '..' || $filename == '.') {
                        continue;
                    }
                    unlink($path . '/' . $folder[0] . '/' . $filename);
                }
                rmdir($path . '/' . $folder[0]);
            }

            $archive = $path . '/GeoLite2-City.tar.gz';
            $url     = $this->_helperData->getDownloadPath();
            file_put_contents($archive, fopen($url, 'r'));
            $this->verifyChecksum($archive, $url);
            $this->extractDatabase($archive, $path);
            $status  = true;
            $message = __('Download library success!');
        } catch (Exception $e) {
            $this->_logger->info($e->getMessage());
            $message = __('Can\'t download file. Please try again! <br> You can find out more in the error log.' );
        }

        /** @var Json $result */
        $result = $this->resultJsonFactory->create();

        return $result->setData(['success' => $status, 'message' => $message]);
    }

    /**
     * @param string $archive
     * @param string $url
     *
     * @throws LocalizedException
     */
    protected function verifyChecksum($archive, $url)
    {
        $expected = strtolower(strtok(trim((string)file_get_contents($url . '.sha256')), " \t"));
        if (!preg_match('/^[a-f0-9]{64}$/', $expected) || !hash_equals($expected, hash_file('sha256', $archive))) {
            unlink($archive);

            throw new LocalizedException(__('GeoIP archive checksum mismatch.'));
        }
    }

    /**
     * @param string $archive
     * @param string $path
     *
     * @throws LocalizedException
     */
    protected function extractDatabase($archive, $path)
    {
        $restored = !in_array('phar', stream_get_wrappers(), true);
        if ($restored) {
            stream_wrapper_restore('phar');
        }

        try {
            $prefix = 'phar://' . realpath($archive) . '/';
            $phar   = new PharData($archive);
            foreach (new RecursiveIteratorIterator($phar) as $entry) {
                $name = substr($entry->getPathname(), strlen($prefix));
                if (!$entry->isFile() || $entry->isLink() || basename($name) !== 'GeoLite2-City.mmdb'
                    || $name[0] === '/' || in_array('..', explode('/', $name), true)
                ) {
                    continue;
                }
                $folder = basename(dirname($name));
                if (!preg_match('/^[\w.-]+$/', $folder) || $folder === '.' || $folder === '..') {
                    continue;
                }
                $target = $path . '/' . $folder;
                if (!is_dir($target)) {
                    mkdir($target, DriverInterface::WRITEABLE_DIRECTORY_MODE, true);
                }
                if (!copy($entry->getPathname(), $target . '/GeoLite2-City.mmdb')) {
                    throw new LocalizedException(__('Cannot write GeoLite2-City.mmdb.'));
                }

                return;
            }
        } finally {
            if ($restored) {
                stream_wrapper_unregister('phar');
            }
        }

        throw new LocalizedException(__('GeoLite2-City.mmdb not found in archive.'));
    }
}
