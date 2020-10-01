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

namespace Mageplaza\GeoIP\Helper;

use Exception;
use GeoIp2\Database\Reader;
use Magento\Customer\Helper\Address as CustomerAddressHelper;
use Magento\Directory\Model\Region;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Locale\Resolver;
use Magento\Framework\ObjectManagerInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Address
 * @package Mageplaza\GeoIP\Helper
 */
class Address extends Data
{
    /**
     * @type DirectoryList
     */
    protected $_directoryList;

    /**
     * @type Resolver
     */
    protected $_localeResolver;

    /**
     * @type Region
     */
    protected $_regionModel;

    /**
     * @var CustomerAddressHelper
     */
    protected $addressHelper;

    /**
     * Address constructor.
     *
     * @param Context $context
     * @param ObjectManagerInterface $objectManager
     * @param StoreManagerInterface $storeManager
     * @param DirectoryList $directoryList
     * @param Resolver $localeResolver
     * @param Region $regionModel
     */
    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager,
        DirectoryList $directoryList,
        Resolver $localeResolver,
        Region $regionModel
    ) {
        $this->_directoryList  = $directoryList;
        $this->_localeResolver = $localeResolver;
        $this->_regionModel    = $regionModel;

        parent::__construct($context, $objectManager, $storeManager);
    }

    /***************************************** Maxmind Db GeoIp ******************************************************/
    /**
     * Check has library at path var/Mageplaza/GeoIp/GeoIp/
     * @return bool|string
     * @throws FileSystemException
     */
    public function checkHasLibrary()
    {
        $path = $this->_directoryList->getPath('var') . '/Mageplaza/GeoIp/GeoIp';
        if (!file_exists($path)) {
            return false;
        }

        $folder   = scandir($path, true);
        $pathFile = $path . '/' . $folder[0] . '/GeoLite2-City.mmdb';
        if (!file_exists($pathFile)) {
            return false;
        }

        return $pathFile;
    }

    /**
     * @param null $storeId
     *
     * @return array
     */
    public function getGeoIpData($storeId = null)
    {
        try {
            $libPath = $this->checkHasLibrary();
            if ($this->isEnabled($storeId) && $libPath && class_exists('GeoIp2\Database\Reader')) {
                $geoIp  = new Reader($libPath, $this->getLocales());
                $record = $geoIp->city($this->getIpAddress());

                $geoIpData = [
                    'city'       => $record->city->name,
                    'country_id' => $record->country->isoCode,
                    'postcode'   => $record->postal->code
                ];

                if ($record->mostSpecificSubdivision) {
                    $code = $record->mostSpecificSubdivision->isoCode;
                    if ($regionId = $this->_regionModel->loadByCode($code, $record->country->isoCode)->getId()) {
                        $geoIpData['region_id'] = $regionId;
                    } else {
                        $geoIpData['region'] = $record->mostSpecificSubdivision->name;
                    }
                }
            } else {
                $geoIpData = [];
            }
        } catch (Exception $e) {
            // No Ip found in database
            $geoIpData = [];
        }

        return $geoIpData;
    }

    /**
     * Get IP
     * @return string
     */
    public function getIpAddress()
    {
        $fakeIP = $this->_request->getParam('fakeIp', false);
        if ($fakeIP) {
            return $fakeIP;
        }

        $server = $this->_getRequest()->getServer();

        $ip = $server['REMOTE_ADDR'];
        if (!empty($server['HTTP_CLIENT_IP'])) {
            $ip = $server['HTTP_CLIENT_IP'];
        } elseif (!empty($server['HTTP_X_FORWARDED_FOR'])) {
            $ip = $server['HTTP_X_FORWARDED_FOR'];
        }

        $ipArr = explode(',', $ip);

        return array_shift($ipArr);
    }

    /**
     * @return array
     */
    protected function getLocales()
    {
        $language = substr($this->_localeResolver->getLocale(), 0, 2) ?: 'en';

        $locales = [$language];
        if ($language !== 'en') {
            $locales[] = 'en';
        }

        return $locales;
    }
}
