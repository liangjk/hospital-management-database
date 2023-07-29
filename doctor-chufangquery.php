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
					$doctorID=(int)$_GET['doctorID'];
					$regID=$_GET['regID'];
					$sql="select d_name from DOCTOR where d_no=$doctorID";
					$result=$mysqli->query($sql);
					if($result&&$result->num_rows>0)
						{
						$row = $result -> fetch_assoc();
						$doctorName=$row['d_name'];
						echo "<h2>医生 $doctorName ，请开具一个处方单！</h2>";
						echo "</blockquote><blockquote class=\"layui-elem-quote\">";
						$sql="select a.p_no p_no,p_name from REGISTER a,PATIENT b where reg_no=$regID and d_no=$doctorID and a.p_no=b.p_no";
						$result=$mysqli->query($sql);
						if($result&&$result->num_rows>0)
							{
							$row = $result -> fetch_assoc();
							$p_no=$row['p_no'];
							$p_name=$row['p_name'];
							$sql="select form_no from FORMULATION where form_no=$regID";
							$result=$mysqli->query($sql);
							if($result&&$result->num_rows>0)
								echo "<h2>该挂号单已开具过处方单！<a href=\"doctor-binglicontent.php?doctorID=$doctorID&formID=$regID\">点击查看</a></h2>";
							else
								{
								echo "<form class=\"layui-form layui-form-pane\" name=\"inputForm\" method=\"post\" action=\"doctor-chufanginsert.php\">";
								echo "<div class=\"layui-form-item\" pane>";
								echo "<label class=\"layui-form-label\">挂号单ID</label>
									<div class=\"layui-input-block\">
										<input type=\"text\" name=\"regID\" required lay-verify=\"required\" placeholder=\"请输入挂号单ID\" autocomplete=\"off\" class=\"layui-input\" readonly value=\"$regID\" />
									</div>";
								echo "</div>";
								echo "<div class=\"layui-form-item\" pane>";
								echo "<label class=\"layui-form-label\">医生ID</label>
									<div class=\"layui-input-block\">
										<input type=\"text\" name=\"doctorID\" required lay-verify=\"required\" placeholder=\"请输入医生ID\" autocomplete=\"off\" class=\"layui-input\" readonly value=\"$doctorID\" />
									</div>";
								echo "</div>";
								echo "<div class=\"layui-form-item\" pane>";
								echo "<label class=\"layui-form-label\">患者ID</label>
									<div class=\"layui-input-block\">
										<input type=\"text\" name=\"patientID\" required lay-verify=\"required\" placeholder=\"请输入患者ID\" autocomplete=\"off\" class=\"layui-input\" readonly value=\"$p_no\" />
									</div>";
								echo "</div>";
								echo "<div class=\"layui-form-item\" pane>";
								echo "<label class=\"layui-form-label\">患者姓名</label>
									<div class=\"layui-input-block\">
										<input type=\"text\" name=\"patientName\" placeholder=\"请输入患者姓名\" autocomplete=\"off\" class=\"layui-input\" disabled value=\"$p_name\" />
									</div>";
								echo "</div>";
								echo "<div class=\"layui-form-item\" pane>";
								echo "<label class=\"layui-form-label\">处置方案</label>
									<div class=\"layui-input-block\">
										<textarea name=\"formContent\" required lay-verify=\"required\" placeholder=\"请输入建议处置方案\" class=\"layui-textarea\"></textarea>
									</div>";
								echo "</div>";
								echo "<div class=\"layui-form-item\">
								<div class=\"layui-input-block\">
									<button class=\"layui-btn\" lay-submit>确认开具</button>
									<button type=\"reset\" class=\"layui-btn layui-btn-primary\">重置</button>
								</div>
							</div>";
								echo "</form>";
								}
							}
						else
							echo "<h2>不存在该挂号单或您无权开具该处方单，请重新输入！</h2>";
						}
					else
						echo "<script>sessionStorage.isLogin=0;</script>";
				?>
			<script>document.write("<a href=\"doctor-chufang.php?userID="+sessionStorage.userID+"\" class=\"layui-btn\">返回</a>");</script>
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
</script>
</body>
</html>
