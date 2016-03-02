Getting Started
---------------

Edit `src/config.inc` to add your API key.

Run `composer install` under `src` [GetComposer](https://getcomposer.org/)

Visit http://host/number_verify.php to run the number verification flow.

Security Warning
----------------
This is intended to run under apache. The .inc files should not be accessible from the web and are denied via the .htacccess configuration.
