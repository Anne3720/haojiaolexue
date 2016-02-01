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
        $imageKey = RThink_Config::get('app.imageKey');
        $videoKey = RThink_Config::get('app.videoKey');
        $pt = '.';
        $imageName = $videoName = '';
        //上传图片和视频
        if($_FILES['Image']['error']==0){
            $imageName = md5($imageKey.$post['ClassNo']).$pt.$this->getFileExtend($post['file_0']);
            move_uploaded_file($_FILES['Image']['tmp_name'],RThink_Config::get('app.imagePath').'\\'.$imageName);
        }
        if($_FILES['Video']['error']==0){
            $videoName = md5($videoKey.$post['ClassNo']).$pt.$this->getFileExtend($post['file_1']);
            move_uploaded_file($_FILES['Video']['tmp_name'],RThink_Config::get('app.videoPath').'\\'.$videoName);
        }
        $params = array(
            'ClassNo'=>$post['ClassNo'],
            'Grade'=>$post['Grade'],
            'SubjectID'=>$post['SubjectID'],
            'Price'=>$post['Price'],
            'UpdateTime'=>date('Y-m-d H:i:s'),
        );
        if($imageName!=''){
            $params['Image'] = $imageName;
        }
        if($videoName!=''){
            $params['Video'] = $videoName;
        }
        $ClassID = $this->getRequest()->getPost('ClassID');
        if (null != $ClassID) {
            Admin_ClassesModel::instance()->update($params, array('ClassID' => $ClassID));
        } 
        else {
            $params['CreateTime'] = date('Y-m-d H:i:s');
            Admin_ClassesModel::instance()->add($params);
        }
        $this->sendMsg(1, "操作成功");
    }

}