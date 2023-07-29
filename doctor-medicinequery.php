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
					$cfID=$_POST['cfID'];
					$medicineID=$_POST['medicineID'];
					$medicineName=$_POST['medicineName'];
					$medicineQuantity=$_POST['medicineQuantity'];
					$sql="select d_name from DOCTOR where d_no=$doctorID";
					$result=$mysqli->query($sql);
					if($result&&$result->num_rows>0)
						{
						$row = $result -> fetch_assoc();
						$doctorName=$row['d_name'];
						echo "<h2>医生 $doctorName ，请开具药品！</h2>";
						echo "</blockquote><blockquote class=\"layui-elem-quote\">";
						$sql="select form_no from FORMULATION where form_no=$cfID and d_no=$doctorID";
						$result=$mysqli->query($sql);
						if($result&&$result->num_rows>0)
							{
							if($medicineID==""&&$medicineName=="")
								echo "<h2>药品的ID和名称请至少填写一项！</h2>";
							else
								{
								$sql="select m_no from MEDICINE where 1=1";
								if($medicineID!="")$sql.=" and m_no=$medicineID";
								if($medicineName!="")$sql.=" and m_name=\"$medicineName\"";
								$result=$mysqli->query($sql);
								if($result&&$result->num_rows>0)
									{
									$row = $result -> fetch_assoc();
									$medicineID=$row['m_no'];
									$sql="select m_sheet_no,m_no from MEDICINE_SHEET where m_sheet_no=$cfID and m_no=$medicineID";
									$result=$mysqli->query($sql);
									if($result&&$result->num_rows>0)
										echo "<h2>该处方单已开具过此种药品，请重新输入！</h2>";
									else
										{
										$sql="insert MEDICINE_SHEET values($cfID,$medicineID,$medicineQuantity,0)";
										if($mysqli->query($sql)==FALSE)
											echo "<h2>数据有误，未能成功开具药品，请重新开具</h2>";
										else
											echo "<h2>开具药品成功！</h2>";
										}									
									}
								else
									echo "<h2>不存在这种药品，请重新输入！</h2>";
								}
							}
						else
							echo "<h2>不存在该处方单或您无权对该处方单开具药品！</h2>";
						}
					else
						echo "<script>sessionStorage.isLogin=0;</script>";
				?>
			<script>document.write("<a href=\"doctor-medicine.php?userID="+sessionStorage.userID+"\" class=\"layui-btn\">返回</a>");</script>
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
</script>
</body>
</html>
