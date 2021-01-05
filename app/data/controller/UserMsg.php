<?php

namespace app\data\controller;

use think\admin\Controller;

/**
 * 用户留言管理
 * Class UserMsg
 * @package app\data\controller
 */
class UserMsg extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataUserMsg';

    /**
     * 用户留言管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $status = input('status');
        $this->title = '会员留言';
        $query = $this->_query($this->table);
        if ($status == 1) {
            $query = $query->whereNotNull('reply');
        } else if ($status == 2) {
            $query = $query->whereNull('reply');
        }
        $query->dateBetween('create_at');
        $query->order('id desc')->page();
    }

    /**
     * 用户留言列表回调
     * @param $data
     */
    protected function _page_filter(&$data)
    {
        // 这里可以对 $data 进行二次处理，注意是引用
        foreach ($data as $key => $item) {
            //获取用户信息
            $map = ['id' => $item['uid']];
            $user_info = $this->app->db->name('DataUser')->where($map)->find();
            $data[$key]['username'] = $user_info['username'];
        }
    }

    /**
     * 添加文章标签
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑文章标签
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->_form($this->table, 'form');
    }

    /**
     * 表单回调
     * @param $data
     */
    public function _form_filter(&$data)
    {
        $is_post = request()->isPost();
        if ($is_post) {
            if (empty($data['reply'])) $this->error('请输入回复内容');
            $data['reply_at'] = date('Y-m-d H:i:s');
            $operator = session('user.username') . '(' . session('user.id') . ')';
            $data['reply_by'] = $operator;
        }
    }

    /**
     * 删除留言
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }
}