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
					$sql="select p_name,p_gender,TIMESTAMPDIFF(YEAR, p_birth_date, NOW()) p_age,p_tel from PATIENT where p_no=$patientID";
					$result=$mysqli->query($sql);
					if($result&&$result->num_rows>0)
						{
						$row = $result -> fetch_assoc();
						$patientName=$row['p_name'];
						echo "<h2>患者 $patientName ，请确认您的个人信息！</h2>";
						echo "</blockquote><blockquote class=\"layui-elem-quote\"><script>var flag=true;</script>";
						echo "<table lay-filter=\"resultTable\">
								<thead>
									<tr>
										<th lay-data=\"{field:'patientID'}\">患者ID</th>
										<th lay-data=\"{field:'patientName'}\">姓名</th>
										<th lay-data=\"{field:'patientGender'}\">性别</th>
										<th lay-data=\"{field:'patientAge'}\">年龄</th>
										<th lay-data=\"{field:'patientTel'}\">联系电话</th>
									</tr> 
								</thead>
								<tbody>
								";
						$p_gender=$row['p_gender']=="male"?"男":"女";
						$p_age=$row['p_age'];
						$p_tel=$row['p_tel'];
						echo "<tr><td>$patientID</td><td>$patientName</td><td>$p_gender</td><td>$p_age</td><td>$p_tel</td></tr>";
						echo "</tbody></table>";
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
