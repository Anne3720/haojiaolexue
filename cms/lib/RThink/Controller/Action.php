<?php

/**
 * Controller action 抽象类
 */
abstract class RThink_Controller_Action
{
    /**
     *
     * @var 控制器存在的方法
     */
    protected $_class_methods;

    /**
     * 控制器实例化是请求参数
     *
     * @var array
     */
    protected $_invoke_args = array();

    /**
     * 前端控制器实例
     *
     * @var Sys_Controller_Front
     */
    protected $_front_controller = null;

    /**
     * Sys_Controller_Request 对象 包含着请求环境
     *
     * @var Sys_Controller_Request
     */
    protected $_request = null;

    /**
     * Sys_Controller_Response 对象包含着相应对象
     *
     * @var Sys_Controller_Response
     */
    protected $_response = null;

    /**
     * 视图文件后缀名 '.phtml'
     *
     * @see {render()}
     * @var string
     */
    protected $_view_suffix = '.phtml';

    /**
     * 视图布局文件
     *
     * @see {render()}
     * @var string
     */
    public $view_layout = '';

    /**
     * 视图文件
     *
     * @see {render()}
     * @var string
     */
    public $view = null;


    /**
     * 注册请求、相应对象（及附加请求参数）
     *
     * @param RThink_Controller_Request $request
     * @param RThink_Controller_Response $response
     * @param array $invoke_args 附加调用参数
     * @return void
     */
    public function __construct(RThink_Controller_Request $request, RThink_Controller_Response $response, array $_invoke_args = array())
    {
        $this->setRequest($request)->setResponse($response)->_setInvokeArgs($_invoke_args);
//        $this->init();
    }

    /**
     * 对实例进行初始操作
     *
     * @return void
     */
    public function init()
    {
        if ($this->getInvokeArg('global_action_properties')) {

            foreach ($this->getInvokeArg('global_action_properties') as $property) {
                class_exists($property['class'], false) || require $property['class'] . '.php';
                $this->$property['property_name'] = new $property['class'];
            }
        }
    }

    /**
     * 初始视图 It uses this to set the following: - script path = views/scripts/
     *
     * @return ControllerSmarty
     * @throws RThink_Controller_Exception 如果视图目录不存在
     */
    public function initView($template_resource)
    {
        $this->view = new stdClass();

        $request = $this->getRequest();
        $module = $request->getModuleName();

//        $dirs = $this->getFrontController()->getControllerDirectory();

//        $default_module = $this->getFrontController()->getDispatcher()->getDefaultModule();


//        if (empty ($module) || !isset ($dirs [$module])) {
//            $module = $default_module;
//        }

//        $view_path = $this->getInvokeArg('view_path');
        $dispatcher = $this->getFrontController()->getDispatcher();
        $app_dir = $dispatcher->getControllerDirectory();
        $view_path = $app_dir . DIRECTORY_SEPARATOR . 'views';

        $controller_name = strtolower(str_replace($dispatcher->_word_delimiter, '', $this->getRequest()->getControllerName()));

        if ('' == $template_resource) {
            $template_resource = $this->getInvokeArg('view_name');
        }

        if ($module == $dispatcher->getDefaultModule()) {
            $template_resource = $view_path . DIRECTORY_SEPARATOR . strtolower($controller_name . DIRECTORY_SEPARATOR . $template_resource) . $this->_view_suffix;
        } else {
            $template_resource = $view_path . DIRECTORY_SEPARATOR . strtolower($module . DIRECTORY_SEPARATOR . $controller_name . DIRECTORY_SEPARATOR . $template_resource) . $this->_view_suffix;
        }

        if (!file_exists($template_resource)) {
            class_exists('RThink_Controller_Exception', false) || require 'RThink/Controller/Exception.php';
            throw new RThink_Controller_Exception ('模版文件{'.$template_resource.'}不存在！');
        }

        $this->view->template = $template_resource;

        $layout = $this->getInvokeArg('layout');

        if (null != $layout) {
//            $layout_arr = explode('.', $layout);
//
//            if (count($layout_arr) == 1) {
//                array_unshift($layout_arr, $default_module);
//            }
//
//            $layout = array_pop($layout_arr);

//            $layout = $this->getInvokeArg('layout_path') . DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, $layout_arr) . DIRECTORY_SEPARATOR . $layout . $this->_view_suffix;
            $layout = $app_dir . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . $layout . $this->_view_suffix;

            if (!file_exists($layout)) {
                class_exists('RThink_Controller_Exception', false) || require 'RThink/Controller/Exception.php';
                throw new RThink_Controller_Exception ('Layout文件{'.$layout.'}不存在！');
            }

            $this->view_layout = $layout;

            $this->setInvokeArg('layout', null);
        }
    }

