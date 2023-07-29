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
					$beginTime=$_POST['beginTime'];
					$endTime=$_POST['endTime'];
					$sql="select p_name from PATIENT where p_no=$patientID";
					$result=$mysqli->query($sql);
					if($result&&$result->num_rows>0)
						{
						$row = $result -> fetch_assoc();
						$patientName=$row['p_name'];
						echo "<h2>患者 $patientName ，请查询您的病房信息！</h2>";
						echo "</blockquote><blockquote class=\"layui-elem-quote\">";
						$sql="select a.ward_no id, dep_name, ward_cap, hos_indate, hos_outdate from HOSPITALIZATION a, WARD b,DEPARTMENT c where p_no=$patientID and a.ward_no=b.ward_no and b.dep_no=c.dep_no and unix_timestamp(hos_outdate) >= unix_timestamp(\"$beginTime\") and unix_timestamp(hos_indate) <= unix_timestamp(\"$endTime\")";
						$result=$mysqli->query($sql);
						if($result&&$result->num_rows>0)
							{
							echo "<table lay-filter=\"resultTable\">
									<thead>
										<tr>
											<th lay-data=\"{field:'roomID',sort:true}\">病房ID</th>
											<th lay-data=\"{field:'depName',sort:true}\">所属科室</th>
											<th lay-data=\"{field:'roomCap'}\">病房容量</th>
											<th lay-data=\"{field:'beginTime',sort:true}\">开始日期</th>
											<th lay-data=\"{field:'endTime'}\">结束日期</th>
										</tr> 
									</thead>
									<tbody>";
							while($row = $result -> fetch_assoc())
								{
								$ward_no=$row["id"];
								$dep_name=$row["dep_name"];
								$ward_cap=$row["ward_cap"];
								$hos_indate=$row["hos_indate"];
								$hos_outdate=$row["hos_outdate"];
								echo "<tr><td>$ward_no</td><td>$dep_name</td><td>$ward_cap</td><td>$hos_indate</td><td>$hos_outdate</td></tr>";
								}
							echo "</tbody></table>";
							}
						else
							echo "<h2>您在此段时间内没有住院记录，请重新查询！</h2>";
						}
					else
						echo "<script>sessionStorage.isLogin=0;</script>";
				?>
			<script>document.write("<a href=\"patient-room.php?userID="+sessionStorage.userID+"\" class=\"layui-btn\">返回</a>");</script>
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
		field: 'beginTime'
		,type: 'asc'
		}
	});
	});
</script>
</body>
</html>
