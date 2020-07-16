<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->
    <!-- content start -->
    <div class="admin-content">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg"> <?=$name;?></strong></div>
        </div>
        <div class="am-tabs am-margin" data-am-tabs>
            <ul class="am-tabs-nav am-nav am-nav-tabs">
                <li class="am-active"><a href="#tab1">基本信息</a></li>
            </ul>

            <div class="am-tabs-bd">
                <div class="am-tab-panel am-active" id="tab1">
                    <form action="/yearbook/update_fixedassetsjbxx_Y" method="post" style="<?php echo $date_type == 'Y' ? "":"display: none";?>" onsubmit="return toVaild1()">
                        <table class="am-table table-main" style="background-color: #fffefe;">
                            <tr><td>年度</td><td><input class="y_year" type="number" style="width: 80%;" id="fa_year" name="fa_year" value="<?=$fixedassets_info->fa_year;?>"></td>
                            </tr>
                            <tr><td>固定资产投资额(亿元)</td><td><input type="text" style="width: 80%;" id="fixe_assets_value" name="fixe_assets_value" value="<?=$fixedassets_info->fixe_assets_value;?>"></td>
                                <td>基础设施投资额(亿元)</td><td><input type="text" style="width: 80%;" id="infrastructure_value" name="infrastructure_value" value="<?=$fixedassets_info->infrastructure_value;?>"></td>
                                <td>房地产业投资额(亿元)</td><td><input type="text" style="width: 80%;" id="fixe_assets_house" name="fixe_assets_house" value="<?=$fixedassets_info->fixe_assets_house;?>"></td>
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
                    <form action="/yearbook/update_fixedassetsjbxx_Q" method="post" style="<?php echo $date_type == 'Q' ? "":"display: none";?>" onsubmit="return toVaild2()">
                        <table class="am-table table-main" style="background-color: #fffefe;">
                            <tr><td>年度</td><td><input class="q_year" type="number" style="width: 80%;" id="fa_year" name="fa_year" value="<?=$fixedassets_info->fa_year;?>"></td>
                                <td>季度</td><td><input type="number" style="width: 80%;" id="fa_quarter" name="fa_quarter" value="<?=$fixedassets_info->fa_quarter;?>"></td>
                            </tr>
                            <tr><td>自年初累计值(亿元)</td><td><input type="text" style="width: 80%;" id="fa_value_total" name="fa_value_total" value="<?=$fixedassets_info->fa_value_total;?>"></td>
                                <td>当季值(亿元)</td><td><input type="text" style="width: 80%;" id="fa_value_quarter" name="fa_value_quarter" value="<?=$fixedassets_info->fa_value_quarter;?>"></td>
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
                    <form action="/yearbook/update_fixedassetsjbxx_M" method="post" style="<?php echo $date_type == 'M' ? "":"display: none";?>" onsubmit="return toVaild3()">
                        <table class="am-table table-main" style="background-color: #fffefe;">
                            <tr><td>年度</td><td><input class="m_year" type="number" style="width: 80%;" id="fa_year" name="fa_year" value="<?=$fixedassets_info->fa_year;?>"></td>
                                <td>月度</td><td><input type="number" style="width: 80%;" id="fa_month" name="fa_month" value="<?=$fixedassets_info->fa_month;?>"></td>
                            </tr>
                            <tr><td>自年初累计值(亿元)</td><td><input type="text" style="width: 80%;" id="fa_value_total" name="fa_value_total" value="<?=$fixedassets_info->fa_value_total;?>"></td>
                                <td>当季值(亿元)</td><td><input type="text" style="width: 80%;" id="fa_value_month" name="fa_value_month" value="<?=$fixedassets_info->fa_value_month;?>"></td>
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
                </div>

            </div>
        </div>
        <!-- content end -->
    </div>

    <?php $this->load->view('/footer');?>
    <script>
        function toVaild1(){
            var fa_year = $('.y_year');
            if(fa_year.val().length == 0){
                fa_year.css("border","1px solid red");
                return false;
            }
            return true;
        }
        function toVaild2(){
            var fa_year = $('.q_year');
            var fa_quarter = $('#fa_quarter');
            if(fa_year.val().length == 0){
                fa_year.css("border","1px solid red");
                return false;
            }
            if(fa_quarter.val().length == 0){
                fa_quarter.css("border","1px solid red");
                return false;
            }
            return true;
        }
        function toVaild3(){
            var fa_year = $('.m_year');
            var fa_month = $('#fa_month');
            if(fa_year.val().length == 0){
                fa_year.css("border","1px solid red");
                return false;
            }
            if(fa_month.val().length == 0){
                fa_month.css("border","1px solid red");
                return false;
            }
            return true;
        }
    </script>