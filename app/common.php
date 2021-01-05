<?php

/**
 * 提示 + 跳转
 * @param string $msg 提示信息不能为空
 * @param array $params 参数
 * $parameters = [
 *      'url' => $redirect_url,
 *      'icon' => $icon,
 *      'sec' => $sec
 * ];
 * @return \think\response\View
 */
function easy_tip($msg, $params = [])
{
    if (request()->isAjax()) {
        echo json_encode(alert_info(1, $msg));
        die();
    } else {
        $params['msg'] = $msg;
        return view('/tip/tip',$params);
    }
}

/**
 * 信息返回
 * @param int $code 错误码 0成功，其他失败
 * @param string $msg 返回消息
 * @param array $data 返回数据
 * @return array
 */
function alert_info($code, $msg = '', $data = array())
{
    $code = (int)$code;
    $msg = trim($msg);
    return ['code' => $code, 'msg' => $msg, 'data' => $data];
}

/**
 * 是否微信环境
 * @return bool
 */
function is_wechat(){
    $request = request();
    if (preg_match('~micromessenger~i', $request->header('user-agent'))) {
        return true;
    }
    return false;
}

/**
 * 是否支付宝环境
 * @return bool
 */
function is_alipay(){
    $request = request();
    if (preg_match('~alipay~i', $request->header('user-agent'))) {
        return true;
    }
    return false;
}