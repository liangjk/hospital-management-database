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
				document.write("<h2>管理员 "+sessionStorage.userID+" ，请查询病房使用情况！</h2>");
				</script>
            </blockquote>
			<blockquote class="layui-elem-quote">
				<table lay-filter="resultTable">
					<thead>
						<tr>
							<th lay-data="{field:'roomID',sort:true}">病房ID</th>
							<th lay-data="{field:'depName',sort:true}">所属科室</th>
							<th lay-data="{field:'roomCap'}">病房容量</th>
							<th lay-data="{field:'patientID',sort:true}">病人ID</th>
							<th lay-data="{field:'beginTime',sort:true}">开始日期</th>
							<th lay-data="{field:'endTime'}">结束日期</th>
						</tr> 
					</thead>
					<tbody>
						<?php
						$mysqli=new mysqli("localhost","root","root","hospital_505");
						$beginTime=$_POST['beginTime'];
						$endTime=$_POST['endTime'];
						$roomID=$_POST['roomID'];
						$sql="select a.ward_no id, dep_name, ward_cap, p_no, hos_indate, hos_outdate from HOSPITALIZATION a, WARD b,DEPARTMENT c where a.ward_no=b.ward_no and b.dep_no=c.dep_no and unix_timestamp(hos_outdate) >= unix_timestamp(\"$beginTime\") and unix_timestamp(hos_indate) <= unix_timestamp(\"$endTime\")";
						if($roomID!="")$sql.=" and a.ward_no=$roomID";
						//echo $sql;
						$result=$mysqli->query($sql);
						if($result)
							while($row = $result -> fetch_assoc())
								{
								//var_dump($row);
								$ward_no=$row["id"];
								$dep_name=$row["dep_name"];
								$ward_cap=$row["ward_cap"];
								$p_no=$row["p_no"];
								$hos_indate=$row["hos_indate"];
								$hos_outdate=$row["hos_outdate"];
								echo "<tr><td>$ward_no</td><td>$dep_name</td><td>$ward_cap</td><td>$p_no</td><td>$hos_indate</td><td>$hos_outdate</td></tr>";
								}
						?>
					</tbody>
				</table>
			<a href="admin-queryroom.html" class="layui-btn">返回</a>
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
		field: 'roomID'
		,type: 'asc'
		}
	});
	});
</script>
</body>
</html>
