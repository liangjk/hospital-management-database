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
					$doctorID=(int)$_GET['doctorID'];
					$patientID=$_GET['patientID'];
					$sql="select d_name from DOCTOR where d_no=$doctorID";
					$result=$mysqli->query($sql);
					if($result&&$result->num_rows>0)
						{
						$row = $result -> fetch_assoc();
						$doctorName=$row['d_name'];
						echo "<h2>医生 $doctorName ，请查看一名患者的病历！</h2>";
						echo "</blockquote><blockquote class=\"layui-elem-quote\">";
						$sql="select p_name from REGISTER a,PATIENT b where d_no=$doctorID and a.p_no=$patientID and a.p_no=b.p_no";
						$result=$mysqli->query($sql);
						if($result&&$result->num_rows>0)
							{
							echo "<table lay-filter=\"resultTable\">
								<thead>
									<tr>
										<th lay-data=\"{field:'formID',sort:true}\">处方单ID</th>
										<th lay-data=\"{field:'regDate',sort:true}\">挂号日期</th>
										<th lay-data=\"{field:'formTime',sort:true}\">处方单开具时间</th>
										<th lay-data=\"{field:'patientID',sort:true}\">患者ID</th>
										<th lay-data=\"{field:'patientName'}\">患者姓名</th>
										<th lay-data=\"{field:'doctorID',sort:true}\">主治医生ID</th>
										<th lay-data=\"{field:'doctorName'}\">主治医生姓名</th>
										<th lay-data=\"{field:'doctorDep',sort:true}\">主治医生科室</th>
										<th lay-data=\"{field:'option'}\">操作</th>
									</tr> 
								</thead>
								<tbody>
								";
							$row = $result -> fetch_assoc();
							$patientName=$row['p_name'];
							$sql="select distinct form_no,reg_date,form_time,b.d_no,c.d_name d_name,dep_name from REGISTER a, FORMULATION b,DOCTOR c,DEPARTMENT d where form_no=reg_no and a.p_no=b.p_no and a.p_no=$patientID and b.d_no=c.d_no and c.dep_no=d.dep_no";
							$result=$mysqli->query($sql);
							if($result)
								while($row = $result -> fetch_assoc())
									{
									$formID=$row['form_no'];
									$regDate=$row['reg_date'];
									$formTime=$row['form_time'];
									$d_no=$row['d_no'];
									$d_name=$row['d_name'];
									$d_dep=$row['dep_name'];
									echo "<tr><td>$formID</td><td>$regDate</td><td>$formTime</td><td>$patientID</td><td>$patientName</td><td>$d_no</td><td>$d_name</td><td>$d_dep</td><td><a href=\"doctor-binglicontent.php?doctorID=$doctorID&formID=$formID\" class=\"layui-btn layui-btn-normal layui-btn-sm\">查看内容</a></td></tr>";
									}
							echo "</tbody></table>";
							}
						else
							echo "<h2>不存在该病人或您无权查看该病人的病历，请重新输入！</h2>";
						
						}
					else
						echo "<script>sessionStorage.isLogin=0;</script>";
				?>
			<script>document.write("<a href=\"doctor-bingli.php?userID="+sessionStorage.userID+"\" class=\"layui-btn\">返回</a>");</script>
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
		field: 'formDate'
		,type: 'asc'
		}
	});
	});
</script>
</body>
</html>
