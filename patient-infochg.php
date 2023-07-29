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
					$sql="select * from PATIENT where p_no=$patientID";
					$result=$mysqli->query($sql);
					if($result&&$result->num_rows>0)
						{
						$row = $result -> fetch_assoc();
						$patientName=$row['p_name'];
						$patientGender=$row['p_gender'];
						$patientBirthday=$row['p_birth_date'];
						$patientTel=$row['p_tel'];
						echo "<h2>患者 $patientName ，请修改您的个人信息！</h2>";
						echo "</blockquote><blockquote class=\"layui-elem-quote\">";
						echo "<form class=\"layui-form layui-form-pane\" name=\"inputForm\" method=\"post\" action=\"patient-infomodify.php\">";
						echo "<div class=\"layui-form-item\" pane>";
						echo "<label class=\"layui-form-label\">患者ID</label>
							<div class=\"layui-input-block\">
								<input type=\"text\" name=\"patientID\" required lay-verify=\"required\" placeholder=\"请输入患者ID\" autocomplete=\"off\" class=\"layui-input\" readonly value=\"$patientID\" />
							</div>";
						echo "</div>";
						echo "<div class=\"layui-form-item\" pane>";
						echo "<label class=\"layui-form-label\">姓名</label>
							<div class=\"layui-input-block\">
								<input type=\"text\" name=\"patientName\" required lay-verify=\"required\" placeholder=\"请输入姓名\" autocomplete=\"off\" class=\"layui-input\" value=\"$patientName\" />
							</div>";
						echo "</div>";
						echo "<div class=\"layui-form-item\" pane>";
						echo "<label class=\"layui-form-label\">性别</label>
							<div class=\"layui-input-block\">
								<input type=\"radio\" name=\"patientGender\" value=\"male\" title=\"男\"";
						if($patientGender=="male")echo " checked";
						echo "/>
								<input type=\"radio\" name=\"patientGender\" value=\"female\" title=\"女\"";
						if($patientGender=="female")echo " checked";
						echo "/>
							</div>";
						echo "</div>";
						echo "<div class=\"layui-form-item\" pane>";
						echo "<label class=\"layui-form-label\">出生日期</label>
							<div class=\"layui-input-block\">
								<input type=\"text\" class=\"layui-input\" name=\"patientBirthday\" id=\"patientBirthday\" required lay-verify=\"date\" placeholder=\"请选择出生日期\" autocomplete=\"off\" value=\"$patientBirthday\" />
							</div>";
						echo "</div>";
						echo "<div class=\"layui-form-item\" pane>";
						echo "<label class=\"layui-form-label\">联系电话</label>
							<div class=\"layui-input-block\">
								<input type=\"text\" name=\"patientTel\" required lay-verify=\"phone\" placeholder=\"请输入联系电话\" autocomplete=\"off\" class=\"layui-input\" value=\"$patientTel\" />
							</div>";
						echo "</div>";
						echo "<div class=\"layui-form-item\">
								<div class=\"layui-input-block\">
									<button class=\"layui-btn\" lay-submit>确认修改</button>
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
<script src="./static/patient/js/config.js"></script>
<script src="./static/patient/js/script.js"></script>
<script type="text/javascript">
    //模拟登录状态
    if(sessionStorage.isLogin!=1){
        window.location.href = 'patient-login.html';
    }
	
	layui.use('laydate', function(){
	  var laydate = layui.laydate;
	  
	  laydate.render({
		elem: '#patientBirthday'
	  });
	});
</script>
</body>
</html>
