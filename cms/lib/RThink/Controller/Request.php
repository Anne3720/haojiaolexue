<?php

/**
 * 请求控制器抽象类
 */
class RThink_Controller_Request
{

    /**
     * https协议
     *
     * @var string
     */
    const SCHEME_HTTPS = 'https';

    /**
     * http协议
     *
     * @var string
     */
    const SCHEME_HTTP = 'http';

    /**
     * 请求uri
     *
     * @var string
     */
    protected $_request_uri = null;

    /**
     * 请求url
     *
     * @var string
     */
    protected $_request_url = '';

	
    /**
     * Base URL of Request
     * @var string
     */
    protected $_base_url = null;

    /**
     * Base path of Request
     * @var string
     */
    protected $_base_path = null;


    /**
     * 请求的路径信息
     *
     * @var string
     */
    protected $_path_info = '';

    /**
     * 构造方法 设置请求的uri
     *
     * @param string $uri
     */
    public function __construct($uri = null)
    {
        $this->setRequestUri($uri);
    }

    /**
     * action分发标识
     *
     * @var boolean
     */
    protected $_dispatched = false;

    /**
     * 当前模块
     *
     * @var string
     */
    protected $_module;

    /**
     * 用来从params中检索module
     *
     * @var string
     */
    protected $_module_key = 'module';

    /**
     * 当前动作控制器
     *
     * @var string
     */
    protected $_controller;

    /**
     * 用来从params中检索controller
     *
     * @var string
     */
    protected $_controller_key = 'controller';

    /**
     * 当前动作
     *
     * @var string
     */
    protected $_action;

    /**
     * action key用来从params中检索action
     *
     * @var string
     */
    protected $_action_key = 'action';

    /**
     * 请求参数
     *
     * @var array
     */
    protected $_params = array();

    /**
     * 获取模块key
     *
     * @return string
     */
    public function getModuleKey()
    {
        return $this->_module_key;
    }

    /**
     * 获取控制器key
     *
     * @return string
     */
    public function getControllerKey()
    {
        return $this->_controller_key;
    }

    /**
     * 获取actionkey
     *
     * @return string
     */
    public function getActionKey()
    {
        return $this->_action_key;
    }

    /**
     * 获取模块名称
     *
     * @return string
     */
    public function getModuleName()
    {
        if (null === $this->_module) {
            $this->_module = $this->getParam($this->_module_key);
        }

        return $this->_module;
    }

    /**
     * 设置使用模块名称
     *
     * @param string $value
     * @return RThink_Controller_Request
     */
    public function setModuleName($value)
    {
        $this->_module = $value;
        return $this;
    }

    /**
     * 获取动作控制器名称
     *
     * @return string
     */
    public function getControllerName()
    {
        if (null === $this->_controller) {
            $this->_controller = $this->getParam($this->_controller_key);
        }

        return $this->_controller;
    }

    /**
     * 设置使用的动作控制器名称
     *
     * @param string $value
     * @return RThink_Controller_Request
     */
    public function setControllerName($value)
    {
        $this->_controller = $value;
        return $this;
    }

    /**
     * 获取action名称
     *
     * @return string
     */
    public function getActionName()
    {
        if (null === $this->_action) {
            $this->_action = $this->getParam($this->_action_key);
        }

        return $this->_action;
    }

    /**
     * 设置action名称
     *
     * @param string $value
     * @return RThink_Controller_Request
     */
    public function setActionName($value)
    {
        $this->_action = $value;
        /**
         *
         * @see ZF-3465
         */
        if (null === $value) {
            $this->clearParam($this->_action_key);
        }
        return $this;
    }


    /**
     * 清楚请求参数
     *
     * @param $name 参数名
     * @return $this
     */
    public function clearParam($name)
    {
        $name = strval($name);

        if (isset($this->_params[$name])) {
            unset($this->_params[$name]);
        }

        return $this;
    }

    /**
     * 设置请求参数
     *
     * @param string $key 参数键名
     * @param mixed $val 参数值
     * @return RThink_Controller_Request
     */
    public function setParam($key, $val)
    {
        if (null != $val) {
            $this->_params [$key] = $val;
        }
        return $this;
    }

