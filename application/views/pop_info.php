<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->
    <!-- content start -->
    <div class="admin-content">
        <div class="am-cf am-padding" style="<?php echo $id ? "":"display: none";?>">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg"> <?php if($pop_info) echo $pop_info->pop_year.'年';?></strong></div>
        </div>
        <div class="am-tabs am-margin" data-am-tabs>
            <ul class="am-tabs-nav am-nav am-nav-tabs">
                <li class="am-active"><a href="#tab1">基本信息</a></li>
            </ul>

            <div class="am-tabs-bd">
                <div class="am-tab-panel am-active" id="tab1">
                    <form action="/yearbook/update_popjbxx" method="post" style="<?php echo $id ? "":"display: none";?>">
                        <table class="am-table table-main" style="background-color: #fffefe;">
                            <tr><td>户籍人口(万人)</td><td><input type="text" style="width: 80%;" id="pop_regist" name="pop_regist" value="<?php if($pop_info) echo $pop_info->pop_regist;?>"></td>
                                <td>常住人口(万人)</td><td><input type="text" style="width: 80%;" id="pop_live" name="pop_live" value="<?php if($pop_info) echo $pop_info->pop_live;?>"></td>
                                <td>总户数(万户)</td><td><input type="text" style="width: 80%;" id="total_house" name="total_house" value="<?php if($pop_info) echo $pop_info->total_house;?>"></td>
                            </tr>
                            <tr>
                                <td >人口密度(人/平方公里)</td><td><input type="text" style="width: 80%;" id="pop_density" name="pop_density" value="<?php if($pop_info) echo $pop_info->pop_density;?>"></td>
                            </tr>
                        </table>
                        <div class="am-u-sm-10">
                            <div >
                                <input type="hidden" name="city_id" id="city_id" value="<?=$city_id;?>" />
                                <input type="hidden" name="id" id="id" value="<?=$id;?>" />
                                <button type="submit" class="am-btn am-btn-primary am-btn-xs">提交保存</button>
                            </div>
                        </div>
                    </form>
                    <form action="/yearbook/add_popjbxx" method="post" style="<?php echo $id ? "display: none":"";?>" onsubmit="return toVaild()">
                        <table class="am-table table-main" style="background-color: #fffefe;">
                            <tr>
                                <td >年度(年)</td><td><input type="number" style="width: 80%;" id="pop_year" name="pop_year" ></td>
                            </tr>
                            <tr><td>户籍人口(万人)</td><td><input type="text" style="width: 80%;" id="pop_regist" name="pop_regist" ></td>
                                <td>常住人口(万人)</td><td><input type="text" style="width: 80%;" id="pop_live" name="pop_live" ></td>
                                <td>总户数(万户)</td><td><input type="text" style="width: 80%;" id="total_house" name="total_house" ></td>
                            </tr>
                            <tr>
                                <td >人口密度(人/平方公里)</td><td><input type="text" style="width: 80%;" id="pop_density" name="pop_density" ></td>
                            </tr>
                        </table>
                        <div class="am-u-sm-10">
                            <div >
                                <input type="hidden" name="city_id" id="city_id" value="<?=$city_id;?>" />
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
            var pop_year = $('#pop_year');
            if(pop_year.val().length == 0){
                pop_year.css("border","1px solid red");
                pop_year.focus();
                return false;
            }
            return true;
        }
    </script>