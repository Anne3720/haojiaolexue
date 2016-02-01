<?php
/**
 * 推荐课程
 * Class Admin_Recommend_InfoController
 */
class Admin_Recommend_InfoController extends Admin_AbstractController
{

    public function indexAction()
    {

        /** 验证是否登录 **/
        $admin = $this->verify(__METHOD__);
        $classID = $this->getRequest()->getParam('ClassID');
        $memberID = $this->getRequest()->getParam('MemberID');
        $teacherID = $admin['id'];
        $params = array(
            'ClassID'=>$classID,
            'MemberID'=>$memberID,
            'CreateTime'=>date('Y-m-d H:i:s'),
            'TeacherID'=>$teacherID,
        );
        Admin_RecommendModel::instance()->add($params);
        $this->sendMsg(1, "操作成功");
    }

}