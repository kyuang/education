<?php

namespace app\data\controller;

use think\admin\Controller;

/**
 * 普通用户管理
 * Class User
 * @package app\data\controller
 */
class User extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataUser';

    /**
     * 普通用户管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '普通用户管理';
        $query = $this->_query($this->table);
        $query->like('phone,username|nickname#username');
        $query->whereRaw('nickname != "" or username != ""');
        $query->order('id desc')->equal('status')->dateBetween('create_at')->page();
    }

    /**
     * 修改用户状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_save($this->table, $this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 修改用户密码
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function pass()
    {
        $this->_applyFormToken();
        if ($this->request->isGet()) {
            $this->verify = false;
            $this->_form($this->table, 'pass');
        } else {
            $data = $this->_vali([
                'id.require'                  => '用户ID不能为空！',
                'password.require'            => '登录密码不能为空！',
                'repassword.require'          => '重复密码不能为空！',
                'repassword.confirm:password' => '两次输入的密码不一致！',
            ]);
            if (data_save($this->table, ['id' => $data['id'], 'password' => md5($data['password'])], 'id')) {
                sysoplog('CRM用户管理', "修改用户[{$data['id']}]密码成功");
                $this->success('密码修改成功！', '');
            } else {
                $this->error('密码修改失败，请稍候再试！');
            }
        }
    }
}