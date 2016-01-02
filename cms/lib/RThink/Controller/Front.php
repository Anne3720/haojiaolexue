<?php
require_once 'RThink/Controller/Plugin/Broker.php';

/**
 * 前端控制器
 */
class RThink_Controller_Front
{

    /**
     * 派遣器 实例
     *
     * @var RThink_Controller_Dispatcher
     */
    protected $_dispatcher = null;

    /**
     * 前端控制器单例实例
     *
     * @var RThink_Controller_Front
     */
    protected static $_instance = null;

    /**
     * 实例化动作控制器的请求参数
     *
     * @var array
     */
    protected $_invoke_params = array();

    /**
     * RThink_Controller_Plugin_Broker实例
     *
     * @var RThink_Controller_Plugin_Broker
     */
    protected $_plugins = null;

    /**
     * RThink_Controller_Request 实例
     *
     * @var RThink_Controller_Request
     */
    protected $_request = null;

    /**
     * RThink_Controller_Response 实例
     *
     * @var RThink_Controller_Response
     */
    protected $_response = null;

    /**
     * 派遣时是否在渲染输出之前返回响应对象 默认发送头信息和渲染输出 {@link dispatch()}
     *
     * @var boolean
     */
    protected $_return_response = false;

    /**
     * 路由器实例
     *
     * @var RThink_Controller_Router
     */
    protected $_router = null;

    /**
     * 发生异常时直接抛出还是将异常信息收集在响应对象中 {@link dispatch()}
     *
     * @var boolean
     */
    protected $_throw_exceptions = false;

    /**
     * 构造方法 实例化 Plugin broker.
     *
     * @return void
     */
    protected function __construct()
    {
        $this->_plugins = new RThink_Controller_Plugin_Broker();
    }

    /**
     * 禁止克隆，强制使用单例
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * 获取单例
     *
     * @return RThink_Controller_Front
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self ();
            spl_autoload_register(array(self::$_instance, 'loader'));
        }

        return self::$_instance;
    }


    /**
     * 获取动作控制器目录指定模块控制器目录 当$module_name为null时返回所有的目录
     *
     * @param string $module_name 模块名 默认 null
     * @return array string null
     */
    public function getControllerDirectory($module_name = null)
    {
        return $this->getDispatcher()->getControllerDirectory($module_name);
    }

    /**
     * 获取请求对象
     *
     * @return RThink_Controller_Request
     */
    public function getRequest()
    {
        if (null === $this->_request) {
            class_exists('RThink_Controller_Request', false) || require 'RThink/Controller/Request.php';
            $this->_request = new RThink_Controller_Request();
        }
        return $this->_request;
    }

    /**
     * 获取响应对象
     *
     * @return RThink_Controller_Response
     */
    public function getResponse()
    {
        if (null === $this->_response) {
            class_exists('RThink_Controller_Response', false) || require 'RThink/Controller/Response.php';
            $this->_response = new RThink_Controller_Response ();
        }
        return $this->_response;
    }

    /**
     * 获取路由器对象
     *
     * @return RThink_Controller_Router
     */
    public function getRouter()
    {
        if (null === $this->_router) {
            class_exists('RThink_Controller_Router', false) || require 'RThink/Controller/Router.php';
            $this->_router = new RThink_Controller_Router ();
        }
        return $this->_router;
    }

    /**
     * 获取派遣器对象
     *
     * @return RThink_Controller_Dispatcher
     */
    public function getDispatcher()
    {
        if (null === $this->_dispatcher) {
            class_exists('RThink_Controller_Dispatcher', false) || require 'RThink/Controller/Dispatcher.php';
            $this->_dispatcher = new RThink_Controller_Dispatcher();
        }
        return $this->_dispatcher;
    }

    /**
     * 添加/修改实例化动作控制器时的参数
     *
     * @param string $name
     * @param mixed $value
     * @return RThink_Controller_Front
     */
    public function setParam($name, $value)
    {
        $name = strval($name);
        $this->_invoke_params [$name] = $value;
        return $this;
    }

    /**
     * 设置传提给动作控制器构造方法的参数
     *
     * @param array $params
     * @return RThink_Controller_Front
     */
    public function setParams(array $params)
    {
        $this->_invoke_params = array_merge($this->_invoke_params, $params);
        return $this;
    }

    /**
     * 获取动作控制器参数
     *
     * @param string $name
     * @return mixed
     */
    public function getParam($name)
    {
        $name = strval($name);

        if (isset ($this->_invoke_params [$name])) {
            return $this->_invoke_params [$name];
        }

        return null;
    }

    /**
     * 获取实例化动作控制器时的参数
     *
     * @return array
     */
    public function getParams()
    {
        return $this->_invoke_params;
    }

    /**
     * 设置抛出异常标识 and 获取异常标识 设置在派遣中异常抛出还是分装在response对象中,默认分装在response对象
     *
     * @param boolean $flag
     * @return boolean RThink_Controller_Front
     */
    public function throwExceptions($flag = null)
    {
        if ($flag !== null) {
            $this->_throw_exceptions = ( bool )$flag;
            return $this;
        }

        return $this->_throw_exceptions;
    }

