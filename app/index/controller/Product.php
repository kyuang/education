<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\index\controller;


/**
 * Class Index
 * @package app\index\controller
 */
class Product extends CommonController
{

    protected $table = 'ShopGoods';

    public function index()
    {
        $this->title = '课程列表';
		$keyword = trim(input('keyword'));
        $page = $this->request->get('page', 1);
        $map = ['deleted' => 0,'status'=>1];
		
		$query = $this->app->db->name('ShopGoods')->field(['*']);
        if (!empty($keyword)) {
            $query = $query->where('name', 'like', "%{$keyword}%");
        }
        $data_list = $query
            ->where($map)->order('sort desc,id desc')
            ->page($page, $this->page_size)
            ->select()->toArray();

        foreach ($data_list as &$item) {
            $cat_id = $item['cate'];
            $cates = $this->app->db->name('ShopGoodsCate')->where(['id' => $cat_id])->find();
            $item['cat_name'] = $cates['name'];
        }

        $this->assign('page', $page);
        $this->assign('page_size', $this->page_size);
        $this->assign('product_list', $data_list);
        $this->fetch();
    }


    public function search()
    {
        $this->title = '搜索';
        $this->assign('list', []);
        $this->fetch('search');
    }


    public function details()
    {
        $this->title = '明细';

        $id = input('id');
        $detail = $this->app->db->name($this->table)->where(['id' => $id])->find();
        $detail['slider'] = empty($detail['slider']) ? [] : explode('|', $detail['slider']);

        $cat_id = $detail['cate'];
        $cates = $this->app->db->name('ShopGoodsCate')->where(['id' => $cat_id])->find();
        $detail['cat_name'] = $cates['name'];

//        dump($detail);die;
        $this->assign('detail', $detail);
        $this->assign('is_show', 0);
        $this->fetch('details');
    }


    public function yuyue()
    {
        $this->title = '预约';

        $id = input('id');
        $product = $this->app->db->name($this->table)->where(['id' => $id])->find();

        $this->assign('product', $product);
        $this->assign('is_show', 0);
        $this->fetch('yuyue');
    }


    /**
     * 保存在线报名记录
     */
    public function yuyue_store()
    {
        $product_id = input('product_id');
        $mobile = input('mobile');
        $username = input('username');
        $message = input('message');

        $product = $this->app->db->name($this->table)->where(['id' => $product_id])->find();
        if (empty($product)) {
            $this->error('预约课程错误！');
        }

        if (empty($mobile)) {
            $this->error('请输入手机号！');
        }
        if (!isMobile($mobile)) {
            $this->error('手机号格式错误！');
        }
        if (empty($username)) {
            $this->error('请输入姓名！');
        }
        if (empty($message)) {
            $this->error('请输入内容！');
        }
        $add_res = $this->app->db->name('DataGoodsApply')
            ->where('mobile', $mobile)
            ->where('product_id', $product_id)
            ->where('status', 0)
            ->find();
        if (!empty($add_res)) {
            $this->error('您已预约，请勿重复预约！');
        }
        $data = [
            'product_id' => $product_id,
            'mobile' => $mobile,
            'username' => $username,
            'message' => $message,
            'create_at' => date('Y-m-d H:i:s')
        ];
        $add_res = $this->app->db->name('DataGoodsApply')->insertGetId($data);
        if (!$add_res) {
            $this->error('添加失败，请稍后重试！');
        }
        $this->app->db->name('ShopGoods')->where('id', $product_id)
            ->update(['stock_sales' => $product['stock_sales'] + 1]);
        return $this->success('添加成功！');
    }

}