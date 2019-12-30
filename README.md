# Magento 2 GeoIP Extension

GeoIP Library for Magento 2 provides stores with GeoIP Database, which supports to detect the current geolocation of customer using his IP address. 

- Discover customers' location quickly
- Fully compatible with [Mageplaza Store Switcher](https://www.mageplaza.com/magento-2-store-switcher/)

## 1. GeoIp Documentation 

- [Installation guide](https://www.mageplaza.com/install-magento-2-extension/)
- [User guide](https://docs.mageplaza.com/geoip-library/index.html)
- [Introduction page](http://www.mageplaza.com/magento-2-geoip/)
- [Contribute on Github](https://github.com/mageplaza/magento-2-geoip-library)
- [Get Support](https://github.com/mageplaza/magento-2-geoip-library/issues)


## 2. FAQs

**Q: I got error: Mageplaza_Core has been already defined**

A: Read solution [here](https://github.com/mageplaza/module-core/issues/3)

**Q: What is the library used for?**

A: GeoIP library contains the GeoLite 2 geolocation database. Based on this, you can take advantage to build up other advanced functions such as auto-detect customer’ address to [suggest stores](https://www.mageplaza.com/magento-2-store-locator-extension/), s[witch appropriate language storeview](https://www.mageplaza.com/magento-2-store-switcher/). 
   

## 3. How to install GeoIP extension for Magento 2

Install via composer (recommend)

Run the following command in Magento 2 root folder:

```
composer require mageplaza/module-geoip
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

## 4. Highlight features

The module is built based on the GeoLite 2 database, also the IP geolocation database. The GeoLite2 Country, City, and ASN databases are updated frequently. 

In this free module, the store admin can download the library to get the Geolocation database. The database is the basement to power other advanced location functions (store switching, store locating) 

With 2 simple steps, you can download the geodatabase library and enable the module to activate the library and come into usage. 

![Highlight features](https://i.imgur.com/K0xoXAV.png)

GeoIP library is used to develop [Magento 2 Store Switcher](https://www.mageplaza.com/magento-2-store-switcher/), [Magento 2 Store Locator](https://www.mageplaza.com/magento-2-store-locator-extension/) and [Magento 2 Store Pickup](https://www.mageplaza.com/magento-2-store-pickup-extension/) by Mageplaza 


## 5. How to configure the GeoIP module

From the `Admin Panel`, go to `Stores > Configuration > Mageplaza Extension > Geo IP`, choose `Geo IP Configuration` section.

![Imgur](https://i.imgur.com/z5uvaP0.png)

- **Enable Geo IP**, please select `Yes` to turn on GeoIP module function which helps you define customers' countries then direct them to the related store views. 

- **Download Library button**: Click `Download Library` button to download Geo IP library before enabling it.



**People also search:**
- geoip magento 2
- magento 2 geo ip
- magento 2 geoip extension
- magento 2 geoip redirect
- magento 2 geoip store switcher
- magento 2 geolocation
- magento 2 geoip currency switcher


**Other free Magento 2 extensions on Github**
- [Magento 2 SEO Suite](https://github.com/mageplaza/magento-2-seo)
- [Magento 2 google maps](https://github.com/mageplaza/magento-2-google-maps)
- [Magento 2 Delete Orders](https://github.com/mageplaza/magento-2-delete-orders)
- [Magento 2 GDPR](https://github.com/mageplaza/magento-2-gdpr)
- [Magento 2 Backend Reindex](https://github.com/mageplaza/magento-2-backend-reindex)
- [Magento 2 Social login free](https://github.com/mageplaza/magento-2-social-login)
- [Magento 2 security](https://github.com/mageplaza/magento-2-security)
- [Magento 2 Blog](https://github.com/mageplaza/magento-2-blog)




