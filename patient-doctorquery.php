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
					$patientID=(int)$_POST['patientID'];
					$doctorID=$_POST['doctorID'];
					$doctorName=$_POST['doctorName'];
					$doctorDep=$_POST['doctorDep'];
					$sql="select p_name from PATIENT where p_no=$patientID";
					$result=$mysqli->query($sql);
					if($result&&$result->num_rows>0)
						{
						$row = $result -> fetch_assoc();
						$patientName=$row['p_name'];
						echo "<h2>患者 $patientName ，请查询医生信息！</h2>";
						echo "</blockquote><blockquote class=\"layui-elem-quote\">";
						if($doctorID==""&&$doctorName="")
							echo "<h2>查询医生的ID和姓名请至少填写一项！</h2>";
						else
							{
							$sql="select d_no,d_name,d_gender,d_title,dep_name,TIMESTAMPDIFF(YEAR, d_birth_date, NOW()) d_age from DOCTOR a, DEPARTMENT b where a.dep_no=b.dep_no";
							if($doctorID!="")$sql.=" and d_no=$doctorID";
							if($doctorName!="")$sql.=" and d_name=\"$doctorName\"";
							if($doctorDep!="")$sql.=" and a.dep_no=$doctorDep";
							// echo $sql;
							$result=$mysqli->query($sql);
							if($result&&$result->num_rows>0)
								{
								echo "<table lay-filter=\"resultTable\">
										<thead>
											<tr>
												<th lay-data=\"{field:'doctorID',sort:true}\">医生ID</th>
												<th lay-data=\"{field:'doctorName'}\">姓名</th>
												<th lay-data=\"{field:'doctorGender',sort:true}\">性别</th>
												<th lay-data=\"{field:'doctorTitle'}\">职称</th>
												<th lay-data=\"{field:'depName',sort:true}\">科室</th>
												<th lay-data=\"{field:'doctorAge'}\">年龄</th>
											</tr> 
										</thead>
										<tbody>
										";
								while($row = $result -> fetch_assoc())
									{
									$d_no=$row['d_no'];
									$d_name=$row['d_name'];
									$d_gender=$row['d_gender']=="male"?"男":"女";
									$d_title=$row['d_title'];
									$dep_name=$row['dep_name'];
									$d_age=$row['d_age'];
									echo "<tr><td>$d_no</td><td>$d_name</td><td>$d_gender</td><td>$d_title</td><td>$dep_name</td><td>$d_age</td></tr>";
									}
								echo "</tbody></table>";
								}
							else
								echo "<h2>不存在符合条件的医生，请重新查询！</h2>";
							}
						}
					else
						echo "<script>sessionStorage.isLogin=0;</script>";
				?>
            <script>document.write("<a href=\"patient-doctor.php?userID="+sessionStorage.userID+"\" class=\"layui-btn\">返回</a>");</script>
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
	
	layui.use('table', function(){
	var table = layui.table;

	table.init('resultTable',{
	height: 500
	,limit:10
	,page: true
	,initSort: {
		field: 'doctorID'
		,type: 'asc'
		}
	});
	});
</script>
</body>
</html>
