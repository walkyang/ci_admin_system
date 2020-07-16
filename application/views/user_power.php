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
        <div class="am-u-sm-12">
                <div class="am-g admin-content-list">
                <div class="am-u-md-10 am-cf">
                    <div class="am-fl am-cf">
                        <div class="am-btn-toolbar am-fl">
                            <div class="am-form-group am-margin-left am-fl">
                                <select id="city_id" name="city_id" >
                                    <?php foreach($citylist as $k=>$v){?>
                                        <option <?php echo $v->city_id == $city_id ? 'selected="selected"' : ""; ?> value="<?=$v->city_id;?>" ><?=$v->city_name;?></option>
                                    <?php }?>

                                </select>
                                </div>
                            <div class="am-form-group am-margin-left ">
                                <select id="model_id" name="model_id" multiple="multiple" style="width: 20%">
                                        <option value="1">新房</option>
                                        <option value="2">二手</option>
                                        <option value="3">土地</option>
                                        <option value="4">新房排行</option>
                                        <option value="5">二手排行</option>
                                        <option value="6">土地排行</option>
                                        <option value="7">挂牌</option>
                                </select>
                                </div>
                            <div class="am-form-group am-margin-left am-fl">

                                <input type="date"  id="date" name="date" style="width: 150px;">
                                <input type="hidden"  id="user_id" name="user_id" value="<?=$user_id;?>" style="width: 100px;">

                                <div class="am-btn-group am-btn-group-xs" style="float: right;padding-left: 5px;">
                                <button type="button" class="am-btn am-btn-default add_power"><span class="am-icon-plus"></span> 添加权限</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        <div class="am-u-sm-12" style="padding-top: 5px;">
            <div class="am-g admin-content-list">
                <div class="am-u-md-12 am-cf">
                    <div class="am-fl am-cf">
                        <div class="am-btn-toolbar am-fl">
                            <div class="am-form-group am-margin-left am-fl">
                                已拥有权限城市：
                                <?php foreach($user_city_power as $k=>$v){?>
                                    <a href="/user/user_power/?id=<?=$user_id;?>&city_id=<?=$v->city_id;?>"><?=$v->city_name;?>(<?php echo $v->max_date > date('Y-m-d') ? $v->max_date: $v->max_date.'[过期]'?>)</a>&nbsp;&nbsp;
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="am-g ">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-title">城市</th><th class="table-type">模块ID</th><th class="table-type">模块</th><th class="table-date">截止日期</th><th class="table-date">编辑日期</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($user_power_list as $k=>$v){?>
                            <tr>
                                <td><?=$v['city_name'];?></td>
                                <td><?=$v['model_id'];?></td>
                                <td><?=$v['mk_name'];?></td>
                                <td><?=$v['valid_date'];?></td>
                                <td><?=$v['edit_time'];?></td>
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
<script src="/static/multipleassets/multiple-select.js"></script>
<script>
    $(function() {
        var  strcondition = '';
        var ids = strcondition.split(',');
        if (ids != null) {
            $('#model_id').val(ids);
        }

        $('#model_id').change(function() {
            console.log($(this).val());
        }).multipleSelect({
            width: '100%'
        });
    });
</script>
<script>
    $('#city_id').change(function(){
        var id = $('#user_id').val();
        window.location.href='/user/user_power/?id='+id+'&city_id='+$(this).val();
    });
    $('.add_power').click(function(){
        if($('#date').val() == ''){
            alert('请输入日期');
            return;
        }
        if($('#model_id').val() == null){
            alert('请选择模块');
            return;
        }
        $.post("/user/add_power", {
            user_id: $('#user_id').val(),
            city_id: $('#city_id').val(),
            model_id:$('#model_id').val(),
            valid_date:$('#date').val()
        },function(data) {
            if(data == -1){
                alert('当前日期小于已存在有效日期，请调整');
                return;
            }else if(data == 1){
                alert('添加成功');
                window.location.href='/user/user_power/?id='+$('#user_id').val()+'&city_id='+$('#city_id').val();
            }else{
                alert('出错了，请联系管理');
                return;
            }
        });
    });

</script>
