<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">区域列表</strong> / <small>District List</small></div>
        </div>
        <form method="get" action="/land/land_list">
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
        </form>
        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-title" style="width: 100px;">区域编号</th><th class="table-type" >区域名称</th><th class="table-author" style="width: 150px;">行政面积(平方公里)</th><th class="table-author" style="width: 100px;">常住人口(万)</th><th class="table-date" style="width: 150px;">修改日期</th><th class="table-set" style="width: 150px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($district_list as $k=>$v){?>
                            <tr>
                                <td><?=$v['district_id'];?></td>
                                <td><?=$v['district_name'];?></td>
                                <td><?=$v['district_area'];?></td>
                                <td><?=$v['resident_population'];?></td>
                                <td><?=$v['edit_time'];?></td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a target="_blank" class="am-btn am-btn-default am-btn-xs am-text-secondary" href="/dist/district_info/?id=<?=$v['district_id'];?>&city_id=<?=$city_id;?>&district_name=<?=$v['district_name'];?>"><span class="am-icon-pencil-square-o"></span> 编辑</a>
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
        window.location.href='/dist/district_list/?city_id='+$(this).val();
    });

</script>
