<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>就医系统-管理界面</title>
    <link rel="stylesheet" href="./static/common/layui/css/layui.css">
    <link rel="stylesheet" href="./static/admin/css/style.css">
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
                <script language="javascript" type="text/javascript">
				document.write("<h2>管理员 "+sessionStorage.userID+" ，请安排一场手术！</h2>");
				</script>
            </blockquote>
			<blockquote class="layui-elem-quote">
				<?php
				$mysqli=new mysqli("localhost","root","root","hospital_505");
				$cfID=$_POST['cfID'];
				$surgeryID=$_POST['surgeryID'];
				$doctorID=$_POST['doctorID'];
				$roomID=$_POST['roomID'];
				$beginTime=$_POST['beginTime'];
				$endTime=$_POST['endTime'];
				$sql="select p_no from FORMULATION where form_no=$cfID";
				$result=$mysqli->query($sql);
				if($result&&$result->num_rows>0)
					{
					$row = $result -> fetch_assoc();
					$patientID= $row["p_no"];
					$sql="select * from SURGERY_SHEET where phy_no=$doctorID and (surg_begin_time between \"$beginTime\" and \"$endTime\" or surg_end_time between \"$beginTime\" and \"$endTime\" or \"$beginTime\" between surg_begin_time and surg_end_time or \"$endTime\" between surg_begin_time and surg_end_time)";
					$result=$mysqli->query($sql);
					if($result&&$result->num_rows>0)
						echo "<h2>该主刀医生此时间段内已安排有手术，请重新输入！</h2>";
					else
						{
						$sql="select * from SURGERY_SHEET where room_no=$roomID and (surg_begin_time between \"$beginTime\" and \"$endTime\" or surg_end_time between \"$beginTime\" and \"$endTime\" or \"$beginTime\" between surg_begin_time and surg_end_time or \"$endTime\" between surg_begin_time and surg_end_time)";
						$result=$mysqli->query($sql);
						if($result&&$result->num_rows>0)
							echo "<h2>该手术室此时间段内已安排有手术，请重新输入！</h2>";
						else
							{
							$sql="select * from SURGERY_SHEET where p_no=$patientID and (surg_begin_time between \"$beginTime\" and \"$endTime\" or surg_end_time between \"$beginTime\" and \"$endTime\" or \"$beginTime\" between surg_begin_time and surg_end_time or \"$endTime\" between surg_begin_time and surg_end_time)";
							// echo $sql;
							$result=$mysqli->query($sql);
							if($result&&$result->num_rows>0)
								echo "<h2>该患者此时间段内已安排有手术，请重新输入！</h2>";
							else
								{
								$sql="insert into SURGERY_SHEET(surg_sheet_no,surg_no,room_no,phy_no,p_no,surg_begin_time,surg_end_time,surg_result) values($cfID,$surgeryID,$roomID,$doctorID,$patientID,\"$beginTime\",\"$endTime\",\"尚未进行手术\")";
								//echo $sql;
								if($mysqli->query($sql)==FALSE)
									echo "<h2>数据有误，未能安排手术，请重新输入！</h2>";
								else
									echo "<h2>安排手术成功！</h2>";
								}
							}
						}
					}
				else
					echo "<h2>没有该处方，请重新输入！</h2>";					
				?>
			<a href="admin-arrangesurgery.html" class="layui-btn">返回</a>
            </blockquote>
        </div>
    </div>
</div>
<script src="./static/admin/js/config.js"></script>
<script src="./static/admin/js/script.js"></script>
<script type="text/javascript">
    //模拟登录状态
    if(sessionStorage.isLogin!=3){
        window.location.href = 'admin-login.html';
    }
</script>
</body>
</html>
