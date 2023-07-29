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
						echo "<h2>患者 $patientName ，请查询您的手术信息！</h2>";
						echo "</blockquote><blockquote class=\"layui-elem-quote\">";
						$sql="select surg_pk,surg_sheet_no, surg_name, d_name, surg_begin_time, surg_end_time, surg_result from SURGERY_SHEET a, SURGERY_ITEM b, DOCTOR c where p_no=$patientID and a.surg_no=b.surg_no and a.phy_no=c.d_no and unix_timestamp(surg_end_time) >= unix_timestamp(\"$beginTime\") and unix_timestamp(surg_begin_time) <= unix_timestamp(\"$endTime\")";
						$result=$mysqli->query($sql);
						if($result&&$result->num_rows>0)
							{
							echo "<table lay-filter=\"resultTable\">
									<thead>
										<tr>
											<th lay-data=\"{field:'surgeryID',sort:true}\">手术ID</th>
											<th lay-data=\"{field:'blID'}\">病历单ID</th>
											<th lay-data=\"{field:'surgeryName',sort:true}\">手术项目</th>
											<th lay-data=\"{field:'doctorName',sort:true}\">主刀医生</th>
											<th lay-data=\"{field:'beginTime',sort:true}\">开始时间</th>
											<th lay-data=\"{field:'endTime'}\">结束时间</th>
											<th lay-data=\"{field:'option'}\">操作</th>
										</tr> 
									</thead>
									<tbody>";
							while($row = $result -> fetch_assoc())
								{
								$surg_pk=$row["surg_pk"];
								$surg_sheet_no=$row["surg_sheet_no"];
								$surg_name=$row["surg_name"];
								$doctorName=$row["d_name"];
								$surg_begin_time=$row["surg_begin_time"];
								$surg_end_time=$row["surg_end_time"];
								$surg_result=str_replace("\r\n","<br/>",$row["surg_result"]);
								echo "<tr><td>$surg_pk</td><td>$surg_sheet_no</td><td>$surg_name</td><td>$doctorName</td><td>$surg_begin_time</td><td>$surg_end_time</td>";
								echo "<td><button type=\"button\" class=\"layui-btn layui-btn-normal layui-btn-sm\" 
									onclick=\"
									layui.use('layer', function(){
										var layer = layui.layer;

										layer.open({
											title: '手术结果'
											,content: '$surg_result'
											,shadeClose: true
											});  
									});\"";
								echo ">查看手术结果</button></td></tr>";
								}
							echo "</tbody></table>";
							}
						else
							echo "<h2>您在此段时间内没有手术记录，请重新查询！</h2>";
						}
					else
						echo "<script>sessionStorage.isLogin=0;</script>";
				?>
			<script>document.write("<a href=\"patient-surgery.php?userID="+sessionStorage.userID+"\" class=\"layui-btn\">返回</a>");</script>
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
		field: 'surgeryID'
		,type: 'asc'
		}
	});
	});
</script>
</body>
</html>
