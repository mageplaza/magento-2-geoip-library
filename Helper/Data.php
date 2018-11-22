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
 * @package     Mageplaza_GeoIp
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\GeoIp\Helper;

use Mageplaza\Core\Helper\AbstractData;

/**
 * Class Data
 * @package Mageplaza\GeoIp\Helper
 */
class Data extends AbstractData
{
    const CONFIG_MODULE_PATH = 'geoip';

    /**
     * @var Address
     */
    protected $_addressHelper;

    /**
     * @return Address
     */
    public function getAddressHelper()
    {
        if (!$this->_addressHelper) {
            $this->_addressHelper = $this->objectManager->get(Address::class);
        }

        return $this->_addressHelper;
    }

    /**
     * @param null $store
     * @return mixed
     */
    public function getDownloadPath($store = null)
    {
        return $this->getConfigGeneral('download_path', $store);
    }

}
