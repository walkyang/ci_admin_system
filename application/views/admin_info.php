<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->
    <!-- content start -->
    <div class="admin-content">
        <div class="am-cf am-padding" style="<?php echo $id ? "":"display: none";?>">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg"> <?php if($admin_info) echo $admin_info->user_name;?></strong></div>
        </div>
        <div class="am-tabs am-margin" data-am-tabs>
            <ul class="am-tabs-nav am-nav am-nav-tabs">
                <li class="am-active"><a href="#tab1">基本信息</a></li>
            </ul>

            <div class="am-tabs-bd">
                <div class="am-tab-panel am-active" id="tab1">
                    <form action="/admin/update_jbxx" method="post" style="<?php echo $id ? "":"display: none";?>">
                        <table class="am-table table-main" style="background-color: #fff;">
                            <tr><td>姓名</td><td><input type="text" style="width: 80%;" id="user_name" name="user_name" value="<?=$admin_info->user_name;?>"></td>
                            </tr>
                            <tr><td>电话</td><td><input type="text" style="width: 80%;" id="user_mobile" name="user_mobile" value="<?=$admin_info->user_mobile;?>"></td>
                                <td>密码</td><td><input type="text" style="width: 80%;" id="user_pwd" name="user_pwd" value="<?=$admin_info->user_pwd;?>"></td>
                            </tr>
                        </table>
                        <div class="am-u-sm-10">
                            <div >
                                <input type="hidden" name="id" id="id" value="<?=$id;?>" />
                                <button type="submit" class="am-btn am-btn-primary am-btn-xs">提交保存</button>
                            </div>
                        </div>
                    </form>
                    <form action="/admin/add_jbxx" method="post" style="<?php echo $id ? "display: none":"";?>" onsubmit="return toVaild()">
                        <table class="am-table table-main" style="background-color: #fff;">
                            <tr><td>姓名</td><td><input type="text" style="width: 80%;" id="user_name" name="user_name" ></td>
                            </tr>
                            <tr><td>电话</td><td><input type="text" style="width: 80%;" id="user_mobile" name="user_mobile" ></td>
                                <td>密码</td><td><input type="text" style="width: 80%;" id="user_pwd" name="user_pwd" ></td>
                            </tr>
                        </table>
                        <div class="am-u-sm-10">
                            <div >
                                <button type="submit" class="am-btn am-btn-primary am-btn-xs">提交保存</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <!-- content end -->
    </div>

    <?php $this->load->view('/footer');?>
    <script>
        function toVaild(){
            var qol_year = $('#qol_year');
            if(qol_year.val().length == 0){
                qol_year.css("border","1px solid red");
                return false;
            }
            return true;
        }
    </script>