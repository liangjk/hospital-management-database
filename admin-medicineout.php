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
				document.write("<h2>管理员 "+sessionStorage.userID+" ，请确认药品领取！</h2>");
				</script>
            </blockquote>
			<blockquote class="layui-elem-quote">
				<?php
				$mysqli=new mysqli("localhost","root","root","hospital_505");
				$cfID=$_POST["cfID"];
				$sql="select m_name from (select m_name,m_quantity-quantity rest from MEDICINE a, MEDICINE_SHEET b where m_status=0 and b.m_sheet_no=$cfID and a.m_no=b.m_no) c where rest<0";
				$result=$mysqli->query($sql);
				if($result&&$result->num_rows>0)
					{
					$names="";
					while($row = $result -> fetch_assoc())
						{
						$name=$row['m_name'];
						$names.=" $name";
						}
					echo "<h2>药品$names 库存不足，不能领取！</h2>";
					}
				else
					{
					$sql="update MEDICINE a inner join MEDICINE_SHEET b on m_status=0 and b.m_sheet_no=$cfID and a.m_no=b.m_no set m_quantity=m_quantity-quantity, m_status=1";
					if($mysqli->query($sql)==FALSE)
						echo "<h2>数据有误，未能成功领取药品，请重新输入！</h2>";
					else
						{
						$sql="select a.m_no id, m_name, quantity, m_quantity from MEDICINE a, MEDICINE_SHEET b where m_status=1 and b.m_sheet_no=$cfID and a.m_no=b.m_no";
						$result=$mysqli->query($sql);
						if($result&&$result->num_rows>0)
							{
							echo "<h2>领取药品成功！该处方新领取药品清单如下：</h2>";
							echo "
							<table lay-filter=\"resultTable\">
								<thead>
									<tr>
										<th lay-data=\"{field:'medicineID',sort:true}\">药品ID</th>
										<th lay-data=\"{field:'medicineName',sort:true}\">药品名称</th>
										<th lay-data=\"{field:'quantity'}\">药品领取数量</th>
										<th lay-data=\"{field:'rest'}\">药品剩余库存</th>
									</tr> 
								</thead>
								<tbody>
								";
							while($row = $result -> fetch_assoc())
								{
								$id=$row['id'];
								$m_name=$row['m_name'];
								$quantity=$row['quantity'];
								$m_quantity=$row['m_quantity'];
								echo "<tr><td>$id</td><td>$m_name</td><td>$quantity</td><td>$m_quantity</td></tr>";
								}
							echo "
								</tbody>
							</table>
							<script>
								var flag=true;
							</script>
							";
							$sql="update MEDICINE_SHEET set m_status=2 where m_sheet_no=$cfID and m_status=1";
							$mysqli->query($sql);
							}
						else
							echo "<h2>没有该处方单，或该处方单没有未领取的药品，请重新输入！</h2>";
						}
					}
				?>
			<a href="admin-medicineout.html" class="layui-btn">返回</a>
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
	if(flag){
		layui.use('table', function(){
		var table = layui.table;

		table.init('resultTable',{
		height: 500
		,limit:10
		,page: true
		,initSort: {
			field: 'medicineID'
			,type: 'asc'
			}
		});
		});
	}
</script>
</body>
</html>
