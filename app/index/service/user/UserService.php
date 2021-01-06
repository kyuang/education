<?php
declare (strict_types=1);
namespace app\index\service\user;
use think\admin\Service;

/**
 * 用户服务
 * Class DataService
 * @package app\company\service
 */
class UserService extends Service
{
    /**
     * 获取登录信息
     * @return array
     */
    public function loginInfo(){
        $user_info = $this->app->session->get('crm');
        $user_info = ['id'=>1];
        $user_id = intval($user_info['id']);
        if ($user_id > 0){
            return alert_info(0,'登录成功！',$user_info);
        }
        return alert_info(1,'未登录！');
    }
}
