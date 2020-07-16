<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">订单列表</strong> / <small>Order List</small></div>
        </div>
        <div class="am-g">
            <div class="am-tabs-bd">
                <div class="am-tab-panel am-active" id="tab1">
                    <form action="/user/sales_list" method="get">
                        <table class="am-table table-main" style="background-color: #fffefe;">
                            <tr><td>城市</td><td><select id="city_id" name="city_id" >
                                        <option value="0">全部</option>
                                        <?php foreach($citylist as $k=>$v){?>
                                            <option <?php echo $v->city_id == $city_id ? 'selected="selected"' : ""; ?> value="<?=$v->city_id;?>" ><?=$v->city_name;?></option>
                                        <?php }?></select></td>
                                <td>类型</td><td><select id="sales_type" name="sales_type" >
                                        <option value="0">全部</option>
                                        <option <?php echo $sales_type == 1 ? 'selected="selected"' : ""; ?> value="1">楼盘</option>
                                        <option <?php echo $sales_type == 2 ? 'selected="selected"' : ""; ?> value="2">区域</option>
                                        <option <?php echo $sales_type == 3 ? 'selected="selected"' : ""; ?> value="3">板块</option>
                                        <option <?php echo $sales_type == 4 ? 'selected="selected"' : ""; ?> value="4">城市</option>
                                        <option <?php echo $sales_type == 5 ? 'selected="selected"' : ""; ?> value="5">VIP</option>
                                    </select></td>
                                <td>电话/姓名</td><td><input type="text" style="width: 80%;" id="user_key" name="user_key" value="<?=$user_key;?>" ></td>
                                <td>订单编号</td><td><input type="text" style="width: 80%;" id="sales_no" name="sales_no" value="<?=$sales_no;?>" ></td>
                            </tr>
                            <tr><td>开始日期</td><td><input type="date" style="width: 80%;" id="s_date" name="s_date" value="<?=$s_date;?>" ></td>
                                <td>结束日期</td><td><input type="date" style="width: 80%;" id="e_date" name="e_date" value="<?=$e_date;?>" ></td>
                            </tr>
                            <tr><td colspan="8">总计：共<b><?=$total_cnt;?></b>条订单。其中已支付订单<b><?=$pay_cnt;?></b>条，金额：<b style="color: #cf2d27;"><?=$pay_cost;?></b>元。未支付<b><?=$nopay_cnt;?></b>条，金额：<b style="color: #00CC00"><?=$nopay_cost;?></b>元。</td></tr>
                        </table>
                        <div class="am-u-sm-10">
                            <div >
                                <button type="submit" class="am-btn am-btn-primary am-btn-xs">查询</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-title">城市</th><th class="table-title">类型</th><th class="table-type">订单编号</th><th class="table-type">订单名称</th><th class="table-type">金额</th><th class="table-title">姓名</th><th class="table-title">手机号码</th><th class="table-date">订单状态</th><th class="table-date">到期日期</th><th class="table-date">购买日期</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($user_sales_list as $k=>$v){?>
                            <tr>
                                <td><?=$v->city_name;?></td>
                                <td><?php $n = ''; switch($v->sales_type){
                                        case 1: $n = '楼盘'; break;
                                        case 2: $n = '区域'; break;
                                        case 3: $n = '板块'; break;
                                        case 4: $n = '城市'; break;
                                        case 5: $n = 'VIP'; break;
                                    };echo $n;?></td>
                                <td><?=$v->sales_no;?></td>
                                <td><?=$v->body;?></td>
                                <td><?php echo $v->status == 1 ? '<b style="color: #cf2d27;">'.$v->sales_cost.'</b>': '<b style="color: #00CC00;">'.$v->sales_cost.'</b>';?></td>
                                <td><?=$v->user_name;?></td>
                                <td><?=$v->user_mobile;?></td>
                                <td><?php echo $v->status == 1 ? '支付':'未支付';?></td>
                                <td><?=$v->valid_date;?></td>
                                <td><?=$v->add_time;?></td>
                            </tr>
                        <?php }?>

                        </tbody>
                    </table>
                    <div class="am-cf">
                        <?php echo $pagestr;?>
                    </div>

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
