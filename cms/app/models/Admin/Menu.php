<?php

/**
 * 多级路径model测试
 */
class Admin_MenuModel extends BaseModel
{

    protected static $_instance = null;

    protected static $_table = 'admin_menu';

    public function __construct()
    {
        $db_conf = RThink_Config::get('db.default');

        parent::__construct($db_conf);
    }

    public static function instance()
    {
        if (null == self::$_instance) {
            self::$_instance = new self();
        }

        self::$_instance->selectTable(self::$_table);

        return self::$_instance;
    }

//    /**
//     * 获取所有列表
//     */
//    function get_all_list()
//    {
//        $array = array();
//        $limit = " 0,10000 ";
//        return $this->db->select_db('default')->fetch_row('admin_menu', $array, $order, $limit);
//    }
//
    /**
     * 查找菜单
     * $limit = array('offset' => 0, 'count' => 10)
     * @param string $id
     */
    public function getAdminMenuList($array, $order, $limit = array())
    {
        $condition = array();
        $bind = array();

        foreach ($array as $key => $val) {
            $condition[] = "$key = ?";
            $bind [] = $val;
        }

        $condition[] = 'status = ?';
        $bind[] = 1;

        $option = array(
            'condition' => join(' and ', $condition),
            'bind' => $bind,
            'order' => $order,
            'limit' => $limit
        );


        return $this->fetchAll($option);

//        return $this->db->select_db('default')->fetch_row('admin_menu ', $array, $order, $limit);
    }

    public function getAdminHeaderMenu($menu_list, $modle, $action = '')
    {
        $condition = array();

        $condition[] = 'modle = ?';
        $bind[] = $modle;

        if (!empty($action)) {
            $condition[] = 'action = ?';
            $bind[] = $action;
        }

        $option = array(
            'condition' => join(' and ', $condition) . ' and status = 1',
            'bind' => $bind,
            'order' => 'orders asc'
        );

        $menu_id = $this->fetchAll($option);

        $menu_id = array(0 => $menu_id[0]);

        $small_menu = $this->getAdminMenuListByPid($menu_id[0]['id'], '0', 'orders asc');

        //print_r($menu_id);
        if (empty($small_menu)) {
            $small_menu = array();
        }
        if ($menu_id[0]['top'] == 0) {
            $menu_id = array_merge(array('0' => $menu_id[0]), $small_menu);
        } else {
            unset($menu_id);
        }

        /* 替换变量 */
        if (isset($menu_list['header'])) {
            foreach ($menu_id as $key => $val) {
                foreach ($menu_list['header'] as $key2 => $val2) {
                    $menu_id[$key]['url'] = str_replace('$' . $key2, $val2, $val['url']);
                }
            }
        }

//        var_dump($menu_id);exit;
        //print_r($small_menu);
        //exit;
        return $menu_id;

    }
//
//    /**
//     * 根据modle,action查找菜单
//     * @param string $id
//     */
//    function get_admin_menu_list_by_modle_action($modle, $action, $order, $limit)
//    {
//        $array['modle'] = $modle;
//        if (!empty($action)) {
//            $array['action'] = $action;
//        }
//        $array['status'] = 0;
//        return $this->db->select_db('default')->fetch_row('admin_menu ', $array, $order, $limit);
//    }

    /**
     * 根据ID批量查找菜单
     * @param string $id
     */
    public function getAdminMenuListByIds($ids, $parent_id = '', $top = '', $hidden = '', $order = '', $no_verify = 0)
    {
        if (empty($ids)) {
            return array();
        } else {
            $ids = explode(',', $ids);
            $ids = array_filter($ids);
            $ids = array_flip(array_flip($ids));
        }

        $where = array();
        $bind = array();

        $where[] = 'status = 1';

        if ($parent_id !== '') {
            $where[] = 'parent_id = ?';
            $bind[] = $parent_id;
        }
        if ($top != '') {
            $where[] = 'top = ?';
            $bind[] = $top;
        }
        if ($hidden != '') {
            $where[] = 'hidden = ?';
            $bind[] = $hidden;
        }

        if ($no_verify > 0) {
            $where[] = 'no_verify = ?';
            $bind[] = $no_verify;
        } else {
            $where[] = $this->getDbInstance()->quoteInto('id in (?)', $ids);
        }


        $condition = array(
            'condition' => join(' and ', $where),
            'bind' => $bind,
        );
//        var_dump($condition);exit;

        if ('' != $order) {
            $condition['order'] = $order;
        }


        return $this->fetchAll($condition);
    }

//    /**
//     * 根据pid查找菜单
//     * @param string $id
//     */
//    function get_admin_menu_list_by_pid($pid, $top, $order = '', $limit = 'all')
//    {
//        $array['parent_id'] = $pid;
//        if ($top != '') {
//            $array['top'] = $top;
//        }
//        $array['status'] = 0;
//
//        return $this->db->select_db('default')->fetch_row('admin_menu', $array, $order, $limit);
//    }
//
//    function get_admin_menu_list_by_id($id)
//    {
//        $array['id'] = $id;
//        $array['status'] = 0;
//        return $this->db->select_db('default')->fetch('admin_menu', $array);
//    }
//
//    /**
//     * 删除菜单
//     * @param string $id
//     */
//    function delete_menu_list_by_id($id)
//    {
//        return $this->db->select_db('default')->update('admin_menu', array('status' => '1'), "id = {$id}");
//    }
//
//    /**
//     * 更新菜单
//     * @param string $id
//     */
//    function update_admin_menu_by_id($id, $par)
//    {
//        $array['title'] = $par['title'];
//        $array['modle'] = $par['modle'];
//        $array['action'] = $par['action'];
//        $array['url'] = $par['url'];
//        $array['parent_id'] = $par['parent_id'];
//        $array['orders'] = $par['orders'];
//        $array['hidden'] = $par['hidden'];
//        $array['target'] = $par['target'];
//        $array['top'] = $par['top'];
//        $array['ajax'] = $par['ajax'];
//
//        $this->db->select_db('default')->update('admin_menu', $array, " id = {$id}");
//        return true;
//    }
//
//    /**
//     * 插入菜单
//     * @param string $id
//     */
//    function insert_admin_menu($par)
//    {
//        $array['title'] = $par['title'];
//        $array['modle'] = $par['modle'];
//        $array['action'] = $par['action'];
//        $array['url'] = $par['url'];
//        $array['parent_id'] = $par['parent_id'];
//        $array['orders'] = $par['orders'];
//        $array['hidden'] = $par['hidden'];
//        $array['target'] = $par['target'];
//        $array['top'] = $par['top'];
//        $array['ajax'] = $par['ajax'];
//        $array['no_verify'] = $par['no_verify'];
//        $array['parent_no_verify'] = $par['parent_no_verify'];
//        $array['status'] = 0;
//        return $this->db->select_db('default')->insert('admin_menu', $array);
//    }
//
//    /**
//     * 更新菜单排序
//     * @param string $id
//     */
//    function update_menu_list_orders_by_id($id, $orders)
//    {
//        $array['orders'] = $orders;
//        return $this->db->select_db('default')->update('admin_menu', $array, " id = {$id}");
//    }


