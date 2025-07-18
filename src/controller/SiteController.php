<?php

/**
 * 后台
 * @author sunkangchina <68103403@qq.com>
 * @date 2025
 */

namespace modules\admin\controller;

use core\Menu;

class SiteController extends \core\AdminController
{
    /**
     * 是否加载admin.css
     */
    protected $with_admin_css = true;
    /**
     * 请求前，什么都不写则不检查权限
     */
    public function before() {}
    /**
     * 后台首页
     */
    public function actionIndex()
    {
        $this->view_data['user_info'] = $this->user_info;
        $this->view_data['menu'] = Menu::get();
    }
}
