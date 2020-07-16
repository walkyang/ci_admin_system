<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">用户当前城市权限</strong> / <small>User Power</small></div>
        </div>
        <div class="am-u-sm-6">
            <div class="am-tabs-bd">
                <div class="am-tab-panel am-active id="tab1">
                <form action="/user/add_sales" method="post" onsubmit="return toVaild()">
                    <table class="am-table table-main" style="background-color: #ffffff;">
                        <tr><td>城市</td><td><select id="city_id" name="city_id" >
                                    <?php foreach($citylist as $k=>$v){?>
                                        <option <?php echo $v->city_id == $city_id ? 'selected="selected"' : ""; ?> value="<?=$v->city_id;?>" ><?=$v->city_name;?></option>
                                    <?php }?></select></td><td>购买类型</td><td><select id="sales_type" name="sales_type" >
                                    <option value="1">楼盘</option>
                                    <option value="2">区域</option>
                                    <option value="3">板块</option>
                                    <option value="4">城市</option>
                                    <option value="5">VIP</option>
                                </select></td>
                            <td>新房/2手</td>
                        <td><select id="is_first" name="is_first" >
                                <option value="2">二手</option>
                                <option value="1">新房</option>
                            </select></td></tr>
                        <tr><td>选择</td><td colspan="6"><input style="" type="text" id="txt_house_name" name="txt_house_name" class="am-input-sm sales_date" list="house_list" value=""/>
                                <datalist id="house_list">
                                </datalist>
                                <select name="district" id="district" style="display: none" class="sales_date">
                                    <option value="0">选择区域</option>
                                    <?php foreach($district_list as $k=>$v){ ?>
                                        <option value="<?=$v->district_id;?>"><?=$v->district_name;?></option>
                                    <?php }?>
                                </select><select name="plate" id="plate" style="display: none" class="sales_date">
                                    <option value="0">选择板块</option>
                                </select></td></tr>
                        <tr><td>日期</td><td colspan="6"><input type="date"  id="valid_date" name="valid_date" style="width: 150px;"><td></tr>

                    </table>
                    <div class="am-u-sm-10">
                        <div >
                            <input type="hidden" name="city_code" id="city_code" value="<?=$city_code;?>" />
                            <input type="hidden"  id="user_id" name="user_id" value="<?=$user_id;?>" style="width: 100px;">
                            <button type="submit" class="am-btn am-btn-primary am-btn-xs"><span class="am-icon-plus"></span> 添加权限</button>
                        </div>
                    </div>
                </form>
                </div>
                </div>
        </div>

        <div class="am-g ">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-title">购买类型</th><th class="table-type">订单编号</th><th class="table-type">订单名称</th><th class="table-type">金额</th><th class="table-date">订单状态</th><th class="table-date">到期日期</th><th class="table-date">购买日期</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($user_sales_list as $k=>$v){?>
                            <tr>
                                <td><?php $n = ''; switch($v->sales_type){
                                        case 1: $n = '楼盘'; break;
                                        case 2: $n = '区域'; break;
                                        case 3: $n = '板块'; break;
                                        case 4: $n = '城市'; break;
                                        case 5: $n = 'VIP'; break;
                                    };echo $n;?></td>
                                <td><?=$v->sales_no;?></td>
                                <td><?=$v->body;?></td>
                                <td><?=$v->sales_cost;?></td>
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
<script src="/static/multipleassets/multiple-select.js"></script>
<script>
    $('#txt_house_name').keyup(function(){
        var tt ="";
        $.post("/land/get_house", {
            city_code: $('#city_code').val(),
            key: $(this).val(),
            is_first:$('#is_first').val()
        }, function (data) {
            var json = eval(data); //数组
            $.each(json, function (index) {
                //循环获取数据
                var id = json[index].house_id;
                var name = json[index].house_name;
                tt += "<option value=\""+id+"-"+name+"\" label=\""+name+"\" />";
            });
            $('#house_list').html(tt);
        });
        $('#house_list').html(tt);
    });
    $('#district').change(function(){
        if($(this).val() > 0) {
            $.post("/land/get_plate", {
                city_code: $('#city_code').val(),
                district_id: $(this).val()
            }, function (data) {
                var json = eval(data); //数组
                var tt = "<option value=\"0\">选择板块</option>";
                $.each(json, function (index) {
                    //循环获取数据
                    var id = json[index].plate_id;
                    var name = json[index].plate_name;
                    tt += "<option value=\"" + id + "\">" + name + "</option>";
                });
                $('#plate').html(tt);
            });
        }else{
            var tt = "<option value=\"0\">选择板块</option>";
            $('#plate').html(tt);
        }
    });
    $('#city_id').change(function(){
        var id = $('#user_id').val();
        window.location.href='/user/user_power_wxmedium/?id='+id+'&city_id='+$(this).val();
    });
    $('#sales_type').change(function(){
        var sales_type = $('#sales_type').val();
        var txt_house_name = $('#txt_house_name');
        var district = $('#district');
        var plate = $('#plate');
        $('.sales_date').hide();
        switch (parseInt(sales_type)){
            case 1:txt_house_name.show();break;
            case 2:district.show();break;
            case 3:district.show();plate.show();break;
            case 4:break;
            case 5:break;
        }
    });
    function toVaild(){
        var sales_type =  $('#sales_type').val();
        var valid_date = $('#valid_date').val();
        var today= new Date();

        if(valid_date == '' ){
            alert('日期不可为空且不可以小于当前日期')
            return false;
        }
        if(parseInt(sales_type) == 1){
            if($('#txt_house_name').val() == ''){
                alert('楼盘信息不可为空');
                return false;
            }
        }else if(parseInt(sales_type) == 2){
            if($('#district').val() == '' || $('#district').val() == 0){
                alert('区域信息不可为空');
                return false;
            }
        }else if(parseInt(sales_type) == 3){
            if(($('#district').val() == '' || $('#district').val() == 0) || ($('#plate').val() == '' || $('#plate').val() == 0)){
                alert('区域和板块信息不可为空');
                return false;
            }
        }
        return true;
    }
</script>
