# Magento 2 GeoIP Extension

GeoIP extension for Magento 2 is an optimal solution for generating awesome customers’ experiences. It records the customers’ IP addresses then use it for navigating them to the suitable store locations, languages and currencies promptly. 

- Discover customers' location quickly
- Redirect customers to related stores with their local languages
- Auto-switch to the appropriate price currency  
- Fully compatible with [Mageplaza Store Switcher](https://www.mageplaza.com/magento-2-store-switcher/)

## 1. Documentation

- [Installation guide](https://www.mageplaza.com/install-magento-2-extension/)
- [User guide](https://docs.mageplaza.com/geoip/index.html)
- [Introduction page](http://www.mageplaza.com/magento-2-geoip/)
- [Contribute on Github](https://github.com/mageplaza/magento-2-geoip)
- [Get Support](https://github.com/mageplaza/magento-2-geoip/issues)


## 2. FAQs

**Q: If customers switch to another store view, whether the language can be changed accordingly?**

A: Definitely, yes. GeoIP conducts the detection of IP addresses and the changing of languages at the same time. 

**Q: How can I set up the currency rate for changing price currency when stores are changed?**

A:  First of all, please select two currencies by access to:  `Stories > Configuration > Currency Setup`. Then, to set the currency rate, please go to `Stories > Currency > Currency Rates`.  

**Q: How can customers come back to their initial store view?**

A: They can do it with ease by selecting the store view on the top menu of the frontend.    

## 3. How to install Share Cart extension for Magento 2

Install via composer (recommend)

Run the following command in Magento 2 root folder:

```
composer require mageplaza/module-geoip
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

## 4. Highlight features

### Find out customers' addressed quickly

By recording the data of customers who access your sites, GeoIP extensions modifies and analyses them to obtain customers' addresses and show it immediately in some seconds. 

![Imgur](https://i.imgur.com/hjobllS.png)
 
### Redirect customer to appropriate Store View and Language

After getting the customers' addresses, GeoIP module continues to match these locations to the according stores with their familiar languages. For example, the customers with IP addresses in the United Stages will be automatically switched to US store view when they visit a multi-stores website. 

![Imgur](https://i.imgur.com/rNIaRae.png)

### Automatically change to the appropriate currency 

One of the most outstanding features of GeoIP is changing price currency to the one which is commonly used (such as USD). Also, it can be changed to local currency same as the customer’s country. 

Moreover, customers do not need to change the product price to their wished currencies by themselves since GeoIP converts currency automatically. 

![Imgur](https://i.imgur.com/qziNsI7.png)

### Effectively increase users experience on sites 

Multiple-stores site in different locations now totally can gain as many as customers as possible with GeoIP. The module built to enhance users'accessability and usability on sites.

Being automatically moved to the appropriate store views with the familiar languages and currencies, customers will feel the shopping sites much more friendly and convenient to use. As a result, customers willing to invest their time for shopping and picking up their favourite items with ease. 

### Fully compatible with Mageplaza Store Switcher extension

Geo IP and Store Switcher are built with several similar features. Therefore, integrate both extensions will help store admins make full use of customers' data and so that your shopping sites will optimize the customers’ experience from their first-time visits. 

## 5. Full features list

### For store owners

- Enable/Disable the module
- Detect users'location with easy
- Redirect customers to their familiar store views
- Switch the language of their stores 
- Change the currency to local stores correspondingly
- Reduce bounce rate from first-time site visits
- Fully compatible with Magento 2 Store Switcher

### For customers

- View the site with familiar language and currency
- Switch to another site easily


## 6. How to configure the GeoIP module

From the `Admin Panel`, go to `Stores > Store Switcher > Configuration > Mageplaza Extension > Geo IP Configuration`, choose `Geo IP Configuration` section.

![Imgur](https://i.imgur.com/z5uvaP0.png)

- **Enable Geo IP**, please select `Yes` to turn on GeoIP module function which helps you define customers' countries then direct them to the related store views. 

- **Download Library button**: Click `Download Library` button to download Geo IP library before enabling it.







