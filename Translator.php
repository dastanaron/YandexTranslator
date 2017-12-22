<?php

namespace backend\components;

use GuzzleHttp\Client;

/**
 * Class Translator
 * Performs text translation via Yandex API
 * @package backend\components
 */
class Translator
{
    /**
     * Access key to Yandex translate
     * @var string
     */
    public $key;

    /**
     * Text for translation
     * @var string
     */
    public $text;

    /**
     * Translated text
     * @var string
     */
    public $translated;

    /**
     * Direction of translation
     * @var string
     */
    public $lang;

    /**
     * Output Format
     * @var string
     */
    public $format;

    /**
     * Translate options
     * @var array
     */
    public $options;


    /**
     * Translator constructor.
     * @param $api_key
     * @param $text
     * @param string $lang
     * @param string $format
     * @param array $options
     */
    public function __construct($api_key, $text, $lang="ru-en", $format="plain", $options = array())
    {

        $this->key = $api_key;

        $this->text = $text;
        $this->lang = $lang;
        $this->format = $format;
        $this->options = $options;


    }


    /**
     * This method return this object
     * Before to use the getJson, getArray, getTranslate text method
     * @return $this
     */
    public function translate()
    {
        $translated = $this->ApiRequest();

        $this->translated = $translated;

        return $this;

    }

    /**
     * Method returned json string
     * @return string
     */
    public function getJson()
    {
        return $this->translated;
    }

    /**
     * Method returned json_decode string in array
     * @return mixed
     */
    public function getArray()
    {
        return \GuzzleHttp\json_decode($this->translated, true);
    }

    /**
     * Method returned translated text
     * @return mixed
     */
    public function getTranslateText()
    {
        return Json::decode($this->translated)['text'][0];
    }

    /**
     * Method returned translated string by url
     * @return string
     */
    public function getTranslatedToUrl()
    {
        $text = $this->getTranslateText();

        $text = str_replace(' ', '-', $text);

        $text = preg_replace('#[\'\"\:\^\.\,]#', '', $text);

        $text = mb_convert_case($text, MB_CASE_LOWER);

        return $text;

    }

    /**
     * This method request get to Yandex
     * @return string
     */
    private function ApiRequest()
    {
        $url = 'https://translate.yandex.net/api/v1.5/tr.json/translate'.$this->paramsbuild();

        $client = new Client();

        $res = $client->request('GET', $url, []);

       return $res->getBody()->getContents();

    }

    /**
     * Build query method
     * @return string
     */
    private function paramsbuild()
    {

        $params = '';

        $params .= '?key='.$this->key;

        !empty($this->text) ? $params .= '&text='.$this->text : null;

        !empty($this->lang) ? $params .= '&lang='.$this->lang : null;

        !empty($this->format) ? $params .= '&format='.$this->format : null;

        if(!empty($this->options) && is_array($this->options)) {
            foreach($this->options as $option) {
                $params .= '&'.$option;
            }
        }

        return $params;

    }

}