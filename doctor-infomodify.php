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
					$doctorName=$_POST['doctorName'];
					$doctorGender=$_POST['doctorGender'];
					$depID=$_POST['depID'];
					$doctorTitle=$_POST['doctorTitle'];
					$doctorBirthday=$_POST['doctorBirthday'];
					echo "<h2>医生 $doctorName ，请确认您的个人信息修改！</h2>
					</blockquote>
					<blockquote class=\"layui-elem-quote\">";
					$sql="update DOCTOR set d_name=\"$doctorName\", d_gender=\"$doctorGender\", dep_no=$depID, d_title=\"$doctorTitle\", d_birth_date=\"$doctorBirthday\" where d_no=$doctorID";
					//echo $sql;
					if($mysqli->query($sql)==FALSE)
						echo "<h2>数据有误，未能成功更新个人信息，请重新输入！</h2>";
					else
						{
						echo "<h2>成功更新个人信息，更新后个人信息如下：</h2>";
						echo "<script>var flag=true;</script>
							<table lay-filter=\"resultTable\">
								<thead>
									<tr>
										<th lay-data=\"{field:'doctorID'}\">医生ID</th>
										<th lay-data=\"{field:'doctorName'}\">姓名</th>
										<th lay-data=\"{field:'doctorGender'}\">性别</th>
										<th lay-data=\"{field:'doctorTitle'}\">职称</th>
										<th lay-data=\"{field:'depName'}\">科室</th>
										<th lay-data=\"{field:'doctorAge'}\">出生日期</th>
									</tr> 
								</thead>
								<tbody>
								";
						$newsql="select d_name,d_gender,d_title,dep_name,d_birth_date from DOCTOR a, DEPARTMENT b where d_no=$doctorID and a.dep_no=b.dep_no";
						$result=$mysqli->query($newsql);
						if($result&&$result->num_rows>0)
							{
							$row = $result -> fetch_assoc();
							$d_name=$row['d_name'];
							$d_gender=$row['d_gender']=="male"?"男":"女";
							$d_title=$row['d_title'];
							$dep_name=$row['dep_name'];
							$d_birth_date=$row['d_birth_date'];
							echo "<tr><td>$doctorID</td><td>$d_name</td><td>$d_gender</td><td>$d_title</td><td>$dep_name</td><td>$d_birth_date</td></tr>";
							}
						else
							echo "<tr>一些意料之外的错误发生了！！！</tr>";
						echo "</tbody></table>";
						}
				?>
			<script>document.write("<a href=\"doctor-infochg.php?userID="+sessionStorage.userID+"\" class=\"layui-btn\">返回</a>");</script>
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
	
	if(flag){
		layui.use('table', function(){
		var table = layui.table;

		table.init('resultTable',{
		height: 80
		,page: false
		});
		});
	}
</script>
</body>
</html>
