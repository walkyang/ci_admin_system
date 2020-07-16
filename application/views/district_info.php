<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg"><?=$district_name;?></strong></div>
        </div>
        <div class="am-tabs am-margin" data-am-tabs>
            <ul class="am-tabs-nav am-nav am-nav-tabs">
                <li class="am-active"><a href="#tab1">基本信息</a></li>
            </ul>

            <div class="am-tabs-bd">
                <div class="am-tab-panel am-active" id="tab1">
                    <form action="/dist/update_distjbxx" method="post" onsubmit="return toVaild()">
                        <table class="am-table table-main" style="background-color: #fffefe;">
                            <tr><td>行政面积</td><td><input type="text" style="width: 80%;" id="district_area" name="district_area" value="<?php if($district) echo $district->district_area;?>"></td>
                                <td>常住人口</td><td><input type="text" style="width: 80%;" id="resident_population" name="resident_population" value="<?php if($district) echo $district->resident_population;?>"></td>
                                <td>其中外来人口</td><td><input type="text" style="width: 80%;" id="external_population" name="external_population" value="<?php if($district) echo $district->external_population;?>"></td>
                                <td>人口密度</td><td><input type="text" style="width: 80%;" id="population_density" name="population_density" value="<?php if($district) echo $district->population_density;?>"></td></tr>
                            <tr><td>区域介绍</td><td colspan="7"><textarea type="text" style="width: 80%; height: 200px;"  id="district_des" name="district_des"><?php if($district) echo $district->district_des;?></textarea></td></tr>
                        </table>
                        <div class="am-u-sm-10">
                            <div >
                                <input type="hidden" name="city_id" id="city_id" value="<?=$city_id;?>" />
                                <input type="hidden" name="district_id" id="district_id" value="<?=$district_id;?>" />
                                <input type="hidden" name="district_name" id="district_name" value="<?=$district_name;?>" />
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
