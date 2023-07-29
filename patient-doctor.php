<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>就医系统-患者界面</title>
    <link rel="stylesheet" href="./static/common/layui/css/layui.css">
    <link rel="stylesheet" href="./static/patient/css/style.css">
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
					$patientID=(int)$_GET['userID'];
					$sql="select p_name from PATIENT where p_no=$patientID";
					$result=$mysqli->query($sql);
					if($result&&$result->num_rows>0)
						{
						$row = $result -> fetch_assoc();
						$patientName=$row['p_name'];
						echo "<h2>患者 $patientName ，请查询医生信息！</h2>";
						echo "</blockquote><blockquote class=\"layui-elem-quote\">
						<form class=\"layui-form\" name=\"inputForm\" method=\"post\" action=\"patient-doctorquery.php\">
							<div class=\"layui-form-item\">
								<label class=\"layui-form-label\">医生ID</label>
								<div class=\"layui-input-inline\">
									<input type=\"text\" name=\"doctorID\" lay-verify=\"number\" placeholder=\"请输入查询医生的ID\" autocomplete=\"off\" class=\"layui-input\" />
								</div>
								<label class=\"layui-form-label\">医生姓名</label>
								<div class=\"layui-input-inline\">
									<input type=\"text\" name=\"doctorName\" placeholder=\"请输入查询医生的姓名\" autocomplete=\"off\" class=\"layui-input\" />
								</div>
							</div>";
						echo "<div class=\"layui-form-item\">
								<label class=\"layui-form-label\">所属科室</label>
								<div class=\"layui-input-block\">
									<select name=\"doctorDep\">
										<option value=\"\" selected>请选择查询医生的科室</option>";
						$sql="select * from DEPARTMENT";
						$result=$mysqli->query($sql);
						if($result)
							while($row = $result -> fetch_assoc())
								{
								$dep_no=$row['dep_no'];
								$dep_name=$row['dep_name'];
								echo "<option value=\"$dep_no\">$dep_name</option>";
								}
						echo "</select>
							</div>
							</div>";
						echo "<input type=\"text\" name=\"patientID\" style=\"display:none;\" value=\"$patientID\" />";
						echo "<div class=\"layui-form-item\">
								<div class=\"layui-input-block\">
									<button class=\"layui-btn\" lay-submit>确认查询</button>
									<button type=\"reset\" class=\"layui-btn layui-btn-primary\">重置</button>
								</div>
							</div>
						</form>";
						}
					else
						echo "<script>sessionStorage.isLogin=0;</script>";
				?>
            </blockquote>
        </div>
    </div>
</div>
<script src="./static/patient/js/config.js"></script>
<script src="./static/patient/js/script.js"></script>
<script type="text/javascript">
    //模拟登录状态
    if(sessionStorage.isLogin!=1){
        window.location.href = 'patient-login.html';
    }
	
	layui.use('layer', function(){
	var layer = layui.layer;
	layer.open({
	title: '提示'
	,content: '请填写查询医生的ID或名称，默认查询全部符合条件的医生。'
	,shadeClose: true
	,time: 5000
	});    
	}); 
</script>
</body>
</html>
