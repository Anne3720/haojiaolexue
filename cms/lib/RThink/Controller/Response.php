<?php

/**
 * 响应类
 */
class RThink_Controller_Response
{
    /**
     * Body content
     *
     * @var array
     */
    protected $_body = array();

    /**
     * Exception stack
     *
     * @var Exception
     */
    protected $_exceptions = array();

    /**
     * Array of headers. Each header is an array with keys 'name' and 'value'
     *
     * @var array
     */
    protected $_headers = array();


    /**
     * 响应头中使用的http请求状态码
     *
     * @var int
     */
    protected $_http_response_code = 200;

    /**
     * 当前相应是否为重定向
     *
     * @var boolean
     */
    protected $_is_redirect = false;

    /**
     * Whether or not to render exceptions; off by default
     *
     * @var boolean
     */
    protected $_render_exceptions = false;


    /**
     * 向相应对象中注册异常对象
     *
     * @param Exception $e
     * @return RThink_Controller_Response
     */
    public function setException(Exception $e)
    {
        $this->_exceptions [] = $e;
        return $this;
    }


    /**
     * 格式化头信息名 Normalizes a header name to X-Capitalized-Names
     *
     * @param string $name
     * @return string
     */
    protected function _normalizeHeader($name)
    {
        $filtered = str_replace(array(
            '-',
            '_'
        ), ' ', ( string )$name);
        $filtered = ucwords(strtolower($filtered));
        $filtered = str_replace(' ', '-', $filtered);
        return $filtered;
    }

    /**
     * 设置头信息 If $replace is true, replaces any headers already defined with that
     * $name.
     *
     * @param string $name
     * @param string $value
     * @param boolean $replace
     * @return RThink_Controller_Response
     */
    public function setHeader($name, $value, $replace = false)
    {
        $this->canSendHeaders(true);
        $name = $this->_normalizeHeader($name);
        $value = strval($value);

        if ($replace) {
            foreach ($this->_headers as $key => $header) {
                if ($name == $header ['name']) {
                    unset ($this->_headers [$key]);
                }
            }
        }

        $this->_headers [] = array(
            'name' => $name,
            'value' => $value,
            'replace' => $replace
        );

        return $this;
    }

    /**
     * 设置重定向url Sets Location header and Response code. Forces replacement of
     * any prior redirects.
     *
     * @param string $url
     * @param int $code
     * @return RThink_Controller_Response
     */
    public function setRedirect($url, $code = 302)
    {
        $this->canSendHeaders(true);
        $this->setHeader('Location', $url, true)->setHttpResponseCode($code);

        return $this;
    }

    /**
     * 当前是否是重定向
     *
     * @return boolean
     */
    public function isRedirect()
    {
        return $this->_is_redirect;
    }

    /**
     * 获取头信息
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->_headers;
    }

    /**
     * 设置头信息使用的HTTP响应状态码
     *
     * @param int $code
     * @return RThink_Controller_Response
     */
    public function setHttpResponseCode($code)
    {
        if (!is_int($code) || (100 > $code) || (599 < $code)) {
            class_exists('RThink_Controller_Response_Exception', false) || require 'RThink/Controller/Response/Exception.php';
            throw new RThink_Controller_Response_Exception ('Invalid HTTP Response code');
        }

        if ((300 <= $code) && (307 >= $code)) {
            $this->_is_redirect = true;
        } else {
            $this->_is_redirect = false;
        }

        $this->_http_response_code = $code;
        return $this;
    }

    /**
     * 获取http状态响应码
     *
     * @return int
     */
    public function getHttpResponseCode()
    {
        return $this->_http_response_code;
    }

    /**
     * 是否发送头信息
     *
     * @param boolean $throw 在头信息已经发送后是否可以抛出异常
     * @return boolean
     * @throws RThink_Controller_Response_Exception
     */
    public function canSendHeaders($throw = false)
    {
        $ok = headers_sent($file, $line);
        if ($ok && $throw) {
            class_exists('RThink_Controller_Response_Exception', false) || require 'RThink/Controller/Response/Exception.php';
            throw new RThink_Controller_Response_Exception ('Cannot send headers; headers already sent in ' . $file . ', line ' . $line);
        }

        return !$ok;
    }

    /**
     * Send all headers Sends any headers specified. If an {@link
     * setHttpResponseCode() HTTP Response code} has been specified, it is sent
     * with the first header.
     *
     * @return RThink_Controller_Response
     */
    public function sendHeaders()
    {
        // Only check if we can send headers if we have headers to send
        if (count($this->_headers) || (200 != $this->_http_response_code)) {
            $this->canSendHeaders(true);
        } else if (200 == $this->_http_response_code) {
            // Haven't changed the Response code, and we have no headers
            return $this;
        }

        $http_code_sent = false;

        foreach ($this->_headers as $header) {
            if (!$http_code_sent && $this->_http_response_code) {
                header($header ['name'] . ': ' . $header ['value'], $header ['replace'], $this->_http_response_code);
                $http_code_sent = true;
            } else {
                header($header ['name'] . ': ' . $header ['value'], $header ['replace']);
            }
        }

        if (!$http_code_sent) {
            header('HTTP/1.1 ' . $this->_http_response_code);
            $http_code_sent = true;
        }

        return $this;
    }


    /**
     * Append content to the body content
     *
     * @param string $content
     * @param null|string $name
     * @return RThink_Controller_Response
     */
    public function appendBody($content, $name = null)
    {
        if ((null === $name) || !is_string($name)) {
            if (isset ($this->_body ['default'])) {
                $this->_body ['default'] .= ( string )$content;
            } else {
                return $this->append('default', $content);
            }
        } else if (isset ($this->_body [$name])) {
            $this->_body [$name] .= ( string )$content;
        } else {
            return $this->append($name, $content);
        }

        return $this;
    }