    /**
     * 获取所有请求参数
     *
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * 设置请求的分发状态
     *
     * @param boolean $flag
     * @return RThink_Controller_Request
     */
    public function setDispatched($flag = true)
    {
        $this->_dispatched = $flag ? true : false;
        return $this;
    }

    /**
     * 确定请求是否已经分发
     *
     * @return boolean
     */
    public function isDispatched()
    {
        return $this->_dispatched;
    }

    /**
     * 禁用__get()方法，用getParam()方法替代
     *
     * @param string $key
     * @throws RThink_Controller_Request_Exception
     */
    public function __get($key)
    {
        require_once 'RThink/Controller/Request/Exception.php';
        throw new RThink_Controller_Request_Exception ("Getting values in superglobals not allowed; please use getParam()");
    }

    /**
     * 禁用__set()方法，用setParam()方法替代
     *
     * @param string $key
     * @param mixed $val
     * @throws RThink_Controller_Request_Exception
     */
    public function __set($key, $val)
    {
        require_once 'RThink/Controller/Request/Exception.php';
        throw new RThink_Controller_Request_Exception ("Setting values in superglobals not allowed; please use setParam()");
    }

    /**
     * 检查参数时候设置
     *
     * @param string $key
     * @return boolean
     */
    public function __isset($key)
    {
        switch (true) {
            case isset ($this->_params [$key]) :
                return true;
            case isset ($_GET [$key]) :
                return true;
            case isset ($_POST [$key]) :
                return true;
            case isset ($_COOKIE [$key]) :
                return true;
            case isset ($_SERVER [$key]) :
                return true;
            case isset ($_ENV [$key]) :
                return true;
            default :
                return false;
        }
    }

    /**
     * __isset()的别名
     *
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return $this->__isset($key);
    }

    /**
     * 获取制定key的请求参数 获取顺序 1.GET, 2. POST, 3. COOKIE, 4. SERVER, 5. ENV
     *
     * @param string $key 请求参数key名
     * @param mixed $default 默认值
     * @return $mixed
     */
    public function getParam($key, $default = null)
    {
        $key = strval($key);

        switch (true) {
            case isset ($this->_params [$key]) :
                return $this->_params [$key];
            case isset ($_GET [$key]) :
                return $_GET [$key];
            case isset ($_POST [$key]) :
                return $_POST [$key];
            case isset ($_COOKIE [$key]) :
                return $_COOKIE [$key];
            case ($key == 'REQUEST_URI') :
                return $this->getRequestUri();
            case ($key == 'PATH_INFO') :
                return $this->getPathInfo();
            case isset ($_SERVER [$key]) :
                return $_SERVER [$key];
            case isset ($_ENV [$key]) :
                return $_ENV [$key];
            default :
                return $default;
        }
    }

    /**
     * Retrieve a member of the $_GET superglobal
     *
     * If no $key is passed, returns the entire $_GET array.
     *
     * @todo How to retrieve from nested arrays
     * @param string $key
     * @param mixed $default Default value to use if key not found
     * @return mixed Returns null if key does not exist
     */
    public function getQuery($key = null, $default = null)
    {
        if (null === $key) {
            return $_GET;
        }

        return (isset($_GET[$key])) ? $_GET[$key] : $default;
    }

    /**
     * Retrieve a member of the $_POST superglobal If no $key is passed, returns
     * the entire $_POST array.
     *
     * @todo How to retrieve from nested arrays
     * @param string $key
     * @param mixed $default Default value to use if key not found
     * @return mixed Returns null if key does not exist
     */
    public function getPost($key = null, $default = null)
    {
        if (null === $key) {
            return $_POST;
        }

        return (isset ($_POST [$key])) ? $_POST [$key] : $default;
    }

