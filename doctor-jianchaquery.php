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
					$doctorID=(int)$_POST['doctorID'];
					$cfID=$_POST['cfID'];
					$jcID=$_POST['jcID'];
					$jcName=$_POST['jcName'];
					$sql="select d_name from DOCTOR where d_no=$doctorID";
					$result=$mysqli->query($sql);
					if($result&&$result->num_rows>0)
						{
						$row = $result -> fetch_assoc();
						$doctorName=$row['d_name'];
						echo "<h2>医生 $doctorName ，请安排一项检查！</h2>";
						echo "</blockquote><blockquote class=\"layui-elem-quote\">";
						$sql="select form_no from FORMULATION where form_no=$cfID and d_no=$doctorID";
						$result=$mysqli->query($sql);
						if($result&&$result->num_rows>0)
							{
							if($jcID==""&&$jcName=="")
								echo "<h2>检查项目ID和项目名称请至少填写一项！</h2>";
							else
								{
								$sql="select exm_no from EXM_ITEM where 1=1";
								if($jcID!="")$sql.=" and exm_no=$jcID";
								if($jcName!="")$sql.=" and exm_name=\"$jcName\"";
								$result=$mysqli->query($sql);
								if($result&&$result->num_rows>0)
									{
									$row = $result -> fetch_assoc();
									$jcID=$row['exm_no'];
									$sql="select exm_sheet_no,exm_no from EXAMINATION_SHEET where exm_sheet_no=$cfID and exm_no=$jcID";
									$result=$mysqli->query($sql);
									if($result&&$result->num_rows>0)
										echo "<h2>该处方单已安排过此项检查，请重新输入！</h2>";
									else
										{
										$sql="insert EXAMINATION_SHEET values($cfID,$jcID,\"尚未进行检查\")";
										if($mysqli->query($sql)==FALSE)
											echo "<h2>数据有误，未能成功安排检查，请重新安排</h2>";
										else
											echo "<h2>安排检查成功！</h2>";
										}									
									}
								else
									echo "<h2>不存在这项检查，请重新输入！</h2>";
								}
							}
						else
							echo "<h2>不存在该处方单或您无权对该处方单安排检查！</h2>";
						}
					else
						echo "<script>sessionStorage.isLogin=0;</script>";
				?>
			<script>document.write("<a href=\"doctor-jiancha.php?userID="+sessionStorage.userID+"\" class=\"layui-btn\">返回</a>");</script>
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
