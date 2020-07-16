<?php $this->load->view('/header');?>
    <div class="am-cf admin-main">
        <!-- sidebar start -->
        <?php $this->load->view('/mainleft');?>
        <!-- sidebar end -->
<!-- content start -->
<div class="admin-content">

    <div class="am-cf am-padding">
        <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">首页</strong> / Index<small></small></div>
    </div>

    <div id="chart0" style="height:400px;auto;width: 100%;"></div>

    <div class="am-cf am-padding">
        <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">土地消息</strong> / Land  <small></small></div>
    </div>
    <div class="am-g">
        <div class="am-u-sm-12">
            <table class="am-table am-table-bd am-table-striped admin-content-table">
                <thead>
                <tr>
                    <th>ID</th><th>城市</th><th>新增地块</th><th>更新地块</th><th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($land_list as $k=>$v){?>
                <tr><td><?=$v->city_id?></td><td><?=$v->city_name?></td><td><span class="am-badge am-badge-danger"><?=$v->add_cnt?></span></td> <td><span class="am-badge am-badge-success"><?=$v->update_cnt?></span></td>
                    <td>
                        <div class="am-btn-toolbar">
                            <div class="am-btn-group am-btn-group-xs">
                                <a class="am-btn am-btn-default am-btn-xs am-text-secondary" href="/land/land_list?city_id=<?=$v->city_id;?>"><span class="am-icon-pencil-square-o"></span>编辑</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- content end -->
</div>
    <script src="/static/js/echarts.min.js"></script>

<script>
    // 基于准备好的dom，初始化echarts实例
    var myChart0 = echarts.init(document.getElementById('chart0'));
    // 指定图表的配置项和数据
    var date_arr=<?= json_encode($date_arr) ;?>;
    var dataface_pv_arr=<?= json_encode($dataface_pv_arr) ;?>;
    var dataface_wx_pv_arr=<?= json_encode($dataface_wx_pv_arr) ;?>;
    var shulian_pv_arr=<?= json_encode($shulian_pv_arr) ;?>;
    var colors = ['#5793f3', '#d14a61','#5793f3'];
    option = {
        title : {
            text: '近一周访问量',
            subtext: ''
        },
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            data:['Dataface','Dataface-小程序','数脸']
        },
        toolbox: {
            show : false,
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                boundaryGap : false,
                data : date_arr
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series : [
            {
                name:'Dataface',
                type:'line',
                smooth:true,
                itemStyle: {normal: {areaStyle: {type: 'default'}}},
                data:dataface_pv_arr
            },
            {
                name:'Dataface-小程序',
                type:'line',
                smooth:true,
                itemStyle: {normal: {areaStyle: {type: 'default'}}},
                data:dataface_wx_pv_arr
            },
            {
                name:'数脸',
                type:'line',
                smooth:true,
                itemStyle: {normal: {areaStyle: {type: 'default'}}},
                data:shulian_pv_arr
            }
        ]
    };
    // 使用刚指定的配置项和数据显示图表。
    myChart0.setOption(option);
    window.onresize = function(){
        myChart0.resize();
    }
</script>
<?php $this->load->view('/footer');?>