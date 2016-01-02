<?php

/**
 * 分发器
 */
class RThink_Controller_Dispatcher
{

    /**
     * 默认action
     *
     * @var string
     */
    protected $_default_action = 'index';

    /**
     * 默认controller
     *
     * @var string
     */
    protected $_default_controller = 'index';

    /**
     * 默认module
     *
     * @var string
     */
    protected $_default_module = 'default';

    /**
     * 前端控制器实例
     *
     * @var RThink_Controller_Front
     */
    protected $_front_controller;

    /**
     * 实例化动作控制器时的调用参数
     *
     * @var array
     */
    protected $_invoke_params = array();

    /**
     * 传入动作控制器的请求对象
     *
     * @var Sys_Controller_Response
     */
    protected $_response = null;

    /**
     * 单词分割符
     *
     * @var array
     */
    public $_word_delimiter = array('-', '.');

    /**
     * 当前分发的目录
     *
     * @var string
     */
    protected $_current_dir = '';

    /**
     * 当前模块(formatted)
     *
     * @var string
     */
    protected $_current_module;

    /**
     * 构造方法 将默认模块设置为当前模块
     *
     * @param array $params
     * @return void
     */
    public function __construct(array $params = array())
    {
        $this->setParams($params);
        $this->_current_module = $this->_default_module;
    }


    /**
     * 获取当前动作控制器的路径 如果指定了模块则返回指定模块的下的动控制器路径
     *
     * @param string $module Module name
     * @return array string array of all directories by default, single module
     *         directory if module argument provided
     */
    public function getControllerDirectory()
    {
        if ('' == $this->_current_dir) {
            $this->_current_dir = APP_PATH . '/app';
        }

        return $this->_current_dir;
    }


    /**
     * 如果request对象可以被分到一个控制器则返回true
     * Use this method wisely. By default, the Dispatcher will fall back to the
     * default Controller (either in the module specified or the global default)
     * if a given Controller does not exist. This method returning false does
     * not necessarily indicate the Dispatcher will not still dispatch the call.
     *
     * @param RThink_Controller_Request $action
     * @return false | string
     */
    public function isDispatchable(RThink_Controller_Request $request)
    {
        $this->_current_dir = $this->getControllerDirectory();
        $this->_current_module = $request->getModuleName();
        $class_name = $this->getControllerClass($request);

        if (class_exists($class_name, false)) {
            return $class_name;
        }

        if ($this->_current_module != $this->_default_module) {
           // $load_file = $this->_current_dir . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $this->_current_module . DIRECTORY_SEPARATOR . $this->_formatName($request->getControllerName()) . '.php';
            $load_file = $this->_current_dir . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $this->_formatName($this->_current_module, true) . DIRECTORY_SEPARATOR . $this->_formatName($request->getControllerName()) . '.php';
        } else {
            $load_file = $this->_current_dir . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $this->_formatName($request->getControllerName()) . '.php';
        }

        if (!is_readable($load_file)) {
            return false;
        }

        class_exists($class_name, false) || require $load_file;

        if (!class_exists($class_name, false)) {
            return false;
        }

        return $class_name;
    }

    /**
     * 分发到一个 Controller/action 指定的动作分发器不能分发则抛出异常
     *
     * @param RThink_Controller_Request $request
     * @param RThink_Controller_Response $response
     * @return void
     * @throws RThink_Controller_Dispatcher_Exception
     */
    public function dispatch(RThink_Controller_Request $request, RThink_Controller_Response $response)
    {
        $this->setResponse($response);

        /**
         * 获取动作控制器类
         */
        if (false == ($class_name = $this->isDispatchable($request))) {
            class_exists('RThink_Controller_Dispatcher_Exception', false) || require 'RThink/Controller/Dispatcher/Exception.php';
            throw new RThink_Controller_Dispatcher_Exception ('Invalid Controller class : ' . $this->getControllerClass($request));
        }

        /**
         * 实例化动作控制器 如果指定动作控制器不是RThink_Controller_Action的实例则抛出异常
         */
        $controller = new $class_name ($request, $response, $this->getParams());

        if (!($controller instanceof RThink_Controller_Action)) {
            class_exists('RThink_Controller_Dispatcher_Exception', false) || require 'RThink/Controller/Dispatcher/Exception.php';
            throw new RThink_Controller_Dispatcher_Exception ('Controller "' . $class_name . '" is not an instance of RThink_Controller_Action');
        }

        /**
         * 获取action名称
         */
        $action = $this->getActionMethod($request);
        $controller->setInvokeArg('view_name', substr($action, 0, -6));

        /**
         * Dispatch the method call
         */
        $request->setDispatched(true);

        // by default, buffer output
        $disable_ob = $this->getParam('disableOutputBuffering');

        $obLevel = ob_get_level();

        if (null === $disable_ob) {
            ob_start();
        }

        try {
            $controller->dispatch($action);
        } catch (Exception $e) {
            // Clean output buffer on error
            $curObLevel = ob_get_level();

            if ($curObLevel > $obLevel) {
                do {
                    ob_get_clean();
                    $curObLevel = ob_get_level();
                } while ($curObLevel > $obLevel);
            }
            throw $e;
        }

        if (empty ($disable_ob)) {
            $content = ob_get_clean();
            $response->appendBody($content);
        }

        // 销毁当前页的动作控制器实例和反射对象
        $controller = null;
    }

