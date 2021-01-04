<?php
declare (strict_types = 1);

namespace app\middleware;

class Auth
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {

//        if (!ShopAuthService::isLogin()) {
//            ShopAuthService::logout();
//            if ($request->ajax()) {
//                return alert_info(1, '会话失效，请重新登录');
//            } else {
//                echo '<script type="text/javascript">top.location.href="' . url('login') . '";</script>';
//                exit();
//            }
//        }

        return $next($request);
    }
}
