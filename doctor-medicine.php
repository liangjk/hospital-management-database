<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>就医系统-医生界面</title>
    <link rel="stylesheet" href="./static/common/layui/css/layui.css">
    <link rel="stylesheet" href="./static/doctor/css/style.css">
    <script src="./static/common/layui/layui.js"></script>
    <script src="./static/common/jquery-3.3.1.min.js"></script>
    <script src="./static/common/vue.min.js"></script>
    <style>
        .right h2{
            margin: 10px 0;
        }
        .right li{
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div id="app">
    <!--顶栏-->
    <header>
        <h1 v-text="webname"></h1>
    </header>

    <div class="main" id="app">
        <!--左栏-->
        <div class="left">
            <ul class="cl" >
                <!--顶级分类-->
                <li v-for="vo,index in menu" :class="{hidden:vo.hidden}">
                    <a href="javascript:;" :class="{active:vo.active}" @click="onActive(index)">
                        <i class="layui-icon" v-html="vo.icon"></i>
                        <span v-text="vo.name"></span>
                        <i class="layui-icon arrow" v-show="vo.url.length==0">&#xe61a;</i> <i v-show="vo.active" class="layui-icon active">&#xe623;</i>
                    </a>
                    <!--子级分类-->
                    <div v-for="vo2,index2 in vo.list">
                        <a href="javascript:;" :class="{active:vo2.active}" @click="onActive(index,index2)" v-text="vo2.name"></a>
                        <i v-show="vo2.active" class="layui-icon active">&#xe623;</i>
                    </div>
                </li>
            </ul>
        </div>
        <!--右侧-->
        <div class="right">
			<blockquote class="layui-elem-quote">
				<?php
					$mysqli=new mysqli("localhost","root","root","hospital_505");
					$doctorID=(int)$_GET['userID'];
					$sql="select d_name from DOCTOR where d_no=$doctorID";
					$result=$mysqli->query($sql);
					if($result&&$result->num_rows>0)
						{
						$row = $result -> fetch_assoc();
						$doctorName=$row['d_name'];
						echo "<h2>医生 $doctorName ，请开具药品！</h2>";
						echo "</blockquote><blockquote class=\"layui-elem-quote\">";
						echo "<form class=\"layui-form\" name=\"inputForm\" method=\"post\" action=\"doctor-medicinequery.php\">";
						echo "<div class=\"layui-form-item\">
								<label class=\"layui-form-label\">处方单ID</label>
								<div class=\"layui-input-block\">
									<input type=\"text\" class=\"layui-input\" name=\"cfID\" required lay-verify=\"required\" placeholder=\"请输入开具药品的处方单ID\" autocomplete=\"off\" />
								</div>
							</div>";
						echo "<div class=\"layui-form-item\">
								<label class=\"layui-form-label\">药品ID</label>
								<div class=\"layui-input-inline\">
									<input type=\"text\" class=\"layui-input\" name=\"medicineID\" placeholder=\"请输入开具的药品ID\" autocomplete=\"off\" />
								</div>
								<label class=\"layui-form-label\">药品名称</label>
								<div class=\"layui-input-inline\">
									<input type=\"text\" class=\"layui-input\" name=\"medicineName\" placeholder=\"请输入开具的药品名称\" autocomplete=\"off\" />
								</div>
							</div>";
						echo "<div class=\"layui-form-item\">
								<label class=\"layui-form-label\">药品数量</label>
								<div class=\"layui-input-block\">
									<input type=\"text\" class=\"layui-input\" name=\"medicineQuantity\" required lay-verify=\"required\" placeholder=\"请输入开具药品的数量\" autocomplete=\"off\" />
								</div>
							</div>";
						echo "<input type=\"text\" name=\"doctorID\" value=\"$doctorID\" style=\"display:none;\" />";
						echo "<div class=\"layui-form-item\">
								<div class=\"layui-input-block\">
									<button class=\"layui-btn\" lay-submit>确认开具</button>
									<button type=\"reset\" class=\"layui-btn layui-btn-primary\">重置</button>
								</div>
							</div>";
						echo "</form>";
						}
					else
						echo "<script>sessionStorage.isLogin=0;</script>";
				?>
            </blockquote>
        </div>
    </div>
</div>
<script src="./static/doctor/js/config.js"></script>
<script src="./static/doctor/js/script.js"></script>
<script type="text/javascript">
    //模拟登录状态
    if(sessionStorage.isLogin!=2){
        window.location.href = 'doctor-login.html';
    } 
	
	layui.use('layer', function(){
	var layer = layui.layer;
	layer.open({
	title: '提示'
	,content: '药品的ID和名称填写其一即可。'
	,shadeClose: true
	,time: 5000
	});    
	});   
</script>
</body>
</html>