    public function getAdminMenuListByPid($pid, $top = '', $order = 'orders desc', $limit = array())
    {
        $option = array(
            'condition' => 'parent_id = ?',
            'bind' => array($pid),
            'order' => $order,
        );

        if ($top != '') {
            $option['condition'] .= ' and top = ?';
            $option['bind'][] = $top;
        }

        $option['condition'] .= ' and status = 1';

        if (!empty($limit)) {
            $option['limit'] = $limit;
        }

//        var_dump($option);exit;

        return $this->fetchAll($option);
    }

    public function updateAdminMenuById($id, $par)
    {
        $array['title'] = $par['title'];
        $array['modle'] = $par['modle'];
        $array['action'] = $par['action'];
        $array['url'] = $par['url'];
        $array['parent_id'] = $par['parent_id'];
        $array['orders'] = $par['orders'];
        $array['hidden'] = $par['hidden'];
        $array['target'] = $par['target'];
        $array['top'] = $par['top'];
        $array['ajax'] = $par['ajax'];

        return $this->update($array, array('id' => $id));
//        $this->db->select_db('default')->update('admin_menu',$array," id = {$id}");
//        return true;
    }


    /**
     * 插入菜单
     * @param string $id
     */
    public function insertAdminMenu($par)
    {
        $array['title'] = $par['title'];
        $array['modle'] = $par['modle'];
        $array['action'] = $par['action'];
        $array['url'] = $par['url'];
        $array['parent_id'] = $par['parent_id'];
        $array['orders'] = $par['orders'];
        $array['hidden'] = $par['hidden'];
        $array['target'] = $par['target'];
        $array['top'] = $par['top'];
        $array['ajax'] = $par['ajax'];
        $array['no_verify'] = isset($par['no_verify']) ? intval($par['no_verify']) : 0;
        $array['parent_no_verify'] = isset($par['parent_no_verify']) ? $par['parent_no_verify'] : 0;
        $array['status'] = 1;

        return $this->add($array);
    }


    public function getAdminMenuListByModleAction($modle,$action,$order = 'orders asc', $limit = array())
    {
        $option = array(
            'condition' => 'modle = ?',
            'bind' => array($modle),
            'order' => $order,
        );

        if (!empty($action))
        {
            $option['condition'] .= ' and action = ?';
            $option['bind'][] = $action;
        }

         $option['condition'] .= ' and status = 1';

        if (!empty($limit)) {
            $option['limit'] = $limit;
        }

        $menu_list = $this->fetchAll($option);

        if ($menu_list[0]['parent_id'] > 0) {
            $menu_list = array_merge($menu_list, $this->getAdminMenuNavByParentId($menu_list[0]['parent_id']));
        }

        sort($menu_list);
        return $menu_list;
    }

    public function getAdminMenuNavByParentId($parent_id)
    {
        $menu = array($this->getAdminMenuListById($parent_id));

        if ($menu[0]['parent_id'] > 0)
        {
            $menu = array_merge($menu, $this->getAdminMenuNavByParentId($menu[0]['parent_id']));
        }

        return $menu;
    }

    public function getAdminMenuListById($id)
    {
//        return $this->db->select_db('default')->fetch('admin_menu',$array);
        return $this->fetchRow(array('condition' => 'id = ' . $id . ' and status = 1'));
    }


}