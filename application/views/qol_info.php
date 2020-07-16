<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->
    <!-- content start -->
    <div class="admin-content">
        <div class="am-cf am-padding" style="<?php echo $id ? "":"display: none";?>">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg"> <?php if($qol_info) echo $qol_info->qol_year.'年';?></strong></div>
        </div>
        <div class="am-tabs am-margin" data-am-tabs>
            <ul class="am-tabs-nav am-nav am-nav-tabs">
                <li class="am-active"><a href="#tab1">基本信息</a></li>
            </ul>

            <div class="am-tabs-bd">
                <div class="am-tab-panel am-active" id="tab1">
                    <form action="/yearbook/update_qoljbxx" method="post" style="<?php echo $id ? "":"display: none";?>">
                        居民生活水平
                        <table class="am-table table-main" style="background-color: #f9f2f2;">
                            <tr><td>建成区面积(平方公里)</td><td><input type="text" style="width: 80%;" id="build_q_area" name="build_q_area" value="<?=$qol_info->build_q_area;?>"></td>
                                <td>居住用地面积(平方公里)</td><td><input type="text" style="width: 80%;" id="live_use_area" name="live_use_area" value="<?=$qol_info->live_use_area;?>"></td>
                            </tr>
                            <tr><td>全市面积(平方公里)</td><td><input type="text" style="width: 80%;" id="city_area" name="city_area" value="<?=$qol_info->city_area;?>"></td>
                                <td>城镇居民人均住房使用面积(平方米)</td><td><input type="text" style="width: 80%;" id="per_use_area" name="per_use_area" value="<?=$qol_info->per_use_area;?>"></td>
                            </tr>
                            <tr><td>城镇居民人均住房建筑面积(平方米)</td><td><input type="text" style="width: 80%;" id="per_build_area" name="per_build_area" value="<?=$qol_info->per_build_area;?>"></td>
                            </tr>
                        </table>
                        居民收入与储蓄
                        <table class="am-table table-main" style="background-color: #f2fbe3;">
                            <tr><td width="200px">城镇居民人均可支配收入(元)</td><td><input type="text" id="per_disposable_income" name="per_disposable_income" style="width: 80%" value="<?=$qol_info->per_disposable_income;?>"></td></tr>
                            <tr><td>城镇居民人均消费性支出(元)</td><td><input type="text" id="per_consumer_spending" name="per_consumer_spending" style="width: 80%" value="<?=$qol_info->per_consumer_spending;?>"></td></tr>
                            <tr><td>年末居民储蓄余额(亿元)</td><td><input type="text" id="savings_surplus" name="savings_surplus" style="width: 80%" value="<?=$qol_info->savings_surplus;?>"></td></tr>
                        </table>
                        城镇居民人均消费性支出明细(元)
                        <table class="am-table table-main" style="background-color: #fafdd1;">
                            <tr><td>食品</td><td><input type="text" id="pcs_food" name="pcs_food" style="width: 80%" value="<?=$qol_info->pcs_food;?>"></td>
                                <td>衣着</td><td><input type="text" id="pcs_clothes" name="pcs_clothes" style="width: 80%" value="<?=$qol_info->pcs_clothes;?>"></td>
                                <td>家庭设备用品及服务</td><td><input type="text" id="pcs_home_kits" name="pcs_home_kits" style="width: 80%" value="<?=$qol_info->pcs_home_kits;?>"></td>
                            </tr>
                            <tr><td>医疗保健</td><td><input type="text" id="pcs_medical_care" name="pcs_medical_care" style="width: 80%" value="<?=$qol_info->pcs_medical_care;?>"></td>
                                <td>交通和通讯</td><td><input type="text" id="pcs_traffic_tel" name="pcs_traffic_tel" style="width: 80%" value="<?=$qol_info->pcs_traffic_tel;?>"></td>
                                <td>教育文化娱乐服务</td><td><input type="text" id="pcs_education" name="pcs_education" style="width: 80%" value="<?=$qol_info->pcs_education;?>"></td>
                            </tr>
                            <tr><td>居住</td><td><input type="text" id="pcs_live" name="pcs_live" style="width: 80%" value="<?=$qol_info->pcs_live;?>"></td>
                                <td>其他</td><td><input type="text" id="pcs_other" name="pcs_other" style="width: 80%" value="<?=$qol_info->pcs_other;?>"></td>
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
                    <form action="/yearbook/add_qoljbxx" method="post" style="<?php echo $id ? "display: none":"";?>" onsubmit="return toVaild()">
                        <table class="am-table table-main" style="background-color: #FFFFFF;">
                            <tr><td width="100px">年度</td><td><input type="text" style="width: 50%;" id="qol_year" name="qol_year" ></td>
                            </tr>
                        </table>
                        居民生活水平
                        <table class="am-table table-main" style="background-color: #f9f2f2;">
                            <tr><td>建成区面积(平方公里)</td><td><input type="text" style="width: 80%;" id="build_q_area" name="build_q_area" ></td>
                                <td>居住用地面积(平方公里)</td><td><input type="text" style="width: 80%;" id="live_use_area" name="live_use_area"></td>
                            </tr>
                            <tr><td>全市面积(平方公里)</td><td><input type="text" style="width: 80%;" id="city_area" name="city_area" ></td>
                                <td>城镇居民人均住房使用面积(平方米)</td><td><input type="text" style="width: 80%;" id="per_use_area" name="per_use_area" ></td>
                            </tr>
                            <tr><td>城镇居民人均住房建筑面积(平方米)</td><td><input type="text" style="width: 80%;" id="per_build_area" name="per_build_area" ></td>
                            </tr>
                        </table>
                        居民收入与储蓄
                        <table class="am-table table-main" style="background-color: #f2fbe3;">
                            <tr><td width="200px">城镇居民人均可支配收入(元)</td><td><input type="text" id="per_disposable_income" name="per_disposable_income" style="width: 80%" ></td></tr>
                            <tr><td>城镇居民人均消费性支出(元)</td><td><input type="text" id="per_consumer_spending" name="per_consumer_spending" style="width: 80%" ></td></tr>
                            <tr><td>年末居民储蓄余额(亿元)</td><td><input type="text" id="savings_surplus" name="savings_surplus" style="width: 80%" ></td></tr>
                        </table>
                        城镇居民人均消费性支出明细(元)
                        <table class="am-table table-main" style="background-color: #fafdd1;">
                            <tr><td>食品</td><td><input type="text" id="pcs_food" name="pcs_food" style="width: 80%" ></td>
                                <td>衣着</td><td><input type="text" id="pcs_clothes" name="pcs_clothes" style="width: 80%"></td>
                                <td>家庭设备用品及服务</td><td><input type="text" id="pcs_home_kits" name="pcs_home_kits" style="width: 80%"></td>
                            </tr>
                            <tr><td>医疗保健</td><td><input type="text" id="pcs_medical_care" name="pcs_medical_care" style="width: 80%" ></td>
                                <td>交通和通讯</td><td><input type="text" id="pcs_traffic_tel" name="pcs_traffic_tel" style="width: 80%" ></td>
                                <td>教育文化娱乐服务</td><td><input type="text" id="pcs_education" name="pcs_education" style="width: 80%" ></td>
                            </tr>
                            <tr><td>居住</td><td><input type="text" id="pcs_live" name="pcs_live" style="width: 80%" ></td>
                                <td>其他</td><td><input type="text" id="pcs_other" name="pcs_other" style="width: 80%" ></td>
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
            var qol_year = $('#qol_year');
            if(qol_year.val().length == 0){
                qol_year.css("border","1px solid red");
                return false;
            }
            return true;
        }
    </script>