    /**
     * Set whether {@link dispatch()} should return the Response without first
     * rendering output. By default, output is rendered and dispatch() returns
     * nothing.
     *
     * @param boolean $flag
     * @return boolean RThink_Controller_Front as a setter, returns object; as a getter,
     *         returns boolean
     */
    public function returnResponse($flag = null)
    {
        if (true === $flag) {
            $this->_return_response = true;
            return $this;
        } else if (false === $flag) {
            $this->_return_response = false;
            return $this;
        }

        return $this->_return_response;
    }

    /**
     * 派遣请求到 Controller/action.
     *  处理线索 dispatch(RThink_Controller_Front) ->dispatch(RThink_Controller_DispatcherStandard) -> dispatch(RThink_Controller_Action)
     * 最终还是交由动作控制器自己分发
     *
     * @return void RThink_Controller_Response Response object if returnResponse() is true
     */
    public function dispatch()
    {

        $_plugins = array();

        if ($this->getParam('plugins')) {

//            if (!$this->getParam('plugin_path')) {
//                throw new RThink_Exception("插件注册失败！入口文件没有指定plugin_path！");
//            }

            foreach ($this->getParam('plugins') as $plugin) {
//                include $this->getParam('plugin_path') . '/' . $plugin . '.php';
                include APP_PATH . '/app/plugins/' . $plugin . '.php';
                $_plugins[] = new $plugin();
            }

        }

        if (!$this->getParam('noErrorHandler')) {
            include 'RThink/Controller/Plugin/ErrorHandler.php';
            $_plugins[] = new RThink_Controller_Plugin_ErrorHandler();
        }

        $this->_plugins->registerPlugin($_plugins);

        /**
         * 获取请求对象
         */
        if (null === $this->_request) {
            $this->getRequest();
        }

        /**
         * 获取响应对象
         */
        if (null === $this->_response) {
            $this->getResponse();
        }


        /**
         * Initialize Router
         */
        $router = $this->getRouter();


        /**
         * 初始化派遣器
         */
        $dispatcher = $this->getDispatcher();
        $dispatcher->setParams($this->getParams())->setResponse($this->_response);

        // 开始派遣
        try {

            /**
             * Notify plugins of Router startup
             */
            $this->_plugins->routeStartup($this->_request, $this->_response);

            try {
                $router->route($this->_request);
            } catch (Exception $e) {
                if ($this->throwExceptions()) {
                    throw $e;
                }
                $this->_response->setException($e);
            }


           /**
            * Notify plugins of Router completion
            */
            $this->_plugins->routeShutdown($this->_request, $this->_response);

            /**
             * Notify plugins of dispatch loop startup
             */
            $this->_plugins->dispatchLoopStartup($this->_request, $this->_response);

            /**
             * 尝试派遣controller/action.如果 $this->_request表明需要被派遣，
             * 移动到request的下一个action
             */
            do {
                $this->_request->setDispatched(true);

                /**
                 * Notify plugins of dispatch startup
                 */
                $this->_plugins->preDispatch($this->_request, $this->_response);

                /**
                 * 如果 preDispatch() 重置了请求的action则跳过
                 */
                if (false == $this->_request->isDispatched()) {
                    continue;
                }

                /**
                 * 派遣请求
                 */
                try {
                    $dispatcher->dispatch($this->_request, $this->_response);
                } catch (Exception $e) {
                    if ($this->throwExceptions()) {
                        throw $e;
                    }
                    $this->_response->setException($e);
                }

                /**
                 * Notify plugins of dispatch completion
                 */
                $this->_plugins->postDispatch($this->_request, $this->_response);
            } while (!$this->_request->isDispatched());
        } catch (Exception $e) {

            if ($this->throwExceptions()) {
                throw $e;
            }

            $this->_response->setException($e);
        }
	

        /**
         * Notify plugins of dispatch loop completion
         */
        try {
            $this->_plugins->dispatchLoopShutdown($this->_response);
        } catch (Exception $e) {
            if ($this->throwExceptions()) {
                throw $e;
            }

            $this->_response->setException($e);
        }


        if ($this->_request->getParam('db_debug')) {
            RThink_Debug::dbDebug();
        }

        if ($this->returnResponse()) {
            return $this->_response;
        }

        $this->_response->sendResponse();
    }

    protected function loader($class_name)
    {
        if (substr($class_name, -5, 5) == 'Model') {//自动加载Model
            $model = substr($class_name, 0, -5);
            $file_name = str_replace('_', DIRECTORY_SEPARATOR, $model);
            $load_file = APP_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR. $file_name . '.php';

            if (!is_readable($load_file)) {
                throw new RThink_Exception('找不到Class {'. $class_name . '}');
            }

            include $load_file;
        } else if (substr($class_name, -10, 10) == 'Controller') {//自动加载Model
            $controller = substr($class_name, 0, -10);
            $file_name = str_replace('_', DIRECTORY_SEPARATOR, $controller);
            $load_file = APP_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR. $file_name . '.php';

            if (!is_readable($load_file)) {
                throw new RThink_Exception('找不到Class {'. $class_name . '}');
            }

            include $load_file;
        } else {//自动加载三方库文件
            $file_name = str_replace('_', DIRECTORY_SEPARATOR, $class_name);
            $load_file = APP_PATH . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . '' . DIRECTORY_SEPARATOR. $file_name . '.php';

            if (!is_readable($load_file)) {
                throw new RThink_Exception('找不到Class {'. $class_name . '}');
            }

            include $load_file;
        }

    }

}