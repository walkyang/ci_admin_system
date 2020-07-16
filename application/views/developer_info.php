<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->
    <!-- content start -->
    <div class="admin-content">
        <div class="am-cf am-padding" style="<?php echo $id ? "":"display: none";?>">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg"> <?php if($developer_info) echo $developer_info->full_name;?></strong></div>
        </div>
        <div class="am-tabs am-margin" data-am-tabs>
            <ul class="am-tabs-nav am-nav am-nav-tabs">
                <li class="am-active"><a href="#tab1">基本信息</a></li>
            </ul>

            <div class="am-tabs-bd">
                <div class="am-tab-panel am-active" id="tab1">
                    <form action="/developer/update_jbxx" method="post" style="<?php echo $id ? "":"display: none";?>">
                        <table class="am-table table-main" style="background-color: #fff;">
                            <tr><td>全称</td><td><input type="text" style="width: 80%;" id="full_name" name="full_name" value="<?=$developer_info->full_name;?>"></td>
                            </tr>
                            <tr><td>简称</td><td><input type="text" style="width: 80%;" id="short_name" name="short_name" value="<?=$developer_info->short_name;?>"></td>
                                <td>首字母</td><td><input type="text" style="width: 80%;" id="first_py" name="first_py" value="<?=$developer_info->first_py;?>"></td>
                            </tr>
                        </table>
                        <div class="am-u-sm-10">
                            <div >
                                <input type="hidden" name="id" id="id" value="<?=$id;?>" />
                                <button type="submit" class="am-btn am-btn-primary am-btn-xs">提交保存</button>
                            </div>
                        </div>
                    </form>
                    <form action="/developer/add_jbxx" method="post" style="<?php echo $id ? "display: none":"";?>" onsubmit="return toVaild()">
                        <table class="am-table table-main" style="background-color: #fff;">
                            <tr><td>全称</td><td><input type="text" style="width: 80%;" id="full_name" name="full_name" ></td>
                            </tr>
                            <tr><td>简称</td><td><input type="text" style="width: 80%;" id="short_name" name="short_name" ></td>
                                <td>首字母</td><td><input type="text" style="width: 80%;" id="first_py" name="first_py" ></td>
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
            var full_name = $('#full_name');
            if(full_name.val().length == 0){
                full_name.css("border","1px solid red");
                return false;
            }
            return true;
        }
    </script>