    /**
     * 渲染视图 视图默认存放在views/<module>/<Controller>/<action>.html. You may
     * change the script suffix by 重置视图文件后缀{@link $view_suffix} By default, the
     * rendered contents are appended to the Response. You may specify the named
     * body content segment to set by specifying a $name.
     *
     * @param string $template_resource 模版资源
     * @param array $params 视图参数
     * @param boolean $append_body
     * @return Ambigous <string, void, string>
     */
    public function render(array $params = array(), $template_resource = '', $append_body = true)
    {
        $this->initView($template_resource);

        if ('' != $this->view_layout) {
            $params['layout_content'] = $this->view->template;
        }

        extract($params, EXTR_OVERWRITE);

        ob_start();

        if ('' != $this->view_layout) {
            include $this->view_layout;
        } else {
            include $this->view->template;
        }


        if ($append_body) {
            $this->getResponse()->appendBody(ob_get_clean());
        } else {
            return ob_get_clean();
        }
    }

    /**
     * 获取请求对象
     *
     * @return RThink_Controller_Request
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * 设置请求对象
     *
     * @param RThink_Controller_Request $requrest
     * @return RThink_Controller_Action
     */
    public function setRequest(RThink_Controller_Request $requrest)
    {
        $this->_request = $requrest;
        return $this;
    }

    /**
     * 获取响应对象
     *
     * @return RThink_Controller_Response
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * 设置响应对象
     *
     * @param RThink_Controller_Response $response
     * @return RThink_Controller_Action
     */
    public function setResponse(RThink_Controller_Response $response)
    {
        $this->_response = $response;
        return $this;
    }

    /**
     * 设置action调用参数
     *
     * @param array $args
     * @return RThink_Controller_Action
     */
    protected function _setInvokeArgs(array $args = array())
    {
        $this->_invoke_args = $args;
        return $this;
    }

    /**
     * 设置action调用参数
     *
     * @$name 参数名 string
     * @value 参数值 mix
     * @return RThink_Controller_Action
     */
    public function setInvokeArg($name, $value)
    {
        $name = strval($name);
        $this->_invoke_args[$name] = $value;
        return $this;
    }

    /**
     * 获取调用参数(minus the Request object)
     *
     * @return array
     */
    public function getInvokeArgs()
    {
        return $this->_invoke_args;
    }

    /**
     * 获取指定键名的参数，不存在则返回null
     *
     * @param string $name
     * @return mixed
     */
    public function getInvokeArg($name)
    {
        if (isset ($this->_invoke_args [$name])) {
            return $this->_invoke_args [$name];
        }

        return null;
    }


    /**
     * Gets a parameter from the {@link $_request Request object}.  If the
     * parameter does not exist, NULL will be returned.
     *
     * If the parameter does not exist and $default is set, then
     * $default will be returned instead of NULL.
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    protected function _getParam($name, $default = null)
    {
        $value = $this->getRequest()->getParam($name);
        if ((null === $value || '' === $value) && (null !== $default)) {
            $value = $default;
        }

        return $value;
    }

    /**
     * Set a parameter in the {@link $_request Request object}.
     *
     * @param string $name
     * @param mixed $value
     * @return RThink_Controller_Action
     */
    protected function _setParam($name, $value)
    {
        $this->getRequest()->setParam($name, $value);

        return $this;
    }


    /**
     * 获取前端控制器
     *
     * @return RThink_Controller_Front
     */
    public function getFrontController()
    {
        // Used cache version if found
        if (null === $this->_front_controller) {
            class_exists('RThink_Controller_Front') || require 'RThink/Controller/Front.php';
            $this->_front_controller = RThink_Controller_Front::getInstance();
        }

        return $this->_front_controller;
    }

