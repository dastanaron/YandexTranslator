YandexTranslator
================
is based on the Yandex interpreter. Uses the guzzlle library

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yandextranslator/yandextranslator "*"
```

or add

```
"yandextranslator/yandextranslator": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?php
use dastanaron\extension\yandextranslator\Translator;
$api_key  = 'you yandex api key';
$text = "Привет мир";
$translator = new Translator($api_key, $text);

$translate = $translator->translate();


echo $translate->getJson();
var_dump($translate->getArray());
echo $translate->etTranslateText();
echo $translate->getTranslatedToUrl();

```