    /**
     * Retrieve a member of the $_COOKIE superglobal If no $key is passed,
     * returns the entire $_COOKIE array.
     *
     * @todo How to retrieve from nested arrays
     * @param string $key
     * @param mixed $default Default value to use if key not found
     * @return mixed Returns null if key does not exist
     */
    public function getCookie($key = null, $default = null)
    {
        if (null === $key) {
            return $_COOKIE;
        }

        return (isset ($_COOKIE [$key])) ? $_COOKIE [$key] : $default;
    }

    /**
     * Retrieve a member of the $_SERVER superglobal If no $key is passed,
     * returns the entire $_SERVER array.
     *
     * @param string $key
     * @param mixed $default Default value to use if key not found
     * @return mixed Returns null if key does not exist
     */
    public function getServer($key = null, $default = null)
    {
        if (null === $key) {
            return $_SERVER;
        }

        return (isset ($_SERVER [$key])) ? $_SERVER [$key] : $default;
    }

    /**
     * Retrieve a member of the $_ENV superglobal If no $key is passed, returns
     * the entire $_ENV array.
     *
     * @param string $key
     * @param mixed $default Default value to use if key not found
     * @return mixed Returns null if key does not exist
     */
    public function getEnv($key = null, $default = null)
    {
        if (null === $key) {
            return $_ENV;
        }

        return (isset ($_ENV [$key])) ? $_ENV [$key] : $default;
    }

    /**
     * 设置http requet实例的请求uri If no Request URI is passed, uses the value in
     * $_SERVER['REQUEST_URI']
     *
     * @param string $request_uri
     * @return RThink_Controller_RequestHttp
     */
    public function setRequestUri($request_uri = null)
    {
        $request_uri = $_SERVER ['REQUEST_URI'];
        // Http代理请求用 scheme + host [+ port] + url path,只使用url path
        $scheme_http_host = $this->getScheme() . '://' . $this->getHttpHost();

        if (strpos($request_uri, $scheme_http_host) === 0) {
            $request_uri = substr($request_uri, strlen($scheme_http_host));
        }

        $this->_request_uri = $request_uri;

        return $this;
    }

    /**
     * 获取当前请求uri
     *
     * @return string
     */
    public function getRequestUri()
    {
        if (null === $this->_request_uri) {
            $this->setRequestUri();
        }

        return $this->_request_uri;
    }


  /**
     * Set the base URL of the Request; i.e., the segment leading to the script name
     *
     * E.g.:
     * - /admin
     * - /myapp
     * - /subdir/index.php
     *
     * Do not use the full URI when providing the base. The following are
     * examples of what not to use:
     * - http://example.com/admin (should be just /admin)
     * - http://example.com/subdir/index.php (should be just /subdir/index.php)
     *
     * If no $base_url is provided, attempts to determine the base URL from the
     * environment, using SCRIPT_FILENAME, SCRIPT_NAME, PHP_SELF, and
     * ORIG_SCRIPT_NAME in its determination.
     *
     * @param mixed $base_url
     * @return RThink_Controller_Request
     */
    public function setBaseUrl($base_url = null)
    {
        if ((null !== $base_url) && !is_string($base_url)) {
            return $this;
        }

        if ($base_url === null) {
            $filename = (isset($_SERVER['SCRIPT_FILENAME'])) ? basename($_SERVER['SCRIPT_FILENAME']) : '';

            if (isset($_SERVER['SCRIPT_NAME']) && basename($_SERVER['SCRIPT_NAME']) === $filename) {
                $base_url = $_SERVER['SCRIPT_NAME'];
            } elseif (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) === $filename) {
                $base_url = $_SERVER['PHP_SELF'];
            } elseif (isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $filename) {
                $base_url = $_SERVER['ORIG_SCRIPT_NAME']; // 1and1 shared hosting compatibility
            } else {
                // Backtrack up the script_filename to find the portion matching
                // php_self
                $path    = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '';
                $file    = isset($_SERVER['SCRIPT_FILENAME']) ? $_SERVER['SCRIPT_FILENAME'] : '';
                $segs    = explode('/', trim($file, '/'));
                $segs    = array_reverse($segs);
                $index   = 0;
                $last    = count($segs);
                $base_url = '';
                do {
                    $seg     = $segs[$index];
                    $base_url = '/' . $seg . $base_url;
                    ++$index;
                } while (($last > $index) && (false !== ($pos = strpos($path, $base_url))) && (0 != $pos));
            }

            // Does the base_url have anything in common with the request_uri?
            $request_uri = $this->getRequestUri();

            if (0 === strpos($request_uri, $base_url)) {
                // full $base_url matches
                $this->_base_url = $base_url;
                return $this;
            }

            if (0 === strpos($request_uri, dirname($base_url))) {
                // directory portion of $base_url matches
                $this->_base_url = rtrim(dirname($base_url), '/');
                return $this;
            }

            $truncated_request_uri = $request_uri;

            if (($pos = strpos($request_uri, '?')) !== false) {
                $truncated_request_uri = substr($request_uri, 0, $pos);
            }

            $basename = basename($base_url);
            if (empty($basename) || !strpos($truncated_request_uri, $basename)) {
                // no match whatsoever; set it blank
                $this->_base_url = '';
                return $this;
            }

            // If using mod_rewrite or ISAPI_Rewrite strip the script filename
            // out of base_url. $pos !== 0 makes sure it is not matching a value
            // from PATH_INFO or QUERY_STRING
            if ((strlen($request_uri) >= strlen($base_url))
                && ((false !== ($pos = strpos($request_uri, $base_url))) && ($pos !== 0)))
            {
                $base_url = substr($request_uri, 0, $pos + strlen($base_url));
            }
        }

