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
                <div class="am-tab-panel am-active" id="tab1">
                    <form action="/yearbook/add_gdpjbxx_Q" method="post" style="<?php echo $date_type == 'Q' ? "":"display: none";?>" onsubmit="return toVaild1()">
                        <table class="am-table table-main" style="background-color: #fffefe;">
                            <tr><td>年度</td><td><input class="q_year" type="number" style="width: 80%;" id="gdp_year" name="gdp_year" ></td>
                                <td>季度</td><td><input type="number" style="width: 80%;" id="gdp_quarter" name="gdp_quarter" ></td>
                            </tr>
                            <tr><td>当季值(亿元)</td><td><input type="text" style="width: 80%;" id="gdp_value_quarter" name="gdp_value_quarter" ></td>
                                <td>自年初累计值(亿元)</td><td><input type="text" style="width: 80%;" id="gdp_value_total" name="gdp_value_total" ></td>
                            </tr>
                        </table>
                        <div class="am-u-sm-10">
                            <div >
                                <input type="hidden" name="city_id" id="city_id" value="<?=$city_id;?>" />
                                <input type="hidden" name="id" id="id" value="<?=$id;?>" />
                                <button type="submit" class="am-btn am-btn-primary am-btn-xs">提交保存</button>
                            </div>
                        </div>
                    </form>
                    <form action="/yearbook/add_gdpjbxx_Y" method="post" style="<?php echo $date_type == 'Y' ? "":"display: none";?>" onsubmit="return toVaild2()">
                        <table class="am-table table-main" style="background-color: #fffefe;">
                            <tr><td>年度</td><td><input class="y_year" type="number" style="width: 80%;" id="gdp_year" name="gdp_year" ></td>
                            </tr>
                            <tr><td>第一产业值(亿元)</td><td><input type="text" style="width: 80%;" id="first_value" name="first_value" ></td>
                                <td>第二产业值(亿元)</td><td><input type="text" style="width: 80%;" id="second_value" name="second_value" ></td>
                                <td>第三产业值(亿元)</td><td><input type="text" style="width: 80%;" id="third_value" name="third_value" ></td>
                            </tr>
                            <tr><td>人均国内生产值(元)</td><td><input type="text" style="width: 80%;" id="per_gdp" name="per_gdp" ></td>
                                <td>总值(亿元)</td><td><input type="text" style="width: 80%;" id="total_value" name="total_value" ></td>
                            </tr>
                        </table>
                        <div class="am-u-sm-10">
                            <div >
                                <input type="hidden" name="city_id" id="city_id" value="<?=$city_id;?>" />
                                <input type="hidden" name="id" id="id" value="<?=$id;?>" />
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
        function toVaild1(){
            var gdp_year = $('.q_year');
            var gdp_quarter = $('#gdp_quarter');
            if(gdp_year.val().length == 0){
                gdp_year.css("border","1px solid red");
                return false;
            }
            if(gdp_quarter.val().length == 0){
                gdp_quarter.css("border","1px solid red");
                return false;
            }
            return true;
        }
        function toVaild2(){
            var gdp_year = $('.y_year');
            if(gdp_year.val().length == 0){
                gdp_year.css("border","1px solid red");
                return false;
            }
            return true;
        }
    </script>