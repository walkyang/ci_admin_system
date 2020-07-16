<div class="admin-sidebar" style="display: block;">
    <ul class="am-list admin-sidebar-list">
        <li><a href="/index"><span class="am-icon-home"></span> 首页</a></li>
        <li><a href="/user/user_list"><span class="am-icon-user"></span> 用户</a></li>
        <li><a href="/user/sales_list"><span class="am-icon-hand-o-right"></span> 订单</a></li>
        <li><a href="/land/land_list?city_id=1"><span class="am-icon-th"></span> 地块</a></li>
        <li class="admin-parent">
            <a class="am-cf am-collapsed" data-am-collapse="{target: '#collapse-nav'}"><span class="am-icon-book"></span>年鉴<span class="am-icon-angle-right am-fr am-margin-right"></span></a>
            <ul class="am-list am-collapse admin-sidebar-sub" id="collapse-nav">
                <li><a href="/dist/district_list?city_id=1"><span class="am-icon-tree"></span> 行政板块</a></li>
                <li><a href="/yearbook/gdp_list?city_id=1"><span class="am-icon-gbp"></span> GDP</a></li>
                <li><a href="/yearbook/pop_list?city_id=1"><span class="am-icon-user-md"></span> 人口</a></li>
                <li><a href="/yearbook/qol_list?city_id=1"><span class="am-icon-life-saver"></span> 居民生活水平&居住面积</a></li>
                <!--<li><a href="#"><span class="am-icon-area-chart"></span> 人均居住面积</a></li>-->
                <li><a href="/yearbook/fixedassets_list?city_id=1"><span class="am-icon-money"></span> 固定资产投资</a></li>
                <li><a href="/yearbook/realtyprice_list?city_id=1"><span class="am-icon-home"></span>①房地产投资-总资产</a></li>
                <li><a href="/yearbook/realtycompletedarea_list?city_id=1"><span class="am-icon-home"></span>②房地产投资-竣工面积</a></li>
                <li><a href="/yearbook/realtybuildarea_list?city_id=1"><span class="am-icon-home"></span>③房地产投资-施工面积</a></li>
                <li><a href="/yearbook/realtynewstartarea_list?city_id=1"><span class="am-icon-home"></span>④房地产投资-新开工面积</a></li>
            </ul>
        </li>
        <li><a href="/developer/developer_list"><span class="am-icon-krw"></span> 企业系</a></li>
        <li><a href="/setting/setting_list?city_id=1"><span class="am-icon-pencil"></span> 设置</a></li>
        <li><a href="/admin/admin_list"><span class="am-icon-users"></span> 管理员</a></li>
        <li><a href="/report/month_tj?city_id=1&is_sjprice=1"><span class="am-icon-paper-plane"></span> 月报</a></li>
    </ul>

    <div class="am-panel am-panel-default admin-sidebar-panel">
        <div class="am-panel-bd">
            <p><span class="am-icon-bookmark"></span> DataFace数据智库：</p>
            <p><?php $minyan = ["沧桑话巨变，数据铸辉煌。","胸中有“数”，心中有“术”。","一个数据、一张报表、一篇分析，凝聚统计人的勤奋与自豪。",
                "诚信立统、真实铸统、敬业谋统、创新活统。","出真实数据，确保决策的科学有据；做扎实工作，诠释统计人生的平凡风雅。","德为本，勤为先，求真统计；法为上，民为重，务实调研。",
                "漫漫人生路，步步统计情。","如果你能敏锐地观察，就能明智地调查和判断。","手中笔书写统计华篇章，表中数据体现发展变化。","数字不能说明一切，但没有数字却什么都不能说明。",
                "数字记录的是过去，分析憧憬的是未来。","数字证明一切。","说实话，报实数；讲实情，求实效","统筹过去，计划将来。","统计不是简单的一加一等于二，而是过去加现在和未来。",
                "统计使人明事，统计使人明理。","以数字为依据，以真实为准绳。","用科学的方法来统计，用真实的数据来说话。","用数字串起经济社会发展的乐章。","用数字记录历史，用诚信经营人生量和质。",
                "用数字记录历史，用分析反映社会。","用数字说话，让社会倾听到经济发展的阴晴变化；为决策服务，助政府调控出和谐社会的宏观手法。","真实地记录过去，准确地分析现在，合理地规划未来。",
                "作风要朴实，工作要扎实，任务要落实，数字要真实。"]; echo $minyan[rand(0, count($minyan)-1)];?><br/>—— <?php echo date('Y-m-d H:i:s');?></p>
        </div>
    </div>
</div>