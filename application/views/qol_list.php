<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">居民生活水平&居住面积</strong> / <small>Qol List</small></div>
        </div>
        <div class="am-g">
            <div class="am-u-md-6 am-cf">
                <div class="am-fl am-cf">
                    <div class="am-btn-toolbar am-fl">
                        <div class="am-btn-group am-btn-group-xs">
                            <a href="/yearbook/qol_add?city_id=<?=$city_id?>" target="_blank" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 新增</a>
                        </div>
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
                            <th class="table-title" style="width: 100px;">年度</th><th class="table-type" style="width: 150px;" >人均居住面积(平方米)</th><th class="table-author" style="width: 150px;">人均可支配收入(元)</th><th class="table-author" style="width: 150px;">人均消费性支出(元)</th><th class="table-author" style="width: 150px;">年末居民储蓄余额(亿元)</th><th class="table-set" style="width: 150px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($pop_list as $k=>$v){?>
                            <tr>
                                <td><?=$v->qol_year.'年';?></td>
                                <td><?=$v->per_build_area;?></td>
                                <td><?=$v->per_disposable_income;?></td>
                                <td><?=$v->per_consumer_spending;?></td>
                                <td><?=$v->savings_surplus;?></td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a target="_blank" class="am-btn am-btn-default am-btn-xs am-text-secondary" href="/yearbook/qol_info/?id=<?=$v->id;?>&city_id=<?=$city_id;?>"><span class="am-icon-pencil-square-o"></span> 编辑</a>
                                        </div>
                                    </div>
                                </td>
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
    $('#city_id').change(function(){
        window.location.href='/yearbook/qol_list/?city_id='+$(this).val();
    });

</script>
