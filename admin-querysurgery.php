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
				document.write("<h2>管理员 "+sessionStorage.userID+" ，请查询手术情况！</h2>");
				</script>
            </blockquote>
			<blockquote class="layui-elem-quote">
				<table lay-filter="resultTable">
					<thead>
						<tr>
							<th lay-data="{field:'surgeryID',sort:true}">手术ID</th>
							<th lay-data="{field:'cfID'}">处方ID</th>
							<th lay-data="{field:'surgeryName',sort:true}">手术项目</th>
							<th lay-data="{field:'sroomID',sort:true}">手术室ID</th>
							<th lay-data="{field:'doctorName',sort:true}">主刀医生</th>
							<th lay-data="{field:'patientID',sort:true}">病人ID</th>
							<th lay-data="{field:'beginTime',sort:true}">开始时间</th>
							<th lay-data="{field:'endTime'}">结束时间</th>
						</tr> 
					</thead>
					<tbody>
						<?php
						$mysqli=new mysqli("localhost","root","root","hospital_505");
						$beginTime=$_POST['beginTime'];
						$endTime=$_POST['endTime'];
						$surgeryID=$_POST['surgeryID'];
						$sql="select surg_pk,surg_sheet_no, surg_name, room_no, d_name, p_no, surg_begin_time, surg_end_time from SURGERY_SHEET a, SURGERY_ITEM b, DOCTOR c where a.surg_no=b.surg_no and a.phy_no=c.d_no and unix_timestamp(surg_end_time) >= unix_timestamp(\"$beginTime\") and unix_timestamp(surg_begin_time) <= unix_timestamp(\"$endTime\")";
						if($surgeryID!="")$sql.=" and room_no=$surgeryID";
						//echo $sql;
						$result=$mysqli->query($sql);
						if($result)
							while($row = $result -> fetch_assoc())
								{
								$surg_pk=$row["surg_pk"];
								$surg_sheet_no=$row["surg_sheet_no"];
								$surg_name=$row["surg_name"];
								$room_no=$row["room_no"];
								$doctorName=$row["d_name"];
								$p_no=$row["p_no"];
								$surg_begin_time=$row["surg_begin_time"];
								$surg_end_time=$row["surg_end_time"];
								echo "<tr><td>$surg_pk</td><td>$surg_sheet_no</td><td>$surg_name</td><td>$room_no</td><td>$doctorName</td><td>$p_no</td><td>$surg_begin_time</td><td>$surg_end_time</td></tr>";
								}
						?>
					</tbody>
				</table>
			<a href="admin-querysurgery.html" class="layui-btn">返回</a>
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
