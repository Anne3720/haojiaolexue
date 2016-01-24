<?php
/**
 * 编辑科目
 * Class Admin_Subject_EditController
 */
class Admin_Subject_EditController extends Admin_AbstractController
{

    public function indexAction()
    {

        /** 验证是否登录 **/
       $this->verify(__METHOD__);
        //@todo  $this->verify(__METHOD__);

        // $id = $this->getRequest()->getParam('id');
        $data = array();
        $data['grade'] = RThink_Config::get('app.grade');
        // if (empty($id)) {
            $data['pagename'] = '菜单添加';
            // $parent = Admin_MenuModel::instance()->getAdminMenuListByIds($parent_id);

            // $parent = isset($parent[0]) ? $parent[0] : array('id' => '', 'modle' => '');
            // $data['parent_id'] = $parent['id'];
            // $data['info']['modle'] = $parent['modle'];
            // $data['info']['orders'] = 0;

        // } 
        // else {
        //     $data['pagename'] = '菜单编辑';
        //     $data['info'] = Admin_MenuModel::instance()->getAdminMenuListByIds($id);
        //     $data['info'] = $data['info'][0];
        //     $data['parent_id'] = $data['info']['parent_id'];
        // }

        // $data['info'] += array('hidden' => 0, 'target' => 0, 'top' => 0, 'ajax' => 0);
        $this->setInvokeArg('layout', 'admin1_layout');
        $this->render($data);
    }

}