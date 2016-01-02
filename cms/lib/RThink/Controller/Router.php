<?php

/**
 * 路由
 */
class RThink_Controller_Router
{
    /**
     * URI分隔符
     */
    const URI_DELIMITER = '/';

    /**
     * 备用URI分隔符
     */
    const BACK_UP_URI_DELIMITER = '_';

    /**
     * 前端控制器实例
     *
     * @var RThink_Controller_Front
     */
    protected $_front_controller;

    /**
     * 获取前端控制器
     *
     * @return RThink_Controller_Front
     */
    public function getFrontController()
    {
        // Used cache version if found
        if (null !== $this->_front_controller) {
            return $this->_front_controller;
        }

        class_exists('RThink_Controller_Front', false) || require 'RThink/Controller/Front.php';
        $this->_front_controller = RThink_Controller_Front::getInstance();
        return $this->_front_controller;
    }


    /**
     * 从用户提交的PATH_INFO匹配 模块 控制器 action 和 其它参数信息并返回一个关联数组 If a Request object is
     * registered, it uses its setModuleName(), setControllerName(), and
     * setActionName() accessors to set those values. Always returns the values
     * as an array.
     *
     * @param string $path Path used to match against this routing map
     * @return array An array of assigned values or a false on a mismatch
     */
    protected function _match($path)
    {
        $values = array();
        $params = array();

        $path = trim($path, self::URI_DELIMITER);

		if ($path != '') {

            //提供两种url样式 /user/guide/view /user_guide_view
            $path = str_replace(self::BACK_UP_URI_DELIMITER, self::URI_DELIMITER, $path);
			$path = explode(self::URI_DELIMITER, $path);

//            var_dump($path);

            $values['controller'] = array_pop($path);

           if (count($path) > 0) {
               foreach ($path as &$val) {
                   $val = ucfirst(strtolower($val));
               }
               $values ['module'] = join(self::URI_DELIMITER, $path);
           }

//            var_dump($values);exit;

//			$path_index = 0;
//			$module = $path [$path_index];

//			while ($this->getFrontController()->getDispatcher()->isValidModule($module)) {
//				$path_index++;
//				if (!isset($path [$path_index])) {
//					break;
//				}
//				$module .= self::URI_DELIMITER . $path [$path_index];
//			}
//
//
//            if ($path_index > 0) {
//                $values ['module'] = join(self::URI_DELIMITER, array_splice($path, 0, $path_index));
//            }

			// if ($this->getFrontController()->getDispatcher()->isValidModule($path [0])) {
			//     $values ['module'] = array_shift($path);
			// }

//			if (count($path) && !empty ($path [0])) {
//				$values ['controller'] = array_shift($path);
//			}
//
//			if (count($path) && !empty ($path [0])) {
//				$values ['action'] = array_shift($path);
//			}
//
//			if ($num_segs = count($path)) {
//				for ($i = 0; $i < $num_segs; $i = $i + 2) {
//					$params [urldecode($path [$i])] = isset ($path [$i + 1]) ? urldecode($path [$i + 1]) : null;
//				}
//			}

		} // end of if  $path != ''

        $default = array(
            'module' => $this->getFrontController()->getDispatcher()->getDefaultModule(),
            'controller' => $this->getFrontController()->getDispatcher()->getDefaultController(),
            'action' => $this->getFrontController()->getDispatcher()->getDefaultAction()
        );

        return $values + $default;

//        return $values + $params + $default;
    }

    protected function _setRequestParams($request, $params)
    {
        foreach ($params as $param => $value) {

            $request->setParam($param, $value);

            if ($param === $request->getModuleKey()) {
                $request->setModuleName($value);
            }
            if ($param === $request->getControllerKey()) {
                $request->setControllerName($value);
            }
            if ($param === $request->getActionKey()) {
                $request->setActionName($value);
            }
        }
    }

    /**
     * 从当前PATH_INFO查找匹配路由 并将返回值保存在请求对象中
     *
     * @throws RThink_Controller_Router_Exception
     * @return RThink_Controller_Request Request object
     */
    public function route(RThink_Controller_Request $request)
    {
        $match = $request->getPathInfo();

        if ($params = $this->_match($match)) {
            $this->_setRequestParams($request, $params);
        } else {
            class_exists('RThink_Controller_Router_Exception', false) || require 'RThink/Controller/Router/Exception.php';
            throw new RThink_Controller_Router_Exception ('No route matched the Request', 404);
        }

        return $request;
    }


}
