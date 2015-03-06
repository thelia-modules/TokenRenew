# Token Renew

This module can renew the form.secret config parameter. This parameter is used for creating a unique CSRF token used in Thelia's forms.

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is TokenRenew.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/token-renew-module:~1.0
```

## Usage

Command line : 

```
$ php Thelia token:renew
```
