<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->
    <!-- content start -->
    <div class="admin-content">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg"> <?php if($user_info) echo $user_info->user_name;?></strong></div>
        </div>
        <div class="am-tabs am-margin" data-am-tabs>
            <ul class="am-tabs-nav am-nav am-nav-tabs">
                <li class="am-active"><a href="#tab1">基本信息</a></li>
            </ul>

            <div class="am-tabs-bd">
                <div class="am-tab-panel am-active" id="tab1">
                    <form action="/user/update_info" method="post">
                        <table class="am-table table-main" style="background-color: #fffefe;">
                            <tr><td>姓名</td><td><input type="text" style="width: 80%;" id="user_name" name="user_name" value="<?=$user_info->user_name;?>"></td>
                                <td>手机号码</td><td><input type="text" style="width: 80%;" id="user_mobile" name="user_mobile" value="<?=$user_info->user_mobile;?>"></td>
                            </tr>
                            <tr>
                                <td >公司</td><td><input type="text" style="width: 80%;" id="user_company" name="user_company" value="<?=$user_info->user_company;?>"></td>
                                <td >职务</td><td><input type="text" style="width: 80%;" id="user_position" name="user_position" value="<?=$user_info->user_position;?>"></td>
                            </tr>
                            <tr>
                                <td >密码</td><td><input type="text" style="width: 80%;" id="user_pass" name="user_pass" value="<?=$user_info->user_pass;?>"></td>
                            </tr>
                        </table>
                        <div class="am-u-sm-10">
                            <div >
                                <input type="hidden" name="id" id="id" value="<?=$user_id;?>" />
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
            var user_mobile = $('#user_mobile');
            if(user_mobile.val().length == 0){
                user_mobile.css("border","1px solid red");
                return false;
            }
            return true;
        }
    </script>