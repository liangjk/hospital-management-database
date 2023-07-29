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
					$patientID=$_POST['patientID'];
					$sql="select d_name from DOCTOR where d_no=$doctorID";
					$result=$mysqli->query($sql);
					if($result&&$result->num_rows>0)
						{
						$row = $result -> fetch_assoc();
						$doctorName=$row['d_name'];
						echo "<h2>医生 $doctorName ，请查询患者信息！</h2>";
						echo "</blockquote><blockquote class=\"layui-elem-quote\">";
						$sql="select distinct a.p_no p_id,a.p_name p_name,p_gender,TIMESTAMPDIFF(YEAR, p_birth_date, NOW()) p_age,p_tel from PATIENT a,REGISTER b where a.p_no=b.p_no and b.d_no=$doctorID";
						if($patientID!="")$sql.=" and b.p_no=$patientID";
						//echo $sql;
						$result=$mysqli->query($sql);
						if($result&&$result->num_rows>0)
							{
							echo "<table lay-filter=\"resultTable\">
								<thead>
									<tr>
										<th lay-data=\"{field:'patientID',sort:true}\">患者ID</th>
										<th lay-data=\"{field:'patientName'}\">患者姓名</th>
										<th lay-data=\"{field:'patientGender',sort:true}\">患者性别</th>
										<th lay-data=\"{field:'patientAge',sort:true}\">患者年龄</th>
										<th lay-data=\"{field:'patientTel'}\">患者联系方式</th>
										<th lay-data=\"{field:'option'}\">操作</th>
									</tr> 
								</thead>
								<tbody>
								";
							while($row = $result -> fetch_assoc())
								{
								$p_id=$row['p_id'];
								$p_name=$row['p_name'];
								$p_gender=$row['p_gender']=="male"?"男":"女";
								$p_age=$row['p_age'];
								$p_tel=$row['p_tel'];
								echo "<tr><td>$p_id</td><td>$p_name</td><td>$p_gender</td><td>$p_age</td><td>$p_tel</td><td><a href=\"doctor-bingliquery?doctorID=$doctorID&patientID=$p_id\" class=\"layui-btn layui-btn-normal layui-btn-sm\">查看病历</a></td></tr>";
								}
							echo "</tbody></table>";
							}
						else
							echo "<h2>没有符合条件的与您相关的患者，请重新输入！</h2>";
						}
					else
						echo "<script>sessionStorage.isLogin=0;</script>";
				?>
			<script>document.write("<a href=\"doctor-patient.php?userID="+sessionStorage.userID+"\" class=\"layui-btn\">返回</a>");</script>
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
	
	layui.use('table', function(){
	var table = layui.table;

	table.init('resultTable',{
	height: 500
	,limit:10
	,page: true
	,initSort: {
		field: 'patientID'
		,type: 'asc'
		}
	});
	});
</script>
</body>
</html>
