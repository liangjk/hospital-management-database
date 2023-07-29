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
				document.write("<h2>管理员 "+sessionStorage.userID+" ，请安排病房！</h2>");
				</script>
            </blockquote>
			<blockquote class="layui-elem-quote">
				<?php
				$mysqli=new mysqli("localhost","root","root","hospital_505");
				$patientID=$_POST['patientID'];
				$roomID=$_POST['roomID'];
				$beginTime=$_POST['beginTime'];
				$endTime=$_POST['endTime'];
				$sql="select * from PATIENT where p_no=$patientID";
				$result=$mysqli->query($sql);
				if($result&&$result->num_rows>0)
					{
					$sql="select ward_cap from WARD where ward_no=$roomID";
					$result=$mysqli->query($sql);
					if($result&&$result->num_rows>0)
						{
						$row = $result -> fetch_assoc();
						$total_cap=(int)$row["ward_cap"];
						$flag=0;
						date_default_timezone_set('Asia/Shanghai');
						for($date=strtotime($beginTime);$flag==0&&$date<=strtotime($endTime);$date+=86400)
							{
							$sql="select count(*) num from HOSPITALIZATION where ward_no=$roomID and UNIX_TIMESTAMP(hos_indate) <= $date and UNIX_TIMESTAMP(hos_outdate) >=$date";
							//echo $sql;
							$result=$mysqli->query($sql);
							if($result&&$result->num_rows>0)
								{
								$row = $result -> fetch_assoc();
								$cur_cap=(int)$row["num"];
								if($cur_cap>=$total_cap)$flag=1;
								}
							else
								$flag=-1;
							}
						for($date=strtotime($beginTime);$flag==0&&$date<=strtotime($endTime);$date+=86400)
							{
							$sql="select * from HOSPITALIZATION where p_no=$patientID and UNIX_TIMESTAMP(hos_indate) <= $date and UNIX_TIMESTAMP(hos_outdate) >=$date";
							$result=$mysqli->query($sql);
							if($result&&$result->num_rows>0)
								$flag=2;
							}
						if($flag==0)
							{
							$sql="insert into HOSPITALIZATION(p_no,ward_no,hos_indate,hos_outdate) values($patientID,$roomID,\"$beginTime\",\"$endTime\")";
							if($mysqli->query($sql)==FALSE)
								echo "<h2>数据有误，未能安排病房，请重新输入！</h2>";
							else
								echo "<h2>安排病房成功！</h2>";
							}
						else if($flag==1)
							echo "<h2>该时间段内此病房无法安排新病人，请重新输入！</h2>";
						else if($flag==2)
							echo "<h2>该时间段内此病人已安排病房，请重新输入！</h2>";
						else
							echo "<h2>发生了一些错误，请重新输入！</h2>";
						}
					else
						echo "<h2>没有该病房，请重新输入！</h2>";
					}
				else
					echo "<h2>没有该病人，请重新输入！</h2>";					
				?>
			<a href="admin-arrangeroom.html" class="layui-btn">返回</a>
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
