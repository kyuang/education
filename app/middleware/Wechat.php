<?php
declare (strict_types = 1);

namespace app\middleware;

class Wechat
{
    /**
     * 处理请求
     * @param $request
     * @param \Closure $next
     * @return array|mixed|\think\response\View
     */
    public function handle($request, \Closure $next)
    {
        if(!config('app.app_local') && !is_wechat()){
            $msg = '请在微信中打开！';
            if($request->isAjax()){
                return alert_info(1, $msg);
            }else{
                return easy_tip($msg);
            }
        }
        return $next($request);
    }
}
