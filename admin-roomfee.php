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
				document.write("<h2>管理员 "+sessionStorage.userID+" ，请查询病房费用情况！</h2>");
				</script>
            </blockquote>
			<blockquote class="layui-elem-quote">
                <?php
					$mysqli=new mysqli("localhost","root","root","hospital_505");
					$patientID=$_POST['patientID'];
					$beginTime=$_POST['beginTime'];
					$endTime=$_POST['endTime'];
					$sql="select p_name from PATIENT where p_no=$patientID";
					$result=$mysqli->query($sql);
					if($result&&$result->num_rows>0)
						{
						$row = $result -> fetch_assoc();
						$patientName=$row['p_name'];
						$sql="select a.ward_no ward_no,hos_indate,hos_outdate,ward_cost*(TIMESTAMPDIFF(DAY, hos_indate, hos_outdate)+1) ward_fee from HOSPITALIZATION a,WARD b where p_no=$patientID and a.ward_no=b.ward_no and unix_timestamp(hos_outdate) >= unix_timestamp(\"$beginTime\") and unix_timestamp(hos_indate) <= unix_timestamp(\"$endTime\")";
						$result=$mysqli->query($sql);
						if($result&&$result->num_rows>0)
							{
							echo "<table lay-filter=\"resultTable\">
									<thead>
										<tr>
											<th lay-data=\"{field:'patientID',totalRowText: '费用合计：'}\">患者ID</th>
											<th lay-data=\"{field:'patientName'}\">患者姓名</th>
											<th lay-data=\"{field:'roomID',sort:true}\">病房ID</th>
											<th lay-data=\"{field:'beginTime',sort:true}\">开始日期</th>
											<th lay-data=\"{field:'endTime'}\">结束日期</th>
											<th lay-data=\"{field:'wardFee',totalRow:true}\">病房费用</th>
										</tr> 
									</thead>
									<tbody>";
							while($row = $result -> fetch_assoc())
								{
								$ward_no=$row["ward_no"];
								$hos_indate=$row["hos_indate"];
								$hos_outdate=$row["hos_outdate"];
								$ward_fee=$row["ward_fee"];
								echo "<tr><td>$patientID</td><td>$patientName</td><td>$ward_no</td><td>$hos_indate</td><td>$hos_outdate</td><td>$ward_fee</td></tr>";
								}
							echo "</tbody></table>";
							}
						else
							echo "<h2>该患者此段时间内没有住院记录，请重新查询！</h2>";
						}
					else
						echo "<h2>该患者不存在，请重新输入！</h2>";
				?>
			<a href="admin-roomfee.html" class="layui-btn">返回</a>
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
	,totalRow: true
	,initSort: {
		field: 'beginTime'
		,type: 'asc'
		}
	});
	});
</script>
</body>
</html>
