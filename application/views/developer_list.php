<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">企业系列表</strong> / <small>Developer List</small></div>
        </div>
        <div class="am-g">
            <div class="am-u-md-6 am-cf">
                <div class="am-fl am-cf">
                    <div class="am-btn-toolbar am-fl">
                        <div class="am-btn-group am-btn-group-xs">
                            <a href="/developer/developer_add" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 新增</a>
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
                            <th class="table-title">ID</th><th class="table-type">企业简称</th><th class="table-type">企业全称</th><th class="table-type">首字母</th><th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($developerlist as $k=>$v){?>
                            <tr>
                                <td><?=$v->company_id;?></td>
                                <td><?=$v->short_name;?></td>
                                <td><?=$v->full_name;?></td>
                                <td><?=$v->first_py;?></td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-xs am-text-secondary" href="/developer/developer_info/?id=<?=$v->company_id;?>"><span class="am-icon-pencil-square-o"></span>编辑</a>
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

</script>
