<?php

namespace app\data\controller;

use think\admin\Controller;

/**
 * 用户答题管理
 * Class NewsMark
 * @package app\data\controller
 */
class UserAnswers extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataUserAnswers';

    /**
     * 答题记录管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $search_type = trim(input('search_type'));
        $search_val = trim(input('search_val'));
        $math_type = trim(input('math_type'));
        $math_val = trim(input('math_val'));

        $group_id = trim(input('group_id'));
        if (!is_numeric($group_id) || $group_id <= 0) {
            $this->error('缺少必要参数!');
        }
        $group_info = $this->app->db->name('DataQuestionsGroup')->find(['id' => $group_id]);
        if (empty($group_info)) {
            $this->error('试卷不存在!');
        }
        $this->title = "【{$group_info['title']}】答题记录";
        $this->assign('group_info', $group_info);
        $search_type_list = [1=>'用户ID',2=>'用户名',3=>'用户手机号'];
        $this->assign('search_type', $search_type_list);
        $math_type_list = [1=>'大于',2=>'等于',3=>'小于'];
        $this->assign('math_type', $math_type_list);
        $this->title = "【{$group_info['title']}】答题记录";
        //获取题库
        $query = $this->_query($this->table);
        $query->dateBetween('create_at');
        $map = ['group_id' => $group_id];
        if (key_exists($search_type,$search_type_list) && !empty($search_val))
        {
            $user_map = [];
            switch ($search_type)
            {
                case 1:
                    //用户ID
                    $user_map = ['id'=>$search_val];
                    break;
                case 2:
                    //用户名
                    $user_map = ['username'=>$search_val];
                    break;
                case 3:
                    //手机号
                    $user_map = ['phone'=>$search_val];
                    break;
                default:
                    break;
            }
            $user_info = $this->app->db->name('DataUser')->where($user_map)->find();
            if (empty($user_info))
            {
                $this->error('搜索用户不存在！');
            }
            $map['uid'] = $user_info['id'];
        }
        if (key_exists($math_type,$math_type_list) && !empty($math_val))
        {
            switch ($math_type)
            {
                case 1:
                    $query->where('grade','>',$math_val);
                    break;
                case 2:
                    //用户名
                    $map['grade'] = $math_val;
                    break;
                case 3:
                    //手机号
                    $query->where('grade','<',$math_val);
                    break;
                default:
                    break;
            }
        }
        $query->where($map)->order('id desc')->page();
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
            $data[$key]['phone'] = $user_info['phone'];
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
     * 删除试题
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }
}