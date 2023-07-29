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
					$formID=$_GET['formID'];
					$sql="select d_name from DOCTOR where d_no=$doctorID";
					$result=$mysqli->query($sql);
					if($result&&$result->num_rows>0)
						{
						$row = $result -> fetch_assoc();
						$doctorName=$row['d_name'];
						echo "<h2>医生 $doctorName ，请查看一名患者的病历！</h2>";
						echo "</blockquote><blockquote class=\"layui-elem-quote\">";
						$sql="select p_no,form_content from FORMULATION where form_no=$formID";
						//echo $sql;
						$result=$mysqli->query($sql);
						if($result&&$result->num_rows>0)
							{
							$row = $result -> fetch_assoc();
							$p_no=$row['p_no'];
							$form_content=$row['form_content'];
							$checksql="select reg_no from REGISTER where d_no=$doctorID and p_no=$p_no";
							$checkresult=$mysqli->query($checksql);
							if($checkresult&&$checkresult->num_rows>0)
								{
								echo "<h2>处方单：</h2>";
								echo "<form class=\"layui-form layui-form-pane\">";
								echo "<div class=\"layui-form-item\" pane>";
								echo "<label class=\"layui-form-label\">患者ID</label>
									<div class=\"layui-input-block\">
										<input type=\"text\" autocomplete=\"off\" class=\"layui-input\" readonly value=\"$p_no\" />
									</div>";
								echo "</div>";
								echo "<div class=\"layui-form-item\" pane>";
								echo "<label class=\"layui-form-label\">处置方案</label>
									<div class=\"layui-input-block\">
										<textarea readonly class=\"layui-textarea\">$form_content</textarea>
									</div>";
								echo "</div>";
								echo "</form>";
								
								echo "<br/><h2>检查单：</h2>";
								$jcsql="select exm_name,exm_result from EXAMINATION_SHEET a,EXM_ITEM b where exm_sheet_no=$formID and a.exm_no=b.exm_no";
								$jcresult=$mysqli->query($jcsql);
								if($jcresult&&$jcresult->num_rows>0)
									while($jcrow=$jcresult->fetch_assoc())
										{
										$jcName=$jcrow['exm_name'];
										$jcResult=$jcrow['exm_result'];
										echo "<form class=\"layui-form layui-form-pane\">";
										echo "<div class=\"layui-form-item\" pane>";
										echo "<label class=\"layui-form-label\">检查项目</label>
											<div class=\"layui-input-block\">
												<input type=\"text\" autocomplete=\"off\" class=\"layui-input\" readonly value=\"$jcName\" />
											</div>";
										echo "</div>";
										echo "<div class=\"layui-form-item\" pane>";
										echo "<label class=\"layui-form-label\">检查结果</label>
											<div class=\"layui-input-block\">
												<textarea readonly class=\"layui-textarea\">$jcResult</textarea>
											</div>";
										echo "</div>";
										echo "</form>";
										}
								else
									echo "<h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;无</h2>";
								
								echo "<br/><h2>检验单：</h2>";
								$jysql="select test_name,test_result from TEST_SHEET a,TEST_ITEM b where test_sheet_no=$formID and a.test_no=b.test_no";
								$jyresult=$mysqli->query($jysql);
								if($jyresult&&$jyresult->num_rows>0)
									while($jyrow=$jyresult->fetch_assoc())
										{
										$jyName=$jyrow['test_name'];
										$jyResult=$jyrow['test_result'];
										echo "<form class=\"layui-form layui-form-pane\">";
										echo "<div class=\"layui-form-item\" pane>";
										echo "<label class=\"layui-form-label\">检验项目</label>
											<div class=\"layui-input-block\">
												<input type=\"text\" autocomplete=\"off\" class=\"layui-input\" readonly value=\"$jyName\" />
											</div>";
										echo "</div>";
										echo "<div class=\"layui-form-item\" pane>";
										echo "<label class=\"layui-form-label\">检验结果</label>
											<div class=\"layui-input-block\">
												<textarea readonly class=\"layui-textarea\">$jyResult</textarea>
											</div>";
										echo "</div>";
										echo "</form>";
										}
								else
									echo "<h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;无</h2>";
								
								echo "<br/><h2>药品单：</h2>";
								echo "<table lay-filter=\"medicineTable\">
								<thead>
									<tr>
										<th lay-data=\"{field:'mID',sort:true}\">药品ID</th>
										<th lay-data=\"{field:'mName'}\">药品名称</th>
										<th lay-data=\"{field:'mQuantity'}\">数量</th>
										<th lay-data=\"{field:'mStatus',sort:true}\">状态</th>
									</tr> 
								</thead>
								<tbody>
								";
								$msql="select a.m_no m_no,m_name,quantity,m_status from MEDICINE_SHEET a,MEDICINE b where a.m_sheet_no=$formID and a.m_no=b.m_no";
								$mresult=$mysqli->query($msql);
								if($mresult)
									while($mrow=$mresult->fetch_assoc())
										{
										$m_no=$mrow['m_no'];
										$m_name=$mrow['m_name'];
										$quantity=$mrow['quantity'];
										$m_status=$mrow['m_status']==2?"已领取":"未领取";
										echo "<tr><td>$m_no</td><td>$m_name</td><td>$quantity</td><td>$m_status</td></tr>";
										}
								echo "</tbody></table>";
								
								$ssql="select surg_pk,a.surg_no surg_no,surg_name,room_no,phy_no,d_name,surg_begin_time,surg_end_time,surg_result from SURGERY_SHEET a,SURGERY_ITEM b,DOCTOR c where surg_sheet_no=$formID and a.surg_no=b.surg_no and phy_no=d_no";
								$sresult=$mysqli->query($ssql);
								if($sresult&&$sresult->num_rows>0)
									{
									echo "<br/><h2>手术单：</h2>";
									echo "<table lay-filter=\"surgeryTable\">
											<thead>
												<tr>
													<th lay-data=\"{field:'sPK',sort:true}\">手术ID</th>
													<th lay-data=\"{field:'sID',sort:true}\">手术项目ID</th>
													<th lay-data=\"{field:'sName'}\">手术名称</th>
													<th lay-data=\"{field:'roomID'}\">手术室ID</th>
													<th lay-data=\"{field:'dID',sort:true}\">主刀医生ID</th>
													<th lay-data=\"{field:'dName'}\">主刀医生姓名</th>
													<th lay-data=\"{field:'beginTime',sort:true}\">手术开始时间</th>
													<th lay-data=\"{field:'endTime'}\">手术结束时间</th>
													<th lay-data=\"{field:'option'}\">操作</th>
												</tr> 
											</thead>
											<tbody>
											";
									while($srow=$sresult->fetch_assoc())
										{
										$sPK=$srow['surg_pk'];
										$sID=$srow['surg_no'];
										$sName=$srow['surg_name'];
										$roomID=$srow['room_no'];
										$dID=$srow['phy_no'];
										$dName=$srow['d_name'];
										$bTime=$srow['surg_begin_time'];
										$eTime=$srow['surg_end_time'];
										$sJieguo=str_replace("\r\n","<br/>",$srow["surg_result"]);
										echo "<tr><td>$sPK</td><td>$sID</td><td>$sName</td><td>$roomID</td><td>$dID</td><td>$dName</td><td>$bTime</td><td>$eTime</td><td><button type=\"button\" class=\"layui-btn layui-btn-normal layui-btn-sm\" ";
										echo "onclick=\"
											layui.use('layer', function(){
												var layer = layui.layer;
  
												layer.open({
													title: '手术结果'
													,content: '$sJieguo'
													,shadeClose: true
													});  
											});   
											\"";
										echo ">查看手术结果</button></td></tr>";
										}
									echo "</tbody></table>";
									}
								}
							else
								echo "<h2>您无权查看该病历！</h2>";
							}
						else
							echo "<h2>不存在该病历，请重新查看！</h2>";
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

	table.init('medicineTable',{
	height: 250
	,limits: [5,10]
	,limit: 5
	,page: true
	,initSort: {
		field: 'mStatus'
		,type: 'asc'
		}
	});
	
	table.init('surgeryTable',{
	height: 250
	,limits: [5,10]
	,limit: 5
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
