<?php

namespace app\data\controller;

use think\admin\Controller;

/**
 * 题库管理
 * Class NewsMark
 * @package app\data\controller
 */
class Questions extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataQuestions';

    /**
     * 试卷管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $group_id = trim(input('group_id'));
        if (!is_numeric($group_id) || $group_id <= 0) {
            $this->error('缺少必要参数!');
        }
        $group_info = $this->app->db->name('DataQuestionsGroup')->find(['id' => $group_id]);
        if (empty($group_info)) {
            $this->error('试卷不存在!');
        }
        $this->assign('group_info', $group_info);
        $this->title = "【{$group_info['title']}】题库管理";
        //获取题库
        $query = $this->_query($this->table);
        $query->like('question')->equal('status')->dateBetween('create_at');
        $query->where(['group_id' => $group_id])->order('sort desc,id asc')->page();
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
        //$this->error('缺少必要参数!');

        $is_post = request()->isPost();
        $group_id = trim(input('group_id'));
        if (!is_numeric($group_id) || $group_id <= 0) {
            $this->error('缺少必要参数!');
        }
        $group_info = $this->app->db->name('DataQuestionsGroup')->find(['id' => $group_id]);
        if (empty($group_info)) {
            $this->error('试卷不存在!');
        }
        $this->assign('group_info', $group_info);
        if ($is_post) {
            if (empty($data['question'])) $this->error('请输入题目');
            if (!is_array($data['answers_val']) || empty($data['answers_val'])) $this->error('未设置选项！');
            if (empty($data['answers'])) $this->error('未设置正确答案！');
            $options = [];
            foreach ($data['answers_val'] as $key => $val) {
                $val = trim($val);
                if (empty($val))
                {
                    $error_key = $key + 1;
                    $this->error("第{$error_key}个选项不能为空！");
                }
                if (in_array($val, $options)) {
                    $error_key = $key + 1;
                    $this->error("第{$error_key}个【{$val}】选项重复！");
                }
                $options[] = $val;
            }
            $cur_date = date('Y-m-d H:i:s');
            $operator = session('user.username') . '(' . session('user.id') . ')';
            if (isset($data['id']) && $data['id'] > 0) {
                $data['update_at'] = $cur_date;
                $data['update_by'] = $operator;
            } else {
                $data['create_at'] = $cur_date;
                $data['create_by'] = $operator;
            }
            $data['options'] = json_encode($data['answers_val']);
        } else {
            if (!empty($data['options'])) {
                $data['options'] = json_decode($data['options'], true);
            }
        }
    }

    /**
     * 修改文章标签状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_save($this->table, $this->_vali([
            'status.in:0,1' => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 状态修改回调
     * @param $query
     * @param $data
     */
    public function _save_filter($query,&$data)
    {
        $cur_date = date('Y-m-d H:i:s');
        $operator = session('user.username') . '(' . session('user.id') . ')';
        $data['update_at'] = $cur_date;
        $data['update_by'] = $operator;
    }

    /**
     * 删除试题
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }
}