        $this->_base_url = rtrim($base_url, '/');
        return $this;
    }


	  /**
     * Everything in REQUEST_URI before PATH_INFO
     * <form action="<?=$base_url?>/news/submit" method="POST"/>
     *
     * @return string
     */
    public function getBaseUrl($raw = false)
    {
        if (null === $this->_base_url) {
            $this->setBaseUrl();
        }

        return (($raw == false) ? urldecode($this->_base_url) : $this->_base_url);
    }


	public function setPathInfo($path_info = null)
    {
        if ($path_info === null) {
            $base_url = $this->getBaseUrl(); // this actually calls setBaseUrl() & setRequestUri()
            $base_url_raw = $this->getBaseUrl(false);
            $base_url_encoded = urlencode($base_url_raw);

            if (null === ($request_uri = $this->getRequestUri())) {
                return $this;
            }

            // Remove the query string from REQUEST_URI
            if ($pos = strpos($request_uri, '?')) {
                $request_uri = substr($request_uri, 0, $pos);
            }

            if (!empty($base_url) || !empty($base_url_raw)) {
                if (strpos($request_uri, $base_url) === 0) {
                    $path_info = substr($request_uri, strlen($base_url));
                } elseif (strpos($request_uri, $base_url_raw) === 0) {
                    $path_info = substr($request_uri, strlen($base_url_raw));
                } elseif (strpos($request_uri, $base_url_encoded) === 0) {
                    $path_info = substr($request_uri, strlen($base_url_encoded));
                } else {
                    $path_info = $request_uri;
                }
            } else {
                $path_info = $request_uri;
            }

        }

        $this->_path_info = (string) $path_info;
        return $this;
    }



    /**
     * Returns everything between the base_url and QueryString. This value is
     * calculated instead of reading PATH_INFO directly from $_SERVER due to
     * cross-platform differences.
     *
     * @return string
     */
	  public function getPathInfo()
      {
        if (empty($this->_path_info)) {
            $this->setPathInfo();
        }

        return $this->_path_info;
     }

