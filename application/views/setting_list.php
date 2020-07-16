<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">设置列表</strong> / <small>Setting List</small></div>
        </div>
            <div class="am-g">
                <div class="am-u-md-6 am-cf">
                    <div class="am-fl am-cf">
                        <div class="am-btn-toolbar am-fl">
                            <div class="am-form-group am-margin-left am-fl">
                                <select id="city_id" name="city_id">
                                    <?php foreach($citylist as $k=>$v){?>
                                        <option <?php echo $v->city_id == $city_id ? 'selected="selected"' : ""; ?> value="<?=$v->city_id;?>"><?=$v->city_name;?></option>
                                    <?php }?>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-title" style="width: 100px;">设置编号</th><th class="table-type" >设置描述</th><th class="table-author" style="width: 150px;">设置名称</th><th class="table-author" style="width: 100px;">设置值</th><th class="table-date" style="width: 150px;">修改日期</th><th class="table-set" style="width: 150px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($setting_list as $k=>$v){?>
                            <tr>
                                <td><?=$v->id;?></td>
                                <td><?=$v->setting_des;?></td>
                                <td id="name_<?=$v->id;?>"><?=$v->setting_name;?></td>
                                <td><input id="value_<?=$v->id;?>" value="<?=$v->setting_value;?>" /></td>
                                <td><?=$v->edit_time;?></td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a data-id="<?=$v->id;?>" data-value="<?=$v->setting_value;?>" class="edit am-btn am-btn-default am-btn-xs am-text-secondary" href="javascript:;"><span class="am-icon-pencil-square-o"></span> 编辑</a>
                                        </div>
                                    </div>
                                </td>
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
    $('#city_id').change(function(){
        window.location.href='/setting/setting_list/?city_id='+$(this).val();
    });
    $('.edit').click(function(){
        var id = $(this).attr('data-id');
        var value = $('#value_'+id).val();
        var name = $('#name_'+id).html();
        $.post("/setting/update_value", {
            id: id,
            value: value,
            name: name
        }, function (data) {
            if(data == 1){
                alert('更改成功');
                window.location.reload();
            }
        });
    });

</script>
