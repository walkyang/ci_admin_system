<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">地块列表</strong> / <small>Land List</small></div>
        </div>
        <form method="get" action="/land/land_list">
        <div class="am-g">
            <div class="am-u-md-6 am-cf">
                <div class="am-fl am-cf">
                    <div class="am-btn-toolbar am-fl">
                        <div class="am-btn-group am-btn-group-xs">
                            <a href="/land/land_add?city_id=<?=$city_id?>" target="_blank" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 新增</a>
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
            <div class="am-u-md-3 am-cf">
                <div class="am-fr">
                    <div class="am-input-group am-input-group-sm">
                        <input type="text" class="am-form-field" id="key" name="key">
                <span class="am-input-group-btn">
                  <button class="am-btn am-btn-default" type="submit">搜索</button>
                </span>
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
                            <th class="table-title">地块编号</th><th class="table-type">地块名称</th><th class="table-author" style="width: 100px;">出让面积(㎡)</th><th class="table-author" style="width: 100px;">建筑面积(㎡)</th><th class="table-date" style="width: 100px;">发布日期</th><th class="table-date" style="width: 100px;">成交日期</th><th class="table-date" style="width: 50px;">状态</th><th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($landlist as $k=>$v){?>
                        <tr>
                            <td><?=$v->land_no;?></td>
                            <td><?=$v->dkmc;?></td>
                            <td><?=$v->crmj;?></td>
                            <td><?=$v->build_area;?></td>
                            <td><?=$v->fbsj;?></td>
                            <td><?=$v->jdrq;?></td>
                            <td><?php switch($v->is_state){
                                    case 1:echo '<span style="color: green">更新</span>';break;
                                    case 2:echo '<span style="color: red">新增</span>';break;
                                    default:echo '';break;
                                }?></td>
                            <td>
                                <div class="am-btn-toolbar">
                                    <div class="am-btn-group am-btn-group-xs">
                                        <a target="_blank" class="am-btn am-btn-default am-btn-xs am-text-secondary" href="/land/land_info/?id=<?=$v->land_id;?>"><span class="am-icon-pencil-square-o"></span> 编辑</a>
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
        window.location.href='/land/land_list/?city_id='+$(this).val();
    });

</script>
