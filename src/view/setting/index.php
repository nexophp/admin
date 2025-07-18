<?php
view_header(lang('系统设置'));

global $vue;
$vue->data('form', "{}");
$vue->created(['load()']);
$vue->method("load()", "
ajax('/admin/setting/ajax',{},function(res){
  if(res.code==0){
    _this.form = res.data;
  }
});
");
$vue->method("save()", " 
ajax('/admin/setting/save',{data:this.form},function(res){
  " . vue_message() . "
  if(res.code==0){
    _this.load();
  }
});
"); 
?>
<div class="card shadow-sm">
    <div class="card-header bg-light">
        <h5 class="card-title mb-0">
            <i class="bi bi-gear me-2"></i><?=lang('系统设置')?>
        </h5>
    </div>
    <div class="card-body">
        <form>
            <!-- 基础设置 -->
            <div class="mb-4">
                <h6 class="fw-bold mb-3 border-bottom pb-2">
                    <i class="bi bi-sliders me-2"></i><?=lang('基础设置')?>
                </h6>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="siteName" class="form-label"><?=lang('站点名称')?></label>
                        <input type="text" v-model="form.app_name" class="form-control" id="siteName" value="我的网站">
                    </div>

                    <div class="col-md-6">
                        <label for="timezone" class="form-label"><?=lang('时区设置')?></label>
                        <select class="form-select" id="timezone" name="timezone" v-model="form.timezone">
                            <?php
                            // 常用时区列表
                            $timezones = [
                                'Asia/Shanghai' => lang('中国标准时间 (北京)'),  
                            ];
                            /**
                             * 时区列表
                             */
                            do_action("timezones", $timezones);
                            foreach ($timezones as $tz => $label):
                            ?>
                                <option value="<?= htmlspecialchars($tz) ?>">
                                    <?= htmlspecialchars($label) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                    <div class="col-md-6">
                        <label for="siteName" class="form-label"><?=lang('网站备案号')?></label>
                        <input type="text" v-model="form.app_beian" class="form-control" value="">
                    </div>

                    <div class="col-md-6">
                        <label for="siteName" class="form-label"><?=lang('公安备案号')?></label>
                        <input type="text" v-model="form.app_ga_beian" class="form-control" value="">
                    </div>  
            </div>

            <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label for="siteName" class="form-label"><?=lang('网站统计代码')?></label>
                        <textarea v-model="form.app_footer" class="form-control">{{form.app_footer}}</textarea>
                    </div> 
            </div>

            <!-- 显示设置 -->
            <div class="mb-4 mt-4">
                <h6 class="fw-bold mb-3 border-bottom pb-2">
                    <i class="bi bi-display me-2"></i><?=lang('显示设置（修改颜色需刷新页面）')?>
                </h6>
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label class="form-label"><?=lang('菜单背景颜色')?></label>
                        <input
                            type="color"
                            class="form-control form-control-color"
                            v-model="form.menu_bg"
                            value="#0d6efd"
                            title="">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label"><?=lang('菜单选中背景颜色')?></label>
                        <input
                            type="color"
                            class="form-control form-control-color"
                            v-model="form.menu_active"
                            value="#6c757d"
                            title="">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label"><?=lang('菜单选中文字颜色')?></label>
                        <input
                            type="color"
                            class="form-control form-control-color"
                            v-model="form.menu_color_active"
                            value="#FFFFFF"
                            title="">
                    </div>
                </div> 
            </div>

            <?php
            do_action('admin.setting.form');
            ?>


            <!-- 操作按钮 -->
            <div class="text-end">
                <?php if(has_access('admin/setting/save')){?>
                <button type="button" class="btn btn-primary" @click="save">
                    <i class="bi bi-floppy me-1"></i><?=lang('保存设置')?>
                </button>
                <?php }?>
            </div>
        </form>
    </div>
</div>
<?php
view_footer();
?>