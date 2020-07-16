<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">房地产投资-总投资</strong> / <small>Realty Price List</small></div>
        </div>
        <div class="am-g">
            <div class="am-u-md-6 am-cf">
                <div class="am-fl am-cf">
                    <div class="am-btn-toolbar am-fl">
                        <div class="am-btn-group am-btn-group-xs">
                            <a href="/yearbook/realtyprice_add?city_id=<?=$city_id?>" target="_blank" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 新增</a>
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
                            <th class="table-title" style="width: 100px;">年度</th><th class="table-title" style="width: 150px;">月度<span style="color:red;">(12月为年度)</span></th><th class="table-type" style="width: 150px;" >商品房累计值(亿)</th><th class="table-author" style="width: 150px;">住宅累计值(亿)</th><th class="table-author" style="width: 150px;">商业累计值(亿)</th><th class="table-author" style="width: 150px;">办公累计值(亿)</th><th class="table-set" style="width: 150px;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($pop_list as $k=>$v){?>
                            <tr>
                                <td><?=$v->realty_year.'年';?></td>
                                <td><?=$v->realty_month.'月';?></td>
                                <td><?=$v->realty_spf_total_price;?></td>
                                <td><?=$v->realty_zz_total_price;?></td>
                                <td><?=$v->realty_sy_total_price;?></td>
                                <td><?=$v->realty_bg_total_price;?></td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a target="_blank" class="am-btn am-btn-default am-btn-xs am-text-secondary" href="/yearbook/realtyprice_info/?id=<?=$v->id;?>&city_id=<?=$city_id;?>"><span class="am-icon-pencil-square-o"></span> 编辑</a>
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
        window.location.href='/yearbook/realtyprice_list/?city_id='+$(this).val();
    });

</script>
