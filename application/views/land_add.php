<?php $this->load->view('/header');?>
<div class="am-cf admin-main">
    <!-- sidebar start -->
    <?php $this->load->view('/mainleft');?>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content">

        <div class="am-tabs am-margin" data-am-tabs>
            <ul class="am-tabs-nav am-nav am-nav-tabs">
                <li class="am-active"><a href="#tab1">基本信息</a></li>
            </ul>

            <div class="am-tabs-bd">
                <div class="am-tab-panel am-active id="tab1">
                    <form action="/land/add" method="post" onsubmit="return toVaild()">
                    土地信息
                    <table class="am-table table-main" style="background-color: #f9f2f2;">
                        <tr><td width="120px;">土地公告号</td><td width="300px;"><input type="text" id="land_no" name="land_no" style="width: 80%;"></td><td width="100px;">土地名称</td><td colspan="3"><input type="text" id="dkmc" name="dkmc" style="width: 80%;"></td></tr>
                        <tr><td>区域</td><td> <select name="district" id="district" style="width: 80%;">
                                    <option value="0">选择区域</option>
                                    <?php foreach($district_list as $k=>$v){ ?>
                                            <option value="<?=$v->district_id;?>"><?=$v->district_name;?></option>
                                    <?php }?>
                                </select></td><td width="100px;">板块</td><td width="300px;"><select name="plate" id="plate"  style="width: 80%;">
                                    <option value="0">选择板块</option>
                                </select></td><td width="100px;">环线</td><td width="300px;"><select name="loop" id="loop" style="width: 100px;">
                                    <option value="0">选择环线</option>
                                    <?php foreach($loop_list as $k=>$v){ ?>
                                        <option value="<?=$v->loop_id;?>"><?=$v->loop_name;?></option>
                                    <?php }?>
                                </select></td></tr>
                        <tr><td>四至范围</td><td colspan="5"><input type="text" style="width: 80%;" id="szfw" name="szfw"></td></tr>
                        <tr><td>出让面积</td><td><input type="text" style="width: 80%;" id="crmj" name="crmj"></td><td>建筑面积</td><td><input type="text" style="width: 80%;" id="build_area" name="build_area"></td><td>土地现状</td><td><select name="land_status" id="land_status" style="width: 80%;">
                                    <option value="0">请选择</option>
                                    <option value="1">未开工</option>
                                    <option value="2">部分开工</option>
                                    <option value="3">全部开工</option>
                                </select></td></tr>
                        <tr><td>土地属性</td><td colspan="5"><input type="text" style="width: 80%;" id="tdtype" name="tdtype"></td></tr>
                        <tr><td>使用年限</td><td colspan="5"><input type="text" style="width: 80%;" id="crnx" name="crnx"></td></tr>
                        <tr><td>容积率(文字)</td><td><input type="text" style="width: 80%;" id="rjl" name="rjl"></td><td>绿化率</td><td><input type="text" style="width: 80%;" id="green_ratio" name="green_ratio"></td><td></td><td></td></tr>
                        <tr><td>建筑密度</td><td><input type="text" style="width: 80%;" id="build_density" name="build_density"></td><td>建筑限高</td><td><input type="text" style="width: 80%;" id="build_height" name="build_height"></td><td></td><td></td></tr>
                        <tr><td>容积率(数字)</td><td><input type="text" style="width: 80%;" id="house_type_rjl" name="house_type_rjl"></td><td>特殊用途</td><td><select name="land_type_id" id="land_type_id">
                                    <option value="0">请选择</option>
                                    <option value="1">租赁住房</option>
                                    <option value="2">廉租房</option>
                                    <option value="3">配套商品房</option>
                                    <option value="4">经济适用房</option>
                                    <option value="5">两限房</option>
                                    <option value="6">动迁安置房</option>
                                    <option value="7">其他</option>
                                </select></td><td>土地属性</td><td><select name="house_type_id" id="house_type_id">
                                    <option value="1">住宅</option>
                                    <option value="2">商业</option>
                                    <option value="3">办公</option>
                                    <option value="4">商办</option>
                                    <option value="5">综合</option>
                                    <option value="6">科研</option>
                                    <option value="7">工业</option>
                                    <option value="8">商住</option>
                                    <option value="9">其他</option>
                                </select></td></tr>

                        <tr><td>周边规划</td><td colspan="5"><input type="text" style="width: 80%;" id="land_zhoubian" name="land_zhoubian"></td></tr>
                    </table>
                    上市信息
                    <table class="am-table table-main" style="background-color: #f2fbe3;">
                        <tr><td width="140px;">公告日期</td><td width="300px;"><input type="date" value="<?php echo date('Y-m-d');?>" id="fbsj" name="fbsj" style="width: 80%;"></td><td width="150px;">出让人</td><td width="300px;"><input type="text" id="crr" name="crr" style="width: 80%;"></td><td width="200px;">出让方式</td><td width="300px;"><select name="crfs_state" id="crfs_state" style="width: 40%;">
                                    <option value="0">请选择</option>
                                    <option value="1">协议土地</option>
                                    <option value="2">招挂复合</option>
                                    <option value="3">挂牌</option>
                                    <option value="4">其他出让土地</option>
                                </select></td></tr>
                        <tr><td>报名日期</td><td><input type="text" id="jsjmkssj" name="jsjmkssj" style="width: 40%;">-<input type="text" id="jsjmjssj" name="jsjmjssj" style="width: 40%;"></td><td>挂牌日期</td><td colspan="3" width="300px;"><input type="text" id="gpbjkssj" name="gpbjkssj" style="width: 20%;">-<input type="text" id="gpbjjssj" name="gpbjjssj" style="width: 20%;"></td></tr>
                        <tr><td>文件领取日期</td><td><input type="text" id="ffwjkssj" name="ffwjkssj" style="width: 40%;">-<input type="text" id="ffwjjzsj" name="ffwjjzsj" style="width: 40%;"></td><td>到账日期</td><td><input type="text" id="bzjsj" name="bzjsj" style="width: 80%"></td></tr>
                        <tr><td>出让底价(万)</td><td><input type="text" id="qsj" name="qsj" style="width: 80%"></td><td>楼板价(元/㎡)</td><td><input type="text" id="lbj" name="lbj" style="width: 80%"></td><td>每亩地价(万元/亩)</td><td><input type="text" id="mmdj" name="mmdj" style="width: 80%"></td></tr>
                        <tr><td>最小增幅(万)</td><td><input type="text" id="zxzf" name="zxzf" style="width: 80%"></td><td>竞买保证金(万)</td><td><input type="text" id="jmbzj" name="jmbzj" style="width: 80%"></td><td>投资强度(万元/亩)</td><td><input type="text" id="tzqd" name="tzqd" style="width: 80%"></td></tr>
                        <tr><td>联系电话</td><td><input type="text" id="contact_tel" name="contact_tel" style="width: 80%"></td><td>联系地址</td><td><input type="text" id="contact_address" name="contact_address" style="width: 80%"></td><td>交易地址</td><td><input type="text" id="jy_address" name="jy_address" style="width: 80%"></td></tr>
                    </table>
                    成交信息
                    <table class="am-table table-main" style="background-color: #fafdd1;">
                        <tr><td width="100px;">交易现状</td><td width="300px;"><select name="block_state" id="block_state" style="width: 40%;">
                                    <option value="0">请选择</option>
                                    <option value="1">正在交易</option>
                                    <option value="2">已成交</option>
                                    <option value="3">未上市</option>
                                    <option value="4">撤牌</option>
                                    <option value="5">流标</option>
                                    <option  value="6">政府回收</option>
                                    <option  value="7">中止</option>
                                    <option  value="8">终止</option>
                                </select></td><td width="150px;">成交日期</td><td width="300px;" colspan="3"><input type="date" id="jdrq" name="jdrq" style="width: 40%"></td></tr>
                        <tr><td>成交总价(万)</td><td><input type="text" id="jdj" name="jdj" style="width: 40%"></td><td>成交楼板价(元/㎡)</td><td><input type="text" id="jdlbj" name="jdlbj" style="width: 40%"></td></tr>
                        <tr><td>每亩地价(万)</td><td><input type="text" id="jdmmdj" name="jdmmdj" style="width: 40%"></td><td>溢价率</td><td><input type="text" id="yjl" name="yjl" style="width: 40%"></td></tr>
                        <tr><td>受让人</td><td><input type="text" id="jdr" name="jdr" style="width: 80%"></td><td>对应楼盘</td><td><input style="width: 40%" type="text" id="txt_house_name" name="txt_house_name" class="am-input-sm" list="house_list" />
                                <datalist id="house_list">

                                </datalist></td></tr>
                    </table>
                    标书及相关文件
                    <table class="am-table table-main" style="background-color: #eafbfa;">
                        <tr><td width="150px;">出让须知链接</td><td><input type="text" id="crxz" name="crxz" style="width: 80%"></td></tr>
                        <tr><td>预售合同链接</td><td><input type="text" id="ysht" name="ysht" style="width: 80%"></td></tr>
                        <tr><td>出让文件链接</td><td><input type="text" id="crwj" name="crwj" style="width: 80%"></td></tr>
                    </table>
                    <div class="am-u-sm-10">
                        <div >
                            <input type="hidden" name="city_code" id="city_code" value="<?=$city_code;?>" />
                            <input type="hidden" name="city_id" id="city_id" value="<?=$city_id;?>" />
                            <button type="submit" class="am-btn am-btn-primary am-btn-xs">提交保存</button>
                        </div>
                    </div>
                    </form>
                </div>

            </div>
        </div>
        <!-- content end -->
    </div>

    <?php $this->load->view('/footer');?>
    <script>
        $.post("/land/get_plate", {
            city_code: $('#city_code').val(),
            district_id: $('#district').val()
        }, function (data) {
            var json = eval(data); //数组
            var tt = "<option value=\"0\">选择板块</option>";
            $.each(json, function (index) {
                //循环获取数据
                var id = json[index].plate_id;
                var name = json[index].plate_name;
                tt += "<option value=\"" + id + "\">" + name + "</option>";
            });
            $('#plate').html(tt);
        });
        $('#district').change(function(){
            if($(this).val() > 0) {
                $.post("/land/get_plate", {
                    city_code: $('#city_code').val(),
                    district_id: $(this).val()
                }, function (data) {
                    var json = eval(data); //数组
                    var tt = "<option value=\"0\">选择板块</option>";
                    $.each(json, function (index) {
                        //循环获取数据
                        var id = json[index].plate_id;
                        var name = json[index].plate_name;
                        tt += "<option value=\"" + id + "\">" + name + "</option>";
                    });
                    $('#plate').html(tt);
                });
            }else{
                var tt = "<option value=\"0\">选择板块</option>";
                $('#plate').html(tt);
            }
        });
        $('#txt_house_name').keyup(function(){
            var tt ="";
            $.post("/land/get_house", {
                city_code: $('#city_code').val(),
                key: $(this).val()
            }, function (data) {
                var json = eval(data); //数组
                $.each(json, function (index) {
                    //循环获取数据
                    var id = json[index].house_id;
                    var name = json[index].house_name;
                    tt += "<option value=\""+id+"-"+name+"\" label=\""+name+"\" />";
                });
                $('#house_list').html(tt);
            });
            $('#house_list').html(tt);
        });
        
        function toVaild(){
            var land_no = $('#land_no');
            var dkmc = $('#dkmc');
            var fbsj = $('#fbsj');
            if(land_no.val().length == 0){
                land_no.css("border","1px solid red");
                land_no.focus();
                return false;
            }
            if(dkmc.val().length == 0){
                dkmc.css("border","1px solid red");
                dkmc.focus();
                return false;
            }
            if(fbsj.val().length == 0){
                fbsj.css("border","1px solid red");
                return false;
            }
            return true;
        }
    </script>
