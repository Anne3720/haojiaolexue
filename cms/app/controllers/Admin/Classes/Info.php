<?php
/**
 * 添加课程
 * Class Admin_Classes_InfoController
 */
class Admin_Classes_InfoController extends Admin_AbstractController
{

    public function indexAction()
    {

        /** 验证是否登录 **/
        $this->verify(__METHOD__);
        $post = $this->getRequest()->getPost();
        $params = array(
            'ClassNo'=>$post['ClassNo'],
            'Grade'=>$post['Grade'],
            'SubjectID'=>$post['SubjectID'],
            'Image'=>basename($post['file_0']),
            'Video'=>basename($post['file_1']),
            'Price'=>$post['Price'],
            'UpdateTime'=>date('Y-m-d H:i:s'),
        );
        // print_r($_FILES);exit;
        if (null != $this->getRequest()->getPost('ClassID')) {
            Admin_ClassesModel::instance()->update($params, array('ClassID' => $ClassID));
        } else {
            $params['CreateTime'] = date('Y-m-d H:i:s');
            Admin_ClassesModel::instance()->add($params);
        }
        if($_FILES['Image']['error']==0){
            $rs = move_uploaded_file($_FILES['Image']['tmp_name'],RThink_Config::get('app.imagePath').'\\'.$_FILES['Image']['name']);
        }else{
            $this->sendMsg(-1,"图片上传失败");
        }
        if($_FILES['Video']['error']==0){
            move_uploaded_file($_FILES['Video']['tmp_name'],RThink_Config::get('app.videoPath').'\\'.$_FILES['Video']['name']);
        }else{
            $this->sendMsg(-1,"视频上传失败");
        }
        $this->sendMsg(1, "操作成功");
    }

}