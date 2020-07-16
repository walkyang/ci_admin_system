 $(function(){

	 $("body").on("click", ".compare", function () {
          $.each($(".checkItem"), function (i, n) {
              if ($(n).prop("checked")) {
                  $(n).parents("tr").show();
              } else {
                  $(n).parents("tr").hide();
              }
          });
      });
     $("body").on("click", ".showAll", function () {
          if ($("#havaBuildingsIds").val() == "")
          {
              $.each($(".checkItem"), function (i, n) {
                  $(n).parents("tr").show();
              });
          } else {
              $(".btn-search").click();
          }
      });

	 $(".dropdown-menu").on("click" ,'a', function () {
          	$('#orderby').val($(this).attr('value'));
          	$('#formquery').submit();
      });

  	 $('.PDetails').on('click', function(){
	    layer.open({
	        type: 2,
	        title: '详情',
	        maxmin: true,
	        shadeClose: true, //点击遮罩关闭层
	        area : ['800px' , '620px'],
	        content: '/deal/query/house-info?house_id='+this.dataset.houseid+'&searchparams='+$('#hidSearchParams').val()
	    });

  	});

  	 $('.PDetails2').on('click', function(){
	    layer.open({
	        type: 2,
	        title: '详情',
	        maxmin: true,
	        shadeClose: true, //点击遮罩关闭层
	        area : ['800px' , '620px'],
	        content: '/deal2/query/house-info?house_id='+this.dataset.houseid+'&searchparams='+$('#hidSearchParams').val()
	    });

  	});

	 $('.PDetails3').on('click', function(){
		 layer.open({
			 type: 2,
			 title: '成交详情',
			 maxmin: true,
			 shadeClose: true, //点击遮罩关闭层
			 area : ['800px' , '620px'],
			 content: '/deal2/info?house_id='+this.dataset.houseid+'&searchparams='+$('#hidSearchParams').val()
		 });

	 });

	 //弹出面积段设置
  	 $('#setting').on('click', function(){
  	 	    layer.open({
  	 	        type: 2,
  	 	        title: '自定义分组设置',
  	 	        maxmin: true,
  	 	        shadeClose: true, //点击遮罩关闭层
  	 	        area : ['400px' , '300px'],
  	 	        content: '/user/info/setting'
  	 	    });
  	 	});



 })


