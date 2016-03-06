<?php include('/../header.php');?>
<style type="text/css">


*{
	margin:0;
	padding:0;
}
ul,ol{
	list-style:none;
}
.container,.order, .submit {
	width: 1190px;
	
    overflow: hidden;
    margin:20px auto; 
    
}
.container {
    height: 50px;
    background: #3BAFDA;
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
	background: #D8EFF8;
}
.order {

}
.submit {
    border: 2px solid #EAEAEA;
    background: #FCFCFC;
    position: relative;
    text-align: right;
}
.submit p {
    display: inline-block;
    width: 700px;
    padding: 15px;
    margin-right: 50px;
}
.submit span {
    display: inline-block;
    float: right;
    padding: 15px;
    background: #ff0000;
    width: 100px;
    text-align: center;
    font-size: 24px;    
}
.submit span a {
    color: #fff;
}
.submit i {
    font-family: 'Microsoft YaHei';
    font-size: 20px;
    color: #f00;
}
</style>


<div class="container">
	<span class="on">1、填写并确认订单信息</span>
	<span>2、成功提交订单</span>
</div> 
<div class="order">
    <div class="">
        <img src="/../../../public/img/duihao.png" alt="">
        <span>订单提交成功，请您尽快付款！ 订单号：<?php echo ($orderInfo['OrderNo']);?></span>
        <span style="font-family: 'Microsoft YaHei';">应付金额：<?php echo "&yen; "; echo ($orderInfo['Price']);?></span>
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
    
</div>
<div class="submit">
    <p>还需支付：<i><?php echo "&yen; "; echo ($orderInfo['Price']);?></i>
    </p>
    <span><a href="/order/createOrder">确认支付</a></span>

</div> 


