<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->
    <!-- content start -->
    <div class="admin-content">
        <div class="am-cf am-padding" style="<?php echo $id ? "":"display: none";?>">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg"> <?=$realtynewstartarea_info->realty_year.'年'.$realtynewstartarea_info->realty_month.'月';?></strong></div>
        </div>
        <div class="am-tabs am-margin" data-am-tabs>
            <ul class="am-tabs-nav am-nav am-nav-tabs">
                <li class="am-active"><a href="#tab1">房地产开发-新开工面积</a></li>
            </ul>

            <div class="am-tabs-bd">
                <div class="am-tab-panel am-active" id="tab1">
                    <form action="/yearbook/update_realtynewstartareajbxx" method="post" style="<?php echo $id ? "":"display: none";?>" onsubmit="return toVaild1()">
                        <table class="am-table table-main" style="background-color: #fff;">
                            <tr><td>年度</td><td><input class="edit_year" type="number" style="width: 80%;" id="realty_year" name="realty_year" value="<?=$realtynewstartarea_info->realty_year;?>"></td>
                            </tr>
                            <tr><td>商品房累计值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_spf_total_newstartarea" name="realty_spf_total_newstartarea" value="<?=$realtynewstartarea_info->realty_spf_total_newstartarea;?>"></td>
                                <td>商品房当前值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_spf_month_newstartarea" name="realty_spf_month_newstartarea" value="<?=$realtynewstartarea_info->realty_spf_month_newstartarea;?>"></td>
                            </tr>
                            <tr><td>住宅房累计值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_zz_total_newstartarea" name="realty_zz_total_newstartarea" value="<?=$realtynewstartarea_info->realty_zz_total_newstartarea;?>"></td>
                                <td>住宅房当前值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_zz_month_newstartarea" name="realty_zz_month_newstartarea" value="<?=$realtynewstartarea_info->realty_zz_month_newstartarea;?>"></td>
                            </tr>
                            <tr><td>经适房累计值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_jsf_total_newstartarea" name="realty_jsf_total_newstartarea" value="<?=$realtynewstartarea_info->realty_jsf_total_newstartarea;?>"></td>
                                <td>经适房当前值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_jsf_month_newstartarea" name="realty_jsf_month_newstartarea" value="<?=$realtynewstartarea_info->realty_jsf_month_newstartarea;?>"></td>
                            </tr>
                            <tr><td>别墅累计值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_bs_total_newstartarea" name="realty_bs_total_newstartarea" value="<?=$realtynewstartarea_info->realty_bs_total_newstartarea;?>"></td>
                                <td>别墅当前值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_bs_month_newstartarea" name="realty_bs_month_newstartarea" value="<?=$realtynewstartarea_info->realty_bs_month_newstartarea;?>"></td>
                            </tr>
                            <tr><td>办公累计值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_bg_total_newstartarea" name="realty_bg_total_newstartarea" value="<?=$realtynewstartarea_info->realty_bg_total_newstartarea;?>"></td>
                                <td>办公当前值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_bg_month_newstartarea" name="realty_bg_month_newstartarea" value="<?=$realtynewstartarea_info->realty_bg_month_newstartarea;?>"></td>
                            </tr>
                            <tr><td>商业累计值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_sy_total_newstartarea" name="realty_sy_total_newstartarea" value="<?=$realtynewstartarea_info->realty_sy_total_newstartarea;?>"></td>
                                <td>商业当前值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_sy_month_newstartarea" name="realty_sy_month_newstartarea" value="<?=$realtynewstartarea_info->realty_sy_month_newstartarea;?>"></td>
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
                    <form action="/yearbook/add_realtynewstartareajbxx" method="post" style="<?php echo $id ? "display: none":"";?>" onsubmit="return toVaild2()">
                        <table class="am-table table-main" style="background-color: #fff;">
                            <tr><td>年度</td><td><input class="add_year" type="number" style="width: 80%;" id="realty_year" name="realty_year" ></td>
                            </tr>
                            <tr><td>商品房累计值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_spf_total_newstartarea" name="realty_spf_total_newstartarea" ></td>
                                <td>商品房当前值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_spf_month_newstartarea" name="realty_spf_month_newstartarea" ></td>
                            </tr>
                            <tr><td>住宅房累计值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_zz_total_newstartarea" name="realty_zz_total_newstartarea" ></td>
                                <td>住宅房当前值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_zz_month_newstartarea" name="realty_zz_month_newstartarea" ></td>
                            </tr>
                            <tr><td>经适房累计值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_jsf_total_newstartarea" name="realty_jsf_total_newstartarea" ></td>
                                <td>经适房当前值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_jsf_month_newstartarea" name="realty_jsf_month_newstartarea" ></td>
                            </tr>
                            <tr><td>别墅累计值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_bs_total_newstartarea" name="realty_bs_total_newstartarea" "></td>
                                <td>别墅当前值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_bs_month_newstartarea" name="realty_bs_month_newstartarea" ></td>
                            </tr>
                            <tr><td>办公累计值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_bg_total_newstartarea" name="realty_bg_total_newstartarea" ></td>
                                <td>办公当前值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_bg_month_newstartarea" name="realty_bg_month_newstartarea" ></td>
                            </tr>
                            <tr><td>商业累计值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_sy_total_newstartarea" name="realty_sy_total_newstartarea" ></td>
                                <td>商业当前值(万平方米)</td><td><input type="number" style="width: 80%;" id="realty_sy_month_newstartarea" name="realty_sy_month_newstartarea" ></td>
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
        function toVaild1(){
            var edit_year = $('.edit_year');
            if(edit_year.val().length == 0){
                edit_year.css("border","1px solid red");
                return false;
            }
            return true;
        }
        function toVaild2(){
            var add_year = $('.add_year');
            if(add_year.val().length == 0){
                add_year.css("border","1px solid red");
                return false;
            }
            return true;
        }
    </script>