    /**
     * Return the body content If $spec is false, returns the concatenated
     * values of the body content array. If $spec is boolean true, returns the
     * body content array. If $spec is a string and matches a named segment,
     * returns the contents of that segment; otherwise, returns null.
     *
     * @param boolean $spec
     * @return string array null
     */
    public function getBody($spec = false)
    {
        if (false === $spec) {
            ob_start();
            $this->outputBody();
            return ob_get_clean();
        } else if (true === $spec) {
            return $this->_body;
        } else if (is_string($spec) && isset ($this->_body [$spec])) {
            return $this->_body [$spec];
        }

        return null;
    }

    /**
     * Append a named body segment to the body content array If segment already
     * exists, replaces with $content and places at end of array.
     *
     * @param string $name
     * @param string $content
     * @return RThink_Controller_Response
     */
    public function append($name, $content)
    {
        if (!is_string($name)) {
            class_exists('RThink_Controller_Response_Exception', false) || require 'RThink/Controller/Response/Exception.php';
            throw new RThink_Controller_Response_Exception ('Invalid body segment key ("' . gettype($name) . '")');
        }

        if (isset ($this->_body [$name])) {
            unset ($this->_body [$name]);
        }
        $this->_body [$name] = ( string )$content;
        return $this;
    }

    /**
     * Prepend a named body segment to the body content array If segment already
     * exists, replaces with $content and places at top of array.
     *
     * @param string $name
     * @param string $content
     * @return void
     */
    public function prepend($name, $content)
    {
        if (!is_string($name)) {
            class_exists('RThink_Controller_Response_Exception', false) || require 'RThink/Controller/Response/Exception.php';
            throw new RThink_Controller_Response_Exception ('Invalid body segment key ("' . gettype($name) . '")');
        }

        if (isset ($this->_body [$name])) {
            unset ($this->_body [$name]);
        }

        $new = array(
            $name => ( string )$content
        );
        $this->_body = $new + $this->_body;

        return $this;
    }

    /**
     * Insert a named segment into the body content array
     *
     * @param string $name
     * @param string $content
     * @param string $parent
     * @param boolean $before Whether to insert the new segment before or after
     *            the parent. Defaults to false (after)
     * @return RThink_Controller_Response
     */
    public function insert($name, $content, $parent = null, $before = false)
    {
        if (!is_string($name)) {
            class_exists('RThink_Controller_Response_Exception', false) || require 'RThink/Controller/Response/Exception.php';
            throw new RThink_Controller_Response_Exception ('Invalid body segment key ("' . gettype($name) . '")');
        }

        if ((null !== $parent) && !is_string($parent)) {
            class_exists('RThink_Controller_Response_Exception', false) || require 'RThink/Controller/Response/Exception.php';
            throw new RThink_Controller_Response_Exception ('Invalid body segment parent key ("' . gettype($parent) . '")');
        }

        if (isset ($this->_body [$name])) {
            unset ($this->_body [$name]);
        }

        if ((null === $parent) || !isset ($this->_body [$parent])) {
            return $this->append($name, $content);
        }

        $ins = array(
            $name => ( string )$content
        );
        $keys = array_keys($this->_body);
        $loc = array_search($parent, $keys);
        if (!$before) {
            // Increment location if not inserting before
            ++$loc;
        }

        if (0 === $loc) {
            // If location of key is 0, we're prepending
            $this->_body = $ins + $this->_body;
        } else if ($loc >= (count($this->_body))) {
            // If location of key is maximal, we're appending
            $this->_body = $this->_body + $ins;
        } else {
            // Otherwise, insert at location specified
            $pre = array_slice($this->_body, 0, $loc);
            $post = array_slice($this->_body, $loc);
            $this->_body = $pre + $ins + $post;
        }

        return $this;
    }

    /**
     * Echo the body segments
     *
     * @return void
     */
    public function outputBody()
    {
        $body = implode('', $this->_body);
        echo $body;
    }

    /**
     * Retrieve the exception stack
     *
     * @return array
     */
    public function getException()
    {
        return $this->_exceptions;
    }

    /**
     * Has an exception been registered with the Response?
     *
     * @return boolean
     */
    public function isException()
    {
        return !empty ($this->_exceptions);
    }


    /**
     * Whether or not to render exceptions (off by default) If called with no
     * arguments or a null argument, returns the value of the flag; otherwise,
     * sets it and returns the current value.
     *
     * @param boolean $flag Optional
     * @return boolean
     */
    public function renderExceptions($flag = null)
    {
        if (null !== $flag) {
            $this->_render_exceptions = $flag ? true : false;
        }

        return $this->_render_exceptions;
    }

    /**
     * Send the Response, including all headers, rendering exceptions if so
     * requested.
     *
     * @return void
     */
    public function sendResponse()
    {
        $this->sendHeaders();

        if ($this->isException() && $this->renderExceptions()) {
            $exceptions = '';
            foreach ($this->getException() as $e) {
                $exceptions .= $e->__toString() . "\n";
            }
            echo $exceptions;
            return;
        }

        $this->outputBody();
    }

    /**
     * Magic __toString functionality Proxies to {@link sendResponse()} and
     * returns Response value as string using output buffering.
     *
     * @return string
     */
    public function __toString()
    {
        ob_start();
        $this->sendResponse();
        return ob_get_clean();
    }
}