<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">GDP列表</strong> / <small>GDP List</small></div>
        </div>
        <form method="get" action="/gdp/gdp_list">
            <div class="am-g">
                <div class="am-u-md-6 am-cf">
                    <div class="am-fl am-cf">
                        <div class="am-btn-toolbar am-fl">
                            <div class="am-btn-group am-btn-group-xs">
                                <a href="/yearbook/gdp_add?city_id=<?=$city_id?>&date_type=<?=$date_type?>" target="_blank" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 新增</a>
                            </div>
                            <div class="am-form-group am-margin-left am-fl">
                                <select id="city_id" name="city_id">
                                    <?php foreach($citylist as $k=>$v){?>
                                        <option <?php echo $v->city_id == $city_id ? 'selected="selected"' : ""; ?> value="<?=$v->city_id;?>"><?=$v->city_name;?></option>
                                    <?php }?>

                                </select>
                            </div>
                            <div class="am-form-group am-margin-left am-fl">
                                <select id="date_type" name="date_type">
                                    <option <?php echo $date_type == 'Q' ? 'selected="selected"' : ""; ?> value="Q">季</option>
                                    <option <?php echo $date_type == 'Y' ? 'selected="selected"' : ""; ?> value="Y">年</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main" style="<?php echo $date_type == 'Q' ? "":"display: none";?>">
                        <thead>
                        <tr>
                            <th class="table-title" style="width: 200px;">季度</th><th class="table-type" >自年初累计值(亿)</th><th class="table-author" style="width: 150px;">当季值(亿)</th><th class="table-set" style="width: 150px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($gdp_list as $k=>$v){?>
                            <tr>
                                <td><?=$v->gdp_year.'年第'.$v->gdp_quarter.'季度';?></td>
                                <td><?=$v->gdp_value_total;?></td>
                                <td><?=$v->gdp_value_quarter;?></td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a target="_blank" class="am-btn am-btn-default am-btn-xs am-text-secondary" href="/yearbook/gdp_info/?id=<?=$v->id;?>&city_id=<?=$city_id;?>&date_type=<?=$date_type;?>"><span class="am-icon-pencil-square-o"></span> 编辑</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php }?>

                        </tbody>
                    </table>
                    <table class="am-table am-table-striped am-table-hover table-main" style="<?php echo $date_type == 'Y' ? "":"display: none";?>">
                        <thead>
                        <tr>
                            <th class="table-title" style="width: 100px;">年度</th><th class="table-type" style="width: 150px;" >第一产业值(亿)</th><th class="table-author" style="width: 150px;">第二产业值(亿)</th><th class="table-author" style="width: 150px;">第三产业值(亿)</th><th class="table-author" style="width: 150px;">总值(亿)</th><th class="table-author" >人均国内生产总值(元)</th><th class="table-set" style="width: 150px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($gdp_list as $k=>$v){?>
                            <tr>
                                <td><?=$v->gdp_year.'年';?></td>
                                <td><?=$v->first_value;?></td>
                                <td><?=$v->second_value;?></td>
                                <td><?=$v->third_value;?></td>
                                <td><?=$v->total_value;?></td>
                                <td><?=$v->per_gdp;?></td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a target="_blank" class="am-btn am-btn-default am-btn-xs am-text-secondary" href="/yearbook/gdp_info/?id=<?=$v->id;?>&city_id=<?=$city_id;?>&date_type=<?=$date_type;?>"><span class="am-icon-pencil-square-o"></span> 编辑</a>
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
        var date_type = $('#date_type').val();
        window.location.href='/yearbook/gdp_list/?city_id='+$(this).val()+'&date_type='+date_type;
    });
    $('#date_type').change(function(){
        var city_id = $('#city_id').val();
        window.location.href='/yearbook/gdp_list/?city_id='+city_id+'&date_type='+$(this).val();
    });

</script>
