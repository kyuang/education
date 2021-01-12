<?php

namespace app\data\controller;

use think\admin\Controller;

/**
 * 商品在线报名管理
 * Class NewsMark
 * @package app\data\controller
 */
class GoodsApply extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataGoodsApply';

    /**
     * 报名管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '报名记录';
        $query = $this->_query($this->table);
        $query->like('username')->like('mobile')->equal('status')->dateBetween('create_at');
        $query->order('id desc')->page();
    }

    /**
     * 列表回调
     * @param $data
     */
    protected function _page_filter(&$data)
    {
        // 这里可以对 $data 进行二次处理，注意是引用
        foreach ($data as $key => $item) {
            //获取用户信息
            $pro_info = [];
            $pro_id = $item['product_id'];
            if (is_numeric($pro_id) && $pro_id > 0) {
                $map = ['id' => $item['product_id']];
                $pro_info = $this->app->db->name('ShopGoods')->where($map)->find();
            }
            $data[$key]['pro_name'] = isset($pro_info['name']) ? $pro_info['name'] : '';
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
     * 删除
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }
}