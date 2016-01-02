<?php

/**
 * 管理员列表
 * Class Admin_User_ListController
 */
class Admin_User_ListController extends Admin_AbstractController
{

    public function indexAction()
    {
        //检查权限
        $this->verify(__METHOD__);

        $show['pagename'] = '管理员列表';

        $username = $this->getRequest()->getQuery('username', '');

        $perpage = 20;

        $page = intval($this->getRequest()->getQuery('page'));
        $page = $page ? $page : 1;


        $project_list = Admin_ProjectModel::instance()->fetchAll();
        $project_list_tmp = array();

        foreach ($project_list as $val) {
            $project_list_tmp[$val['id']] = $val;
        }

        $option = array(
            'condition' => 'status = 1',
            'order' => 'id desc',
            'limit' => array('offset' => ($page - 1) * $perpage, 'count' => $perpage)
        );

        if (!empty($username)) {
            $option['condition'] .= " and username like ?";
            $option['bind'] = array("%$username%");
        }


        $data['list'] = Admin_AdminModel::instance()->fetchAll($option);
        $gids = array();

        foreach ($data['list'] as $val) {
            $gids[] = $val['gid'];
        }

        $gids = join(',', $gids);
        $gids = explode(',', $gids);

        $group_list_tmp = array();

        if (!empty($gids[0])) {

//            $gids = array_unique($gids);
//            $group_list = db_admin_group::get_admin_group_by_ids($gids);
            $group_list = Admin_GroupModel::instance()->getAdminGroupByIds($gids);

            foreach ($group_list as $key => $val) {
                $group_list_tmp[$val['id']] = $val;
            }

            foreach ($data['list'] as $key => $val) {
                $val['gid'] = explode(',', $val['gid']);

                foreach ($val['gid'] as $val2) {
                    $data['list'][$key]['group'][] = isset($group_list_tmp[$val2]['group_name']) ? $group_list_tmp[$val2]['group_name'] : '';
                }

                $val['project_id'] = explode(',', $val['project_id']);
                foreach ($val['project_id'] as $val2) {//var_dump($val['project_id'], $val2, $val['gid']);exit;
                    $data['list'][$key]['project'][] = isset($project_list_tmp[$val2]['project_name']) ? $project_list_tmp[$val2]['project_name'] : '';
                }

                $data['list'][$key]['project'] = implode(' , ', $data['list'][$key]['project']);
                $data['list'][$key]['group'] = implode(' , ', $data['list'][$key]['group']);
            }
        }

        if (!empty($username)) {
            $count_opt = array('condition' => "username like ? and status = 1", 'bind' => array("%$username%"));
        } else {
            $count_opt = array('condition' => 'status = 1');
        }

        $data['count'] = Admin_AdminModel::instance()->count($count_opt);

        $pagination = new Pagination();
        $data['page'] = $pagination->maxnum($data['count'], $perpage)->show('page_metronic');
        $data['menu'] = Widget_Admin_MenuModel::headerMenu();
        $data['username'] = $username;
        $data['url'] = rawurlencode($this->getRequest()->getServer('REQUEST_URI'));

        $this->setInvokeArg('layout', 'admin2_layout');
        $this->render($data);
    }

}