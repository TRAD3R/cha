<?php


namespace App;


use yii\base\BaseObject;

class Request extends BaseObject
{
    const METHOD_GET        = 1;
    const METHOD_POST       = 2;
    const METHOD_PUT        = 3;
    const METHOD_DELETE     = 4;
    const METHOD_OPTIONS    = 5;
    const METHOD_HEAD       = 6;
    const METHOD_PATCH      = 7;

    /** @var \yii\web\Request|\yii\console\Request */
    private $request;

    /**
     * @param \yii\web\Request|\yii\console\Request $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        if(!$this->request->getIsConsoleRequest()){
            return $this->request->getPreferredLanguage();
        }

        return '';
    }

    /**
     * @return string|null
     */
    public function getServerHost()
    {
        if(!$this->request->getIsConsoleRequest()){
            return $this->request->getHostName();
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getServerAddr()
    {
        return $_SERVER['SERVER_ADDR'] ?: null;
    }

    /**
     * @param null $key
     * @param null $defaultValue
     * @return array|mixed
     */
    public function get($key = null, $defaultValue = null)
    {
        return $this->request->get($key, $defaultValue);
    }

    /**
     * @param null $key
     * @param null $defaultValue
     * @return array|mixed
     */
    public function post($key = null, $defaultValue = null)
    {
        return $this->request->post($key, $defaultValue);
    }

    /**
     * @param string $key
     * @param null $defaultValue
     * @param int $source
     * @return array|mixed
     */
    public function getParam($key, $defaultValue = null, $source = self::METHOD_GET)
    {
        if($source === self::METHOD_GET){
            return $this->get($key, $defaultValue);
        }

        return $this->post($key, $defaultValue);
    }

    public function getCookieValidationKey()
    {
        return $this->request->cookieValidationKey;
    }

    /**
     * @return bool
     */
    public function isAjax()
    {
        return $this->request->isAjax;
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return $this->request->isPost;
    }

    /**
     * @return bool
     */
    public function isGet()
    {
        return $this->request->isGet;
    }

    /**
     * @param       $key
     * @param array $default_value
     * @return array|mixed|null
     */
    public function getArrayInt($key, array $default_value = [])
    {
        return $this->getParamArrayInt($key, self::METHOD_GET, $default_value);
    }

    /**
     * @param       $key
     * @param array $default_value
     * @return array|mixed|null
     */
    public function getArrayStr($key, array $default_value = [])
    {
        return $this->getParamArrayStr($key, self::METHOD_GET, $default_value);
    }

    /**
     * @param       $key
     * @param array $default_value
     * @return array|mixed|null
     */
    public function postArrayStr($key, array $default_value = [])
    {
        return $this->getParamArrayStr($key, self::METHOD_POST, $default_value);
    }

    /**
     * @param       $key
     * @param array $default_value
     * @return array|mixed|null
     */
    public function postArrayInt($key, array $default_value = [])
    {
        return $this->getParamArrayInt($key, self::METHOD_POST, $default_value);
    }

    /**
     * @param       $key
     * @param int   $source
     * @param array $default_value
     * @return array
     */
    protected function getParamArrayInt($key, $source = self::METHOD_GET, array $default_value = [])
    {
        $value = $this->getParam($key, $source);
        if (!is_array($value)) {
            return $default_value;
        }
        $items = [];
        foreach ($value as $k => $val) {
            if (is_numeric($val)) {
                $val_int   = (int)$val;
                $items[$k] = $val_int;
            }
        }

        return $items;
    }

    /**
     * @param       $key
     * @param int   $source
     * @param array $default_value
     * @return array
     */
    protected function getParamArrayStr($key, $source = self::METHOD_GET, array $default_value = [])
    {
        $value = $this->getParam($key, $source);
        if (!is_string($value)) {
            return $default_value;
        }

        $items   = [];
        $sale_id = trim($value);

        if (preg_match('/^([^,\s\"\'\\\]+\s*,?\s*)+$/', $sale_id)) {
            $sale_id = preg_split('/[\s,]+/', $sale_id);
        }

        $sale_id = is_array($sale_id) ? $sale_id : [];

        foreach ($sale_id as $k => $val) {
            if (is_string($val)) {
                $val_int   = (string)$val;
                $items[$k] = $val_int;
            }
        }

        return $items;
    }
}