    /**
     * 获取控制器类名
     * Try Request first; if not found, try pulling from Request parameter; if
     * still not found, fallback to default
     *
     * @param RThink_Controller_Request $request
     * @return string false class name on success
     */
    public function getControllerClass(RThink_Controller_Request $request)
    {
        $controller_name = $request->getControllerName();

        $class_name = $this->formatControllerName($controller_name);

        return $class_name;
    }


    /**
     * 设定请求action名称
     * First attempt to retrieve from Request; then from Request params using
     * action key; default to default action
     * Returns formatted action name
     *
     * @param RThink_Controller_Request $request
     * @return string
     */
    public function getActionMethod(RThink_Controller_Request $request)
    {
        $action = $request->getActionName();
        if (empty ($action)) {
            $action = $this->_default_action;
            $request->setActionName($action);
        }

        return $this->formatActionName($action);
    }

    /**
     * 格式化动作控制名称
     *
     * @param string $unformatted
     * @return string
     */
    public function formatControllerName($unformatted)
    {
        if ($this->_current_module != $this->_default_module) {
            //return str_replace('/', '_', $this->_current_module) . '_' . $this->_formatName($unformatted) . 'Controller';
            return str_replace('/', '_', $this->_formatName($this->_current_module, true)) . '_' . $this->_formatName($unformatted) . 'Controller';
        } else {
            return $this->_formatName($unformatted) . 'Controller';
        }

    }

    /**
     * 格式化action名称
     * This is used to take a raw action name, such as one that would be stored
     * inside a Sys_Controller_Request object, and reformat into a proper method
     * name that would be found inside a class extending Sys_Controller_Action.
     *
     * @param string $unformatted
     * @return string
     */
    public function formatActionName($unformatted)
    {
        $formatted = $this->_formatName($unformatted);
        return strtolower(substr($formatted, 0, 1)) . substr($formatted, 1) . 'Action';
    }


    /**
     * Formats a string from a URI into a PHP-friendly name.
     * By default, replaces words separated by the word separator character(s)
     * with camelCaps. If $is_action is false, it also preserves replaces words
     * separated by the path separation character with an undersrthink, making the
     * following word Title cased. All non-alphanumeric characters are removed.
     *
     * @param string $unformatted
     * @param boolean $is_action Defaults to false
     * @return string
     */
    protected function _formatName($unformatted, $is_module = false)
    {
        $unformatted = str_replace($this->_word_delimiter, ' ', strtolower($unformatted));

        if ($is_module) {
            $unformatted_arr = explode('/', $unformatted);

            foreach ($unformatted_arr as &$unformatted_item) {
                $unformatted_item = preg_replace('/[^a-z0-9 ]/', '', $unformatted_item);
                $unformatted_item = str_replace(' ', '', ucwords($unformatted_item));
            }

            return join('/', $unformatted_arr);

        } else {
            $unformatted = preg_replace('/[^a-z0-9 ]/', '', $unformatted);
            return str_replace(' ', '', ucwords($unformatted));
        }
    }

    /**
     * 获取前端控制器实例
     *
     * @return RThink_Controller_Front
     */
    public function getFrontController()
    {
        if (null === $this->_front_controller) {
            class_exists('RThink_Controller_Front') || require 'RThink/Controller/Front.php';
            $this->_front_controller = RThink_Controller_Front::getInstance();
        }

        return $this->_front_controller;
    }

    /**
     * 添加/修改动作控制器的参数
     *
     * @param string $key
     * @param mixed $val
     * @return Sys_Controller_Dispatcher
     */
    public function setParam($name, $value)
    {
        $this->_invoke_params [$name] = $value;
        return $this;
    }

    /**
     * 设置传递给动作控制器构造方法的参数
     *
     * @param array $params
     * @return RThink_Controller_Dispatcher
     */
    public function setParams(array $params)
    {
        $this->_invoke_params = array_merge($this->_invoke_params, $params);

        return $this;
    }

    /**
     * 获取指定的动作控制器参数
     *
     * @param string $name
     * @return mixed
     */
    public function getParam($name)
    {
        if (isset ($this->_invoke_params [$name])) {
            return $this->_invoke_params [$name];
        }
        return null;
    }

    /**
     * 获取动作控制器实例化时的参数
     *
     * @return array
     */
    public function getParams()
    {
        return $this->_invoke_params;
    }


    /**
     * 设置传递给动作控制器的响应对象
     *
     * @param RThink_Controller_Response|null $response
     * @return RThink_Controller_Dispatcher
     */
    public function setResponse(RThink_Controller_Response $response = null)
    {
        $this->_response = $response;
        return $this;
    }

    /**
     * 获取注册的响应对象
     *
     * @return RThink_Controller_Response null
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * 获取默认的controller (minus formatting)
     *
     * @return string
     */
    public function getDefaultController()
    {
        return $this->_default_controller;
    }

    public function  getDefaultAction()
    {
        return $this->_default_action;
    }

    /**
     * 获取默认模块
     *
     * @return string
     */
    public function getDefaultModule()
    {
        return $this->_default_module;
    }
}
