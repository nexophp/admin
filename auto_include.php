<?php

use core\Menu;

// 设置分组（可选，默认为'admin'）
Menu::setGroup('admin');

// 添加顶级菜单
Menu::add('system', '系统管理', '', 'bi-gear', 50);

Menu::add('system-module', '模块', '/admin/module', '', 100, 'system');
Menu::add('system-setting', '设置', '/admin/setting', '', 50, 'system');
Menu::add('system-user', '用户管理', '/admin/user', '', 30, 'system');
Menu::add('system-role', '角色管理', '/admin/role', '', 20, 'system');
Menu::add('system-log', '操作日志', '/admin/log', '', 10, 'system');
/**
 * 发布资源
 */
publish_assets('admin',__DIR__);


/**
 * 添加日志
 */
function add_log($title, $content, $type = 'info')
{
    global $uid;
    db_insert('log', [
        'title' => $title,
        'user_id' => $uid,
        'ip' => get_ip(),
        'content' => $content,
        'type' => $type,
        'url' => $_SERVER['REQUEST_URI'] ?: $_SERVER['PATH_INFO'],
        'created_at' => time(),
    ]);
}

/**
 * 日志类型
 */
function get_log_types($type = '')
{
    $types = [
        'debug' => lang('调试'),
        'info' => lang('一般'),
        'error' => lang('错误'),
        'warning' => lang('警告'),
        'success' => lang('成功'),
    ];
    if ($type) {
        return $types[$type] ?? '';
    }
    return $types;
}   
/**
 * 上传文件类型
 */
add_action("upload.mime", function ($mime) {
    if(is_admin()){
        return;
    }
    $upload_mime = get_config('upload_mime');
    if ($upload_mime) {
        if (is_array($upload_mime)) {
            $upload_mime = implode(',', $upload_mime);
        }
        $allow = lib\Mime::get($upload_mime, true);
        if (!$allow || !in_array($mime, $allow)) {
            json_error(['msg' => lang('上传文件类型错误')]);
        }
    }
});
/**
 * 上传文件大小
 */
add_action("upload.size", function ($size) {
    if(is_admin()){
        return;
    }
    $upload_size = get_config('upload_size');
    if ($upload_size) {
        $upload_size = $upload_size * 1024 * 1024;
        if ($size > $upload_size) {
            json_error(['msg' => lang('上传文件大小错误')]);
        }
    }
});

/**
 * 添加到首页 
 */
function add_to_home($title,$url){
    global $homepages; 
    $url = str_replace("\\","/",$url);
    $homepages[] = [
        'title' => $title,
        'url' => $url,
    ];
}