/*
    public function getPathInfo()
    {
        if (empty ($this->_path_info)) {
            if (null === ($request_uri = $this->getRequestUri())) {
                return $this;
            }

            // Remove the query string from REQUEST_URI
            if ($pos = strpos($request_uri, '?')) {
                $request_uri = substr($request_uri, 0, $pos);
            }

        }

        $this->_path_info = strval($request_uri);

        return $this->_path_info;
    }
	*/


    /**
     * 获取发起请求的方法
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->getServer('REQUEST_METHOD');
    }

    /**
     * 是否是post方法请求
     *
     * @return boolean
     */
    public function isPost()
    {
        if ('POST' == $this->getMethod()) {
            return true;
        }

        return false;
    }

    /**
     * 是否是get方法请求
     *
     * @return boolean
     */
    public function isGet()
    {
        if ('GET' == $this->getMethod()) {
            return true;
        }

        return false;
    }

    /**
     * 时候是head的方法发起的请求
     *
     * @return boolean
     */
    public function isHead()
    {
        if ('HEAD' == $this->getMethod()) {
            return true;
        }

        return false;
    }

    /**
     * Is the Request a Javascript XMLHttpRequest? Should work with
     * Prototype/Script.aculo.us, possibly others.
     *
     * @return boolean
     */
    public function isXmlHttpRequest()
    {
        return ($this->getHeader('X_REQUESTED_WITH') == 'XMLHttpRequest');
    }

    /**
     * Is this a Flash Request?
     *
     * @return boolean
     */
    public function isFlashRequest()
    {
        $header = strtolower($this->getHeader('USER_AGENT'));
        return (strstr($header, ' flash')) ? true : false;
    }

    /**
     * 是否是https安全请求
     *
     * @return boolean
     */
    public function isSecure()
    {
        return ($this->getScheme() === self::SCHEME_HTTPS);
    }


    /**
     * Return the value of the given HTTP header. Pass the header name as the
     * plain, HTTP-specified header name. Ex.: Ask for 'Accept' to get the
     * Accept header, 'Accept-Encoding' to get the Accept-Encoding header.
     *
     * @param string $header HTTP header name
     * @return string false header value, or false if not found
     * @throws RThink_Controller_Request_Exception
     */
    public function getHeader($header)
    {
        if (empty ($header)) {
            require_once 'RThink/Controller/Request/Exception.php';
            throw new RThink_Controller_Request_Exception ('An HTTP header name is required');
        }

        // Try to get it from the $_SERVER array first
        $temp = 'HTTP_' . strtoupper(str_replace('-', '_', $header));
        if (isset ($_SERVER [$temp])) {
            return $_SERVER [$temp];
        }

        // This seems to be the only way to get the Authorization header on
        // Apache
        if (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            if (isset ($headers [$header])) {
                return $headers [$header];
            }
            $header = strtolower($header);
            foreach ($headers as $key => $value) {
                if (strtolower($key) == $header) {
                    return $value;
                }
            }
        }

        return false;
    }

    /**
     * 获取请求uri协议
     *
     * @return string
     */
    public function getScheme()
    {
        return ($this->getServer('HTTPS') == 'on') ? self::SCHEME_HTTPS : self::SCHEME_HTTP;
    }

    /**
     * 获取http头信息 "Host" ":" host [ ":" port ] ; Section 3.2.2 Note the HTTP Host
     * header is not the same as the URI host. It includes the port while the
     * URI host doesn't.
     *
     * @return string
     */
    public function getHttpHost()
    {
        $host = $this->getServer('HTTP_HOST');
        if (!empty ($host)) {
            return $host;
        }

        $scheme = $this->getScheme();
        $name = $this->getServer('SERVER_NAME');
        $port = $this->getServer('SERVER_PORT');

        if (null === $name) {
            return '';
        } else if (($scheme == self::SCHEME_HTTP && $port == 80) || ($scheme == self::SCHEME_HTTPS && $port == 443)) {
            return $name;
        } else {
            return $name . ':' . $port;
        }
    }

    /**
     * 获取客户端ip地址
     *
     * @param boolean $checkProxy
     * @return string
     */
    public function getClientIp($checkProxy = true)
    {
        if ($checkProxy && $this->getServer('HTTP_CLIENT_IP') != null) {
            $ip = $this->getServer('HTTP_CLIENT_IP');
        } else if ($checkProxy && $this->getServer('HTTP_X_FORWARDED_FOR') != null) {
            $ip = $this->getServer('HTTP_X_FORWARDED_FOR');
        } else {
            $ip = $this->getServer('REMOTE_ADDR');
        }

        return $ip;
    }
}