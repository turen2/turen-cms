//注意与其它js文件变量冲突
var backend_mail_content = $('#backend-mail-echarts-pie-chart');
var backend_mail_fresh_button = backend_mail_content.parent().prev().find('.fresh-link');

backend_mail_fresh_button.on('click', function() {
	$.ajax({
		type: "POST",
		dataType: 'json',
		context: $(this),
		url: backend_mail_content.parent().attr('data-url'),
		data: {},
		success: function(data){
			if(data.state) {
				var pieChart = echarts.init(backend_mail_content[0]);
				var pieoption = {
				    title : {
				        text: '后台邮件队列监测',
				        subtext: '实时数据',
				        x:'center'
				    },
				    tooltip : {
				        trigger: 'item',
				        formatter: "{a} <br/>{b} : {c} ({d}%)"
				    },
				    legend: {
				        orient : 'vertical',
				        x : 'left',
				        data:['等待发送','正在发送','已经发送','邮件滞留']
				    },
				    calculable : true,
				    series : [
				        {
				            name:'邮件发送详情',
				            type:'pie',
				            radius : '55%',//放大比例
				            center: ['50%', '60%'],//位置
				            data: data.msg
				        }
				    ]
				};
				pieChart.setOption(pieoption);
				$(window).resize(pieChart.resize);
			} else {
				//nothing
			}
		}
	});
});

backend_mail_fresh_button.click();//首次模拟触发
