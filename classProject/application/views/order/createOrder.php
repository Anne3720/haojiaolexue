<?php include('/../header.php');?>
<style type="text/css">


*{
	margin:0;
	padding:0;
}
ul,ol{
	list-style:none;
}
.container {
	width: 1190px;
	height: 50px;
    overflow: hidden;
    margin:20px auto; 
    background: #D8EFF8;
}
.container span {
	display: inline-block;
	width: 45%;
	padding: 10px;
	font-size:18px;
	line-height: 30px;
	text-align: center;
}
.on {
	background: #3BAFDA;
}
</style>


<div class="container">
	<span>1、填写并确认订单信息</span>
	<span class="on">2、成功提交订单</span>
</div> 
<div>
    <div>
        <img src="/../../../public/img/duihao.png" alt="">
        <span>订单提交成功，请您尽快付款！ 订单号：</span>
        <span style="font-family: 'Microsoft YaHei';">应付金额：<?php echo "&yen; "; echo ($Price);?></span>
        <p>请您在提交订单后24小时内完成支付，否则订单会自动取消。</p>
        <p>课程名称：<?php echo ($Name);?></p>
    </div>  
    <div>
    	<img src="/../../../public/img/duihao1.png" alt="">支付平台：推荐使用支付宝支付。支持所有银行卡和支付宝，无需开通网银。
    </div>
    <div>
        <input type="radio" checked="checked" value="alipay" autocomplete="off">
    	<img src="/../../../public/img/alipay.png" alt="">
    </div>
    <div>
        <span>还需支付：<?php echo "&yen; "; echo ($Price);?></span>
    	<a href="">确认支付</a>
    </div>
    
</div>