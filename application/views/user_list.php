<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">用户列表</strong> / <small>User List</small></div>
        </div>
        <form method="get" action="/user/user_list">
            <div class="am-g">
                <div class="am-u-md-6 am-cf">
                    <div class="am-fl am-cf">
                        <div class="am-btn-toolbar am-fl">
                            <div class="am-form-group am-margin-left am-fl">
                                <select id="user_source" name="user_source">
                                    <option <?php echo $user_source == 0 ? 'selected="selected"' : ""; ?>  value="0">全部</option>
                                    <option <?php echo $user_source == 10 ? 'selected="selected"' : ""; ?>  value="10">Dataface网页版</option>
                                    <option <?php echo $user_source == 20 ? 'selected="selected"' : ""; ?>  value="20">Dataface微信版</option>
                                    <option <?php echo $user_source == 30 ? 'selected="selected"' : ""; ?>  value="30">数脸微信版</option>
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
                            <th class="table-title">用户电话</th><th class="table-type">姓名</th><th class="table-type">公司</th><th class="table-type">职位</th><th class="table-type">状态</th><th class="table-date">最后登陆城市/期限</th><th class="table-date">最后登陆日期</th><th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($userlist as $k=>$v){?>
                            <tr>
                                <td><?=$v['user_mobile'];?></td>
                                <td><?=$v['user_name'];?></td>
                                <td><?=$v['user_company'];?></td>
                                <td><?=$v['user_position'];?></td>
                                <td><?=$v['is_del']==1 ? '<span style="color: red">禁用</span>':'正常';?></td>
                                <?php if($v['user_source'] == 30){?>
                                    <td><?=$v['city_power'];?></td>
                                <?php }else{?>
                                <td><?=$v['city_power'];?></td>
                                <?php }?>
                                <td><?=$v['last_login_time'];?></td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <?php if($v['user_source'] == 20){?>
                                                <a class="am-btn am-btn-default am-btn-xs am-text-secondary" href="/user/user_power_wx/?id=<?=$v['user_id'];?>&city_id=<?=$v['city_id'];?>"><span class="am-icon-pencil-square-o"></span>权(wx)</a>
                                            <?php } else if($v['user_source'] == 30){?>
                                                <a class="am-btn am-btn-default am-btn-xs am-text-secondary" href="/user/user_power_wxmedium/?id=<?=$v['user_id'];?>&city_id=<?=$v['city_id'];?>"><span class="am-icon-pencil-square-o"></span>权(wx中介)</a>
                                            <?php }else{?>
                                                <a class="am-btn am-btn-default am-btn-xs am-text-secondary" href="/user/user_power/?id=<?=$v['user_id'];?>&city_id=<?=$v['city_id'];?>"><span class="am-icon-pencil-square-o"></span>权(web)</a>
                                                <a  data-id="<?=$v['user_id'];?>" class="am-btn am-btn-default am-btn-xs am-text-secondary user_browser" href="javascript:;?>" ><span class="am-icon-pencil-square-o"></span>重置</a>
                                            <?php }?>
                                            <a class="am-btn am-btn-default am-btn-xs am-text-secondary" href="/user/user_info/?id=<?=$v['user_id'];?>"><span class="am-icon-pencil-square-o"></span>编</a>
                                            <?php if($v['is_del']==0){ ?>
                                            <a data-id="<?=$v['user_id'];?>" class="am-btn am-btn-default am-btn-xs am-text-danger user_jy" href="javascript:;"><span class="am-icon-trash-o"></span>禁</a>
                                            <?php }else{?>
                                            <a data-id="<?=$v['user_id'];?>" class="am-btn am-btn-default am-btn-xs am-text-success user_dk" href="javascript:;"><span class="am-icon-check-square-o"></span>启</a>
                                            <?php }?>
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
    $('#user_source').change(function(){
        window.location.href='/user/user_list?user_source='+$(this).val();
    });
    $('.user_jy').click(function(){
        var id = $(this).attr('data-id');
        $.post("/user/user_delete", {
            id: id,
            is_del:1
        }, function (data) {
            if(data == 1){
                alert('禁用成功');
                window.location.reload();
            }
        });
    });
    $('.user_dk').click(function(){
        var id = $(this).attr('data-id');
        $.post("/user/user_delete", {
            id: id,
            is_del:0
        }, function (data) {
            if(data == 1){
                alert('启用成功');
                window.location.reload();
            }
        });
    });
    $('.user_browser').click(function(){
        var id = $(this).attr('data-id');
        $.post("/user/user_browser", {
            id: id
        }, function (data) {
            if(data == 1){
                alert('重置成功');
                window.location.reload();
            }
        });
    });

</script>
