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
					$formID=$_POST['formID'];
					$sql="select p_name from PATIENT where p_no=$patientID";
					$result=$mysqli->query($sql);
					if($result&&$result->num_rows>0)
						{
						$row = $result -> fetch_assoc();
						$patientName=$row['p_name'];
						echo "<h2>患者 $patientName ，请查询您的治疗费用！</h2>";
						echo "</blockquote><blockquote class=\"layui-elem-quote\">";
						$sql="select form_no from FORMULATION where p_no=$patientID and form_no=$formID";
						$result=$mysqli->query($sql);
						if($result&&$result->num_rows>0)
							{
							$sql="select 48.5 reg_fee, ifnull(smf,0) medicine_fee, ifnull(sef,0) exam_fee, ifnull(stf,0) test_fee, ifnull(ssf,0) surgery_fee from (select sum(m_cost*quantity) smf from MEDICINE_SHEET a,MEDICINE b where m_sheet_no=$formID and m_status=2 and a.m_no=b.m_no) mf, (select sum(exm_cost) sef from EXAMINATION_SHEET a,EXM_ITEM b where exm_sheet_no=$formID and a.exm_no=b.exm_no) ef, (select sum(test_cost) stf from TEST_SHEET a,TEST_ITEM b where test_sheet_no=$formID and a.test_no=b.test_no) tf, (select sum(surg_cost) ssf from SURGERY_SHEET a,SURGERY_ITEM b where a.surg_sheet_no=$formID and a.surg_no=b.surg_no) sf";
							$result=$mysqli->query($sql);
							if($result)
								{
								echo "<table lay-filter=\"resultTable\">
											<thead>
												<tr>
													<th lay-data=\"{field:'formID'}\">处方单ID</th>
													<th lay-data=\"{field:'regFee'}\">挂号费用</th>
													<th lay-data=\"{field:'mFee'}\">药品费用</th>
													<th lay-data=\"{field:'exmFee'}\">检查费用</th>
													<th lay-data=\"{field:'testFee'}\">检验费用</th>
													<th lay-data=\"{field:'sFee'}\">手术费用</th>
													<th lay-data=\"{field:'sumFee'}\">总费用</th>
												</tr> 
											</thead>
											<tbody>";
								$row = $result -> fetch_assoc();
								$reg_fee=$row['reg_fee'];
								$medicine_fee=$row['medicine_fee'];
								$exam_fee=$row['exam_fee'];
								$test_fee=$row['test_fee'];
								$surgery_fee=$row['surgery_fee'];
								$sum_fee=$reg_fee+$medicine_fee+$exam_fee+$test_fee+$surgery_fee;
								echo "<tr><td>$formID</td><td>$reg_fee</td><td>$medicine_fee</td><td>$exam_fee</td><td>$test_fee</td><td>$surgery_fee</td><td>$sum_fee</td></tr>";
								echo "</tbody></table>";
								}
							}
						else
							echo "<h2>该病历单不存在或您无权查询，请重新输入！</h2>";
						}
					else
						echo "<script>sessionStorage.isLogin=0;</script>";
				?>
			<script>document.write("<a href=\"patient-medicalfee.php?userID="+sessionStorage.userID+"\" class=\"layui-btn\">返回</a>");</script>
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
	height: 80
	,page: false
	});
	});
</script>
</body>
</html>
