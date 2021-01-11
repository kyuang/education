<?php

namespace app\data\controller;

use think\admin\Controller;

/**
 * 试卷管理
 * Class NewsMark
 * @package app\data\controller
 */
class QuestionsGroup extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataQuestionsGroup';

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
        $this->title = '试卷管理';
        //获取分类
        $map = ['pid'=>0,'status'=>1,'deleted'=>0];
        $cate_list = $this->app->db->name('ShopGoodsCate')->field(['id','name'])->where($map)->order('sort desc,id desc')->select()->toArray();
        $cate_list[-1] = ['id'=>'','name'=>'-- 全部 --'];
        ksort($cate_list);
        $this->assign('cate_list',$cate_list);
        $query = $this->_query($this->table);
        $query->like('title')->equal('cate_id')->equal('status')->dateBetween('create_at');
        $query->where(['deleted' => 0])->order('sort desc,id desc')->page();
    }

    /**
     * 列表回调
     * @param $data
     */
    protected function _page_filter(&$data)
    {
        // 这里可以对 $data 进行二次处理，注意是引用
        foreach ($data as $key => $item) {
            //获取分类信息
            $map = ['id' => $item['cate_id']];
            $cate_info = $this->app->db->name('ShopGoodsCate')->where($map)->find();
            $data[$key]['cate_name'] = $cate_info['name'];
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
        //获取分类
        $map = ['pid'=>0,'status'=>1,'deleted'=>0];
        $cate_list = $this->app->db->name('ShopGoodsCate')->field(['id','name'])->where($map)->order('sort desc,id desc')->select()->toArray();
        $this->assign('cate_list',$cate_list);
        if ($is_post)
        {
            if (empty($data['title'])) $this->error('请输入标题');
            if (!is_numeric($data['cate_id']) || $data['cate_id'] <= 0) $this->error('请选择对应课程！');
            $cur_date = date('Y-m-d H:i:s');
            $operator  = session('user.username').'('.session('user.id').')';
            if (isset($data['id']) && $data['id'] > 0)
            {
                $data['update_at'] = $cur_date;
                $data['update_by'] = $operator;
            }
            else
            {
                $data['create_at'] = $cur_date;
                $data['create_by'] = $operator;
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
            'status.in:0,1'  => '状态值范围异常！',
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