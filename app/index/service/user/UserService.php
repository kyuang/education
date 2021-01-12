<?php
declare (strict_types = 1);
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
    public function loginInfo()
    {
        $user_info = $this->app->session->get('crm');
        $user_id = intval($user_info['id']);
        if ($user_id > 0) {
            return alert_info(0, '登录成功！', $user_info);
        }
        return alert_info(1, '未登录！');
    }

    /**
     * 执行登录
     * @param $user_id
     * @return array
     */
    public function doLogin($user_id)
    {
        $user_info = $this->app->db->name('DataUser')->where(['id' => $user_id])->find();
        if (empty($user_info)) {
            return alert_info(1, '用户不存在！');
        }
        $this->app->session->set('crm', $user_info);
        return alert_info(0, '登录成功！', $user_info);
    }

    /**
     * 退出登录
     * @return bool
     */
    public function logout()
    {
        $this->app->session->clear();
        $this->app->session->destroy();
        return true;
    }

    /**
     * 登录
     * @param $username
     * @param $password
     * @return array
     */
    public function loginByPassword($username, $password)
    {
        if (empty($username) || empty($password)) {
            return alert_info(1, '参数错误！');
        }
        $user_info = $this->app->db->name('DataUser')->where(['username' => $username])->find();
        if (empty($user_info)) {
            return alert_info(1, '用户不存在！');
        }
        //校验密码
        if ($user_info['password'] !== md5($password)) {
            return alert_info(1, '用户名或密码错误！');
        }
        return $this->doLogin($user_info['id']);
    }

    /**
     * 修改密码
     * @param $old_password
     * @param $new_password
     * @return array
     */
    public function updatePassword($old_password, $new_password)
    {
        $user_info = $this->app->session->get('crm');
        if (empty($user_info)) {
            return alert_info(1, '登录已失效');
        }
        $user_id = $user_info['id'];
        //校验密码
        if ($user_info['password'] !== md5($old_password)) {
            return alert_info(1, '旧密码错误！');
        }
        $res = $this->app->db->name('DataUser')->where(['id' => $user_id])
            ->update(['password' => md5($new_password)]);
        if ($res === false) {
            return alert_info(1, '修改失败');
        }
        return alert_info(0, '操作成功！');
    }


    /**
     * 登录
     * @param $username
     * @param $password
     * @return array
     */
    public function zhuce($username, $password)
    {
        if (empty($username) || empty($password)) {
            return alert_info(1, '参数错误！');
        }
        $user_info = $this->app->db->name('DataUser')->where(['username' => $username])->find();
        if (empty($user_info)) {
            return alert_info(1, '用户已存在！');
        }
        //校验密码
        if (md5($user_info['password']) !== $password) {
            return alert_info(1, '用户名或密码错误！');
        }

        $data = [
            'username' => $username,
            'password' => md5($password),
            'create_at' => date('Y-m-d H:i:s')
        ];

        $res = $this->app->db->name('DataUser')
            ->insertGetId($data);
        if ($res === false) {
            return alert_info(1, '注册失败');
        }
        return alert_info(0, '注册成功！');
    }
}