    /**
     * 未定义方法的代理.默认抛出异常
     */
    public function __call($methodName, $args)
    {
        class_exists('RThink_Controller_Action_Exception', false) || require 'RThink/Controller/Action/Exception.php';

        if ('Action' == substr($methodName, -6)) {
            $action = substr($methodName, 0, strlen($methodName) - 6);
            throw new RThink_Controller_Action_Exception (sprintf('Action "%s" does not exist and was not trapped in __call()', $action), 404);
        }

        throw new RThink_Controller_Action_Exception (sprintf('Method "%s" does not exist and was not trapped in __call()', $methodName), 500);
    }

    /**
     * Pre-dispatch routines Called before action method. If using class with
     * {@link Zend_Controller_Front}, it may modify the {@link $_request Request
     * object} and reset its dispatched flag in order to skip processing the
     * current action.
     *
     * @return void
     */
    public function preDispatch()
    {
    }

    /**
     * Post-dispatch routines Called after action method execution. If using
     * class with {@link Zend_Controller_Front}, it may modify the {@link
     * $_request Request object} and reset its dispatched flag in order to
     * process an additional action. Common usages for postDispatch() include
     * rendering content in a sitewide template, link url correction, setting
     * headers, etc.
     *
     * @return void
     */
    public function postDispatch()
    {
    }

    /**
     * 分发请求动作
     *
     * @param string $action 动作控制器的方法名
     * @return void
     */
    public function dispatch($action)
    {

        $this->preDispatch();

        if ($this->getRequest()->isDispatched()) {
            if (null === $this->_class_methods) {
                $this->_class_methods = get_class_methods($this);
            }

            // preDispatch() didn't change the action, so we can continue
            if (in_array($action, $this->_class_methods, true)) {
                $this->$action ();
            } else {
                $this->__call($action, array());
            }

            $this->postDispatch();
        }

        // whats actually important here is that this action Controller is
        // shutting down, regardless of dispatching; notify the helpers of this
        // state
    }

    /**
     * Forward to another Controller/action. It is important to supply the
     * unformatted names, i.e. "article" rather than "ArticleController". The
     * Dispatcher will do the appropriate formatting when the Request is
     * received. If only an action name is provided, forwards to that action in
     * this Controller. If an action and Controller are specified, forwards to
     * that action and Controller in this module. Specifying an action,
     * Controller, and module is the most specific way to forward. A fourth
     * argument, $params, will be used to set the Request parameters. If either
     * the Controller or module are unnecessary for forwarding, simply pass null
     * values for them before specifying the parameters.
     *
     * @param string $action
     * @param string $controller
     * @param string $module
     * @param array $params
     * @return void
     */
    final protected function _forward($action, $controller = null, $module = null, array $params = null)
    {
        $request = $this->getRequest();

        if (null !== $params) {
            $request->setParams($params);
        }

        if (null !== $controller) {
            $request->setControllerName($controller);

            // Module should only be reset if Controller has been specified
            if (null !== $module) {
                $request->setModuleName($module);
            }
        }

        $request->setActionName($action)->setDispatched(false);
    }


    /**
     * 请求重定向
     *
     *
     * @param string $url
     * @param array $options 重定向使用的参数
     * @return void
     */
    protected function _redirect($url, array $options = array())
    {
        if (isset($options['code'])) {
            $this->_checkCode($options['code']);
        } else {
            $options['code'] = 302;
        }

        if (isset($options['exit']) && $options['exit']) {
            // Close session, if started
            if (class_exists('Zend_Session', false) && Zend_Session::isStarted()) {
                Zend_Session::writeClose();
            } else if (isset($_SESSION)) {
                session_commit();
            }
        }

        $this->_response->setRedirect($url, $options['code']);
    }


    /**
     * 校验HTTP请求转发状态码的有效性
     *
     * @param  int $code
     * @throws RThink_Controller_Action_Exception
     * @return true
     */
    protected function _checkCode($code)
    {
        $code = intval($code);
        if ((300 > $code) || (307 < $code) || (304 == $code) || (306 == $code)) {
            class_exists('RThink_Controller_Action_Exception', false) || require 'RThink/Controller/Action/Exception.php';
            throw new RThink_Controller_Action_Exception('Invalid redirect HTTP status code (' . $code . ')');
        }

        return true;
    }
}