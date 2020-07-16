<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">管理员列表</strong> / <small>Admin List</small></div>
        </div>
        <div class="am-g">
            <div class="am-u-md-6 am-cf">
                <div class="am-fl am-cf">
                    <div class="am-btn-toolbar am-fl">
                        <div class="am-btn-group am-btn-group-xs">
                            <a href="/admin/admin_add" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 新增</a>
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
                            <th class="table-title">管理电话</th><th class="table-type">姓名</th><th class="table-date">注册时间</th><th class="table-date">最后登陆时间</th><th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($userlist as $k=>$v){?>
                            <tr>
                                <td><?=$v->user_mobile;?></td>
                                <td><?=$v->user_name;?></td>
                                <td><?=$v->registration_time;?></td>
                                <td><?=$v->last_login_time;?></td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-xs am-text-secondary" href="/admin/admin_info/?id=<?=$v->id;?>"><span class="am-icon-pencil-square-o"></span>编辑</a>
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
