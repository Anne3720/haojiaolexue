<?php include('/../header.php');?> 

<style type="text/css">


*{
	margin:0;
	padding:0;
}
ul,ol{
	list-style:none;
}
.container,.wrap,h2,.submit {
	width: 1190px;
	overflow: hidden;
	margin:50px auto;
}
.container {	
	height: 50px;     
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
.wrap  {
    background: #FCFCFC;
    border: 1px solid #EAEAEA;
}
.classlist,.classlist1 {
	width: 1150px;
	position: relative;	
	margin: 20px;
	overflow: hidden;
} 
.classlist {
	border-bottom: 1px solid #EAEAEA;
}
.classlist h3 {
	float: left;
}
.classlist .price {
	float: right;
	margin-right:200px; 
	font-weight: bold;
}
.classlist1 .name {
	float: left;
	width: 700px;
}
.classlist1 span {
	float: right;
	display: inline-block;
	margin-right:200px;
	text-align: center;
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
<h2>填写并核对订单信息</h2>
<div class="wrap">
    
    <div class="classlist">
    	<h3>课程清单</h3>
        <div class="price">价格</div>
    </div>
    <div class="classlist1">
    	<div class="name">
    	    <p><?php echo ($Name);?></p>
    	    <p><?php echo ($Teacher);?></p>
    	</div>
    	<span style="font-family: 'Microsoft YaHei';"><i><?php echo "&yen; "; echo ($Price);?></i></span>
    </div>
</div>    
    
<div class="submit">
	<p>应付金额：<i><?php echo "&yen; "; echo ($Price);?></i>
    </p>
    <span><a href="/order/createOrder.php">提交订单</a></span>

</div>   
    


	