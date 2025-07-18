<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title><?=lang('后台管理')?></title> 
    <?php 
    do_action("header");
    add_js("
        $('#logout').click(function(){ 
            layer.confirm('".lang('确定退出登录吗？')."', {
                title: '".lang('确认退出')."',
                btn: ['".lang('确认')."', '".lang('取消')."'],
                icon: 3
            }, function(index){
                window.location.href = '/admin/logout'; 
            }, function(index){
                
            }); 
        });
        
    ");
    global $vue;
    $vue->data("password","{}");
    $vue->method("savePassword()","
        if(!this.password.old){
            this.\$message.error('".lang('旧密码不能为空')."');
            return;
        }
        if(!this.password.new){
            this.\$message.error('".lang('新密码不能为空')."');
            return;
        }
        if(!this.password.confirm){
            this.\$message.error('".lang('确认新密码不能为空')."');
            return;
        }
        if(this.password.new != this.password.confirm){
            this.\$message.error('".lang('两次新密码输入不一致')."');
            return;
        }
        ajax('/admin/password/change',{
            old:this.password.old,
            new:this.password.new,
            confirm:this.password.confirm
        },function(res){
            ".vue_message()."
            if(res.code == 0){ 
                _this.password = {}; 
                $('#changePasswordModal').modal('hide');
            }
        });
    ");
    ?> 
</head>
<body>
    <div id="app">
    <!-- 顶部导航栏 -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <i class="bi bi-list toggle-sidebar-btn me-3" id="toggleSidebar"></i>
            <a class="navbar-brand" href="#"></a>
            <div class="ms-auto d-flex align-items-center"> 
                <?php do_action('header_right')?>
                <!-- 管理员头像下拉菜单 -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i> 
                        <?=$user_info['username']?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal"><?=lang('修改密码')?></a></li>
                        <li><a class="dropdown-item" href="#" id='logout'><?=lang('退出')?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- 左侧菜单（展开式） -->
    <div class="sidebar">
        <div class="sidebar-title"><?=lang('控制台')?></div>
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link" href="#/admin/welcome" data-has-submenu="false"><i class="bi bi-house"></i> <?=lang('控制面板')?></a>
            </li>
            <?php  
            foreach($menu as $k=>$v){
                $children = $v['children']??"";
                if($children){
                    foreach($children as $kk=>$vv){
                        $url = create_new_url($vv['url']);  
                        if(!has_access($url)){
                            unset($menu[$k]['children'][$kk]);
                        }
                    }
                }else{
                    $url = create_new_url($v['url']);
                    if(!has_access($url)){
                        unset($menu[$k]);
                    }
                }
            } 
            foreach($menu as $v){
                $url = $v['url']; 
                $children = $v['children']??"";
                if(!$url && !$children){
                    continue;
                }
            ?>
            <li class="nav-item">
                <a class="nav-link" href="#<?=$v['url']?>" data-has-submenu="true"><i class="bi <?=$v['icon']??''?>"></i> <?=lang($v['title'])?></a>
                <?php if($children){?>
                <ul class="nav flex-column sub-menu">
                    <?php foreach($children as $vv){?>
                    <li class="nav-item"><a class="nav-link" href="#<?=$vv['url']?>"><?=lang($vv['title'])?></a></li>
                    <?php }?>
                </ul>
                <?php }?>
            </li>
            <?php }?> 
        </ul>
    </div>

    <!-- 右侧内容区域 -->
    <div class="content">
        <div class="iframe-container">
            <iframe id="contentFrame" src="/admin/welcome"></iframe>
        </div>
    </div>

    <!-- 修改密码模态框 -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel"><?=lang('修改密码')?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="oldPassword" class="form-label required" ><?=lang('旧密码')?></label>
                            <input type="password" v-model="password.old" class="form-control" id="oldPassword">

                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label required"><?=lang('新密码')?></label>
                            <input type="password" v-model="password.new" class="form-control" id="newPassword">
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label required"><?=lang('确认新密码')?></label>
                            <input type="password" v-model="password.confirm" class="form-control" id="confirmPassword">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <el-button type="" data-bs-dismiss="modal"><?=lang('取消')?></el-button>
                    <el-button type="primary" @click="savePassword"><?=lang('保存')?></el-button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php 
    do_action("footer");
    view_footer();
    ?> 

</body>
</html>