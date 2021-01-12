<?php
declare (strict_types = 1);
namespace app\index\service\user;

use app\index\service\Verify;
use think\admin\Service;

/**
 * 注册服务
 * Class DataService
 * @package app\company\service
 */
class RegisterService extends Service
{
    //错误收集
    private $errors = [];
    //输入数据
    private $data = [];

    /**
     * 错误信息收集
     * @param $error
     * @return $this
     */
    private function setError($error)
    {
        $this->errors[] = $error;
        return $this;
    }

    /**
     * 设置用户名
     * @param $username
     * @return $this
     */
    public function setUsername($username)
    {
        $username = trim($username);
        if (empty($username)) {
            $this->setError('用户名不能为空！');
            return $this;
        }
        if (!Verify::isUserName($username, 3, 15)) {
            $this->setError('用户名应为3-15位字母+数字！');
            return $this;
        }
        $this->data['username'] = $username;
        return $this;
    }

    /**
     * 设置密码
     * @param $password1
     * @param $password2
     * @return $this
     */
    public function setPassword($password1, $password2)
    {
        if (empty($password1) || empty($password2)) {
            $this->setError('密码不能为空！');
            return $this;
        }
        if ($password1 !== $password2) {
            $this->setError('两次密码不一致！');
            return $this;
        }
        if (!Verify::isPassword($password1)) {
            $this->setError(Verify::$password_tip);
            return $this;
        }
        $this->data['password'] = $password1;
        return $this;
    }

    /**
     * 设置手机号
     * @param $mobile
     * @return $this
     */
    public function setMobile($mobile)
    {
        if (!empty($mobile) && !Verify::isMobile($mobile)) {
            $this->setError('手机号格式不正确！');
            return $this;
        }
        $this->data['phone'] = $mobile;
        return $this;
    }

    /**
     * 设置昵称
     * @param $nickname
     * @return $this
     */
    public function setNickname($nickname)
    {
        if (!empty($nickname)) {
            $this->data['nickname'] = $nickname;
        }
        return $this;
    }

    /**
     * 注册保存
     * @return array
     */
    public function store()
    {
        // halt($request->param());
        $rule=[
            'username'=>'require|length:5,20|token',
            'password'=>'require'
        ];
        $message=[
            'username.require'=>'用户名不能为空！',
            'username.length'=>'用户名长度必须在5到20之间！',
            'password.require'=>'密码不能为空！'
        ];

        $validate = new \think\Validate($rule,$message);
        $result=$validate->check(request()->param());
        halt($validate->getError());


        $required_params = ['username', 'password'];
        foreach ($required_params as $param) {
            if (!isset($this->data[$param])) {
                $this->setError('参数' . $param . '未传递');
            }
        }
        if (!empty($this->errors)) {
            return alert_info(1, $this->errors[0], $this->errors);
        }
        $add_res = $this->app->db->name('DataUser')->insertGetId($this->data);
        if (!$add_res) {
            return alert_info(1, '注册失败！');
        }
        return alert_info(0, '注册成功！', ['id' => $add_res]);
    }
}
