<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">概况-报表</strong> / <small>Report</small></div>
        </div>
        <div class="am-g">
            <div class="am-u-md-6 am-cf">
                <div class="am-fl am-cf">
                    <div class="am-btn-toolbar am-fl">
                        <form method="get" action="/report/month_tj">
                        <div class="am-form-group am-margin-left am-fl">
                        <select id="city_id" name="city_id">
                            <?php foreach($citylist as $k=>$v){?>
                                <option <?php echo $v->city_id == $city_id ? 'selected="selected"' : ""; ?> value="<?=$v->city_id;?>"><?=$v->city_name;?></option>
                            <?php }?>
                        </select>
                        <select id="year" name="year">
                            <option value="0">选择年</option>
                            <?php for($i = 2010;$i<=$max_year; $i++){?>
                                <option <?php echo $year == $i ? "selected='selected'" : " "; ?> value=<?=$i;?>><?=$i;?>年</option>
                            <?php }?>

                        </select>
                        <select id="month" name="month">
                            <option  value="0">选择月</option>
                            <option <?php echo $month == 1 ? "selected='selected'" : " "; ?> value="1">1月</option>
                            <option <?php echo $month == 2 ? "selected='selected'" : " "; ?> value="2">2月</option>
                            <option <?php echo $month == 3 ? "selected='selected'" : " "; ?> value="3">3月</option>
                            <option <?php echo $month == 4 ? "selected='selected'" : " "; ?> value="4">4月</option>
                            <option <?php echo $month == 5 ? "selected='selected'" : " "; ?> value="5">5月</option>
                            <option <?php echo $month == 6 ? "selected='selected'" : " "; ?> value="6">6月</option>
                            <option <?php echo $month == 7 ? "selected='selected'" : " "; ?> value="7">7月</option>
                            <option <?php echo $month == 8 ? "selected='selected'" : " "; ?> value="8">8月</option>
                            <option <?php echo $month == 9 ? "selected='selected'" : " "; ?> value="9">9月</option>
                            <option <?php echo $month == 10 ? "selected='selected'" : " "; ?> value="10">10月</option>
                            <option <?php echo $month == 11 ? "selected='selected'" : " "; ?> value="11">11月</option>
                            <option <?php echo $month == 12 ? "selected='selected'" : " "; ?> value="12">12月</option>
                        </select>
                            <input name="is_sjprice" id="is_sjprice" value="1" type="radio" <?php echo $is_sjprice == 1 ? "checked='checked'" : " "; ?>/>实际价格
                            <input name="is_sjprice" id="is_sjprice" value="2" type="radio" <?php echo $is_sjprice == 2 ? "checked='checked'" : " "; ?> />估价
                            <button class="am-btn am-btn-default" type="submit">搜索</button>
                        </div>
                        </form>
                        <div class="am-btn-group am-btn-group-xs">
                            <a href="/report/month_tj?city_id=<?=$city_id;?>&year=<?=$year;?>&month=<?=$month;?>&is_sjprice=<?=$is_sjprice;?>" class="am-btn am-btn-default"><span class="am-icon-play-circle-o"></span> 概况</a>
                            <a href="/report/month_lj?city_id=<?=$city_id;?>&year=<?=$year;?>&month=<?=$month;?>&is_sjprice=<?=$is_sjprice;?>" class="am-btn am-btn-default"><span class="am-icon-play-circle-o"></span> 量价</a><a href="/report/month_loop?city_id=<?=$city_id;?>&year=<?=$year;?>&month=<?=$month;?>&is_sjprice=<?=$is_sjprice;?>" class="am-btn am-btn-default"><span class="am-icon-play-circle-o"></span> 环线</a>
                            <a href="/report/month_district?city_id=<?=$city_id;?>&year=<?=$year;?>&month=<?=$month;?>&is_sjprice=<?=$is_sjprice;?>" class="am-btn am-btn-default"><span class="am-icon-play-circle-o"></span> 区域</a><a href="/report/month_tprice?city_id=<?=$city_id;?>&year=<?=$year;?>&month=<?=$month;?>&is_sjprice=<?=$is_sjprice;?>" class="am-btn am-btn-default"><span class="am-icon-play-circle-o"></span> 总价段</a>
                            <a href="/report/month_area?city_id=<?=$city_id;?>&year=<?=$year;?>&month=<?=$month;?>&is_sjprice=<?=$is_sjprice;?>" class="am-btn am-btn-default"><span class="am-icon-play-circle-o"></span> 面积段</a><a href="/report/month_medium?city_id=<?=$city_id;?>&year=<?=$year;?>&month=<?=$month;?>&is_sjprice=<?=$is_sjprice;?>" class="am-btn am-btn-default"><span class="am-icon-play-circle-o"></span> 中介</a>
                        </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="am-g">
            <div class="am-u-sm-12">
                <div class="am-u-sm-12 am-u-sm-centered">
                    <h2>整体信息</h2>
                    <?php if($info){ ?>
                        <p>成交项目数：<?=$info->h_cnt;?> 环比：<?php echo  $pre_info->h_cnt ? (round(($info->h_cnt/$pre_info->h_cnt-1)*100,2)).'%' : '--';?>   |成交均价：<?=floor($info->avg_price)?> 环比：<?php echo  $pre_info->avg_price ? (round((floor($info->avg_price)/floor($pre_info->avg_price)-1)*100,2)).'%' : '--';?> |成交套数：<?=$info->d_cnt;?> 环比：<?php echo  $pre_info->d_cnt ? (round(($info->d_cnt/$pre_info->d_cnt-1)*100,2)).'%' : '--';?> |成交面积：<?=round($info->s_area/10000,2);?>万 |成交金额：<?=round($info->s_totalprice/100000000,2);?>亿</p>
                    <?php }else{
                        echo "<p>暂未查询到信息！</p>";
                    }?>
                </div>
                <hr/>
                <div class="am-u-sm-12 am-u-sm-centered">
                    <h2>相关项目</h2>
                </div>
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-title">项目名称</th><th class="table-type">区域</th><th class="table-type">套数</th><th class="table-date">均价</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($house_list as $k=>$v){?>
                        <tr>
                            <td><?=$v->house_name;?></td>
                            <td><?=$v->district_name;?></td>
                            <td><?=$v->d_cnt;?></td>
                            <td><?=floor($v->avg_price);?></td>
                        </tr>
                        <?php }?>
                        </tbody>
                    </table>


                    <hr />
                </form>
            </div>

        </div>
    </div>
    <!-- content end -->
</div>

<?php $this->load->view('/footer');?>
<script>

</script>
