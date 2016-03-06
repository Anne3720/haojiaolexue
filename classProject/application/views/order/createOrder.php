<?php include('/../header.php');?>
<style type="text/css">
*{
	margin:0;
	padding:0;
}
ul,ol{
	list-style:none;
}
.container,.order, .submit, .order02{
	width: 1190px;	
    overflow: hidden;
    margin:20px auto;
    position: relative;   
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
.order01 img{
    width: 120px;
    position: absolute;
    top: 20px;
    left: 70px;
}
.order01,.order02 {
    margin: 20px 0;     
}
.order01 {
    background: #FCFCFC;
}
.order01 p, .order02 p {
    display: block;
    width: 900px;
    margin-left:200px; 
    padding: 10px 10px 20px;
    position: relative;
    overflow: hidden;
}

.order01 p span {
    font-size: 22px;
    font-weight: bold;
    display: inline-block;
    margin: 10px 100px 10px 0;
}
.ordername {
    border-bottom:1px solid #EAEAEA; 
}
.order02 p {
    height: 60px;
    line-height: 60px;
}
.order02pay1 {
    margin-bottom:-6px;
}
.order02pay2 {
    margin-bottom:-20px;
    margin-left: 10px;
}
p.order02p {
    padding-left: 50px;
}
.submit dd {
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
.submit span button{
    display: inline-block;
    float: right;
    padding: 15px;
    background: #ff0000;
    width: 150px;
    text-align: center;
    font-size: 24px; 
    color: #fff;   
}
 i {
    font-family: 'Microsoft YaHei';
    font-size: 20px;
    color: #f00;
}
.submit .content dt, .null-star {
    display: none;
}
</style>


<div class="container">
	<span class="on">1、填写并确认订单信息</span>
	<span>2、成功提交订单</span>
</div> 
<div class="order">
    <div class="order01">
        <img src="/../../../public/img/duihao.png" alt="">
        <p>
            <span>订单提交成功，请您尽快付款！ 订单号：<?php echo ($orderInfo['OrderNo']);?></span>
            <b style="font-weight: unset;">应付金额：</b><i><?php echo "&yen; "; echo ($orderInfo['Price']);?></i>
        </p>
        
        <p class="ordername">请您在提交订单后24小时内完成支付，否则订单会自动取消。</p>
        <p>课程名称：<?php echo ($Name);?></p>
    </div>  
    <div class="order02">
    	<p>
           <img class="order02pay1" src="/../../../public/img/duihao1.png" alt="">
           支付平台：推荐使用支付宝支付。支持所有银行卡和支付宝，无需开通网银。
        </p>
        <p class="order02p">
            <input type="radio" checked="checked" value="alipay" autocomplete="off">
            <img class="order02pay2" src="/../../../public/img/alipay.png" alt="">
        </p>
        
    </div>
    
</div>
<div class="submit">   
    <form name=alipayment action=/alipay/alipayapi.php method=post target="_blank">
                <dl class="content">
                    <dd class="null-star">
                        <input size="30" name="WIDout_trade_no" value="<?php echo ($orderInfo['OrderNo']);?>" />
                    </dd>
                    <dd class="null-star">
                        <input size="30" name="WIDsubject" value="<?php echo ($classInfo['Name']);?>" />
                    </dd>
                    <dd class="null-star">
                        <input size="30" name="WIDtotal_fee" value="<?php echo ($orderInfo['Price']);?>" />
                    </dd>
                    <dd class="null-star">
                        <input size="30" name="WIDbody" value="<?php echo ($classInfo['Desc']);?>" />
                        <span></span>
                    </dd>
                    <dd class="null-star">
                        <input size="30" name="WIDshow_url" value='<?php echo "http://www.haojiaolexue.com/classes/classlist?grade=";?> <?php echo ($classInfo['Grade']);?><?php echo "&subject=";?><?php echo ($classInfo['SubjectID']);?>'/>
                    </dd>
                    <dt></dt>
                    <dd class="submit">
                        <p>还需支付：<i><?php echo "&yen; "; echo ($orderInfo['Price']);?></i></p>
                        <span >
                            <button type="submit" >确认支付</button>
                        </span>
                    </dd>
                </dl>
    </form>
</div> 