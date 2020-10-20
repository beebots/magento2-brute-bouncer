# Brute Bouncer
Brute Force Protection Module for Magento 2. 
This module does not do anything on it's own. This module is utility that you can use to protect 
a given URL or rest endpoint using Magento's plugin system.
This module creates it's own database table that it maintains to track attempts to access a given endpoint or resource by an IP address.
This module also includes a cron task that is used to periodically clean up records of old access attempts. 

## Installation
```
composer require beebots/magento2-brute-bouncer
```

## A note about IP Addresses
Make sure that you use the customer/user's IP address with this module and not the local IP address. Many Magento setups use Varnish with an outer nginx server that can end up making all the IP addresses 127.0.0.1. If you are setup this way you'll want to pull the real IP out of the headers before passing it to this module for validation.
 

## License
[MIT](LICENSE.txt)
