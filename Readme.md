# 就医系统 使用说明

### 患者子系统

##### 登录

* 必须曾在系统中注册过，用户名为注册时得患者ID。
* 默认密码 Aa123456

##### 个人信息

* 查看个人信息界面可以查看自己录入在系统中的患者ID、姓名、性别、年龄、联系电话信息。
* 修改个人信息界面可以修改自己除了患者ID外的信息，同时点击重置可以将信息恢复至当前系统中的信息状态。

##### 医生信息查询

* 在这个功能模块中可以查询数据库中医生的医生ID、姓名、性别、职称、科室、年龄信息。
* 可以选填医生ID和姓名来进行定向查询。
* 也可以选择医生所在科室来限定查询特定特定科室的医生。

##### 挂号查询

* 在这个功能模块中可以选择查询开始时间和查询结束时间来查询该时间段内自己所有的挂号信息。
* 查询的结果信息中包括挂号单ID（病历单ID）、挂号日期、挂号医生姓名、所属科室。
* 可以在查询的结果中直接点击查看病历链接查看本次挂号的病历。

##### 病历查看

* 在这个功能模块中可以输入挂号单ID（病历单ID）来查看对应的病历。
* 与在挂号查询中点击链接查看到的病历相同。
* 病历包含处方单、检查单、检验单、药品单，如果做过手术会包含手术单。
  * 处方单包含开具医生和处理意见。
  * 检查单和检验单会包含每一项项目的名称和结果。
  * 药品单包含每一项药品的ID、名称、数量以及领取状态。
  * 手术单包含手术ID、手术项目ID、手术名称、手术室ID、主刀医生ID、姓名、开始时间、结束时间，并可以通过点击链接查看手术结果。

##### 住院情况

* 病房情况模块可以选择查询开始时间和查询结束时间来查询与该时间段相交的内自己所有的病房记录。
* 病房记录包含病房ID、所属科室、病房容量、入院和出院时间信息。
* 手术情况模块可以选择查询开始时间和查询结束时间来查询与该时间段相交的内自己所有的手术记录。
* 手术记录包含手术ID、手术名称、对应的病历单ID、主刀医生姓名、开始时间、结束时间，并可以通过点击链接查看手术结果。

##### 费用情况

* 治疗费用模块可以通过挂号单ID（病历单ID）查看对应的治疗费用。
* 治疗费用查询结果包括处方单ID、挂号费用、药品费用、检查费用、检验费用、手术费用和总费用。
* 病房费用模块可以选择查询开始时间和查询结束时间来查询与该时间段相交的内自己所有的病房费用。
* 病房费用查询结果包括病房ID、开始时间、结束时间和对应的费用，同时表格提供费用汇总功能。

##### 退出登录

* 退回到子系统选择界面。

### 医生子系统

##### 登录

* 用户名为医生ID。
* 默认密码 Aa123456

##### 个人信息

* 查看个人信息界面可以查看自己录入在系统中的医生ID、姓名、性别、职称、科室、年龄信息。
* 修改个人信息界面可以修改自己除了医生ID和职称外的信息，其中科室必须要通过下拉选框选择系统中录入的科室，同时点击重置可以将信息恢复至当前系统中的信息状态。

##### 患者信息查询

* 在这个信息模块中可以查询所有挂过登录医生的号的患者信息。
* 患者信息包括患者ID、姓名、性别、年龄、联系电话信息，同时可以点击链接直接查看他的病历。
* 可以通过输入患者ID来定向查询，如果患者ID不存在或者不曾挂过登录医生的号就会提示“没有符合条件的与您相关的患者，请重新输入！”。

##### 挂号查询

* 在这个功能模块中可以选择查询开始时间和查询结束时间来查询该时间段内自己所有的挂号信息。
* 查询的结果信息中包括挂号单ID、挂号日期、患者姓名。
* 可以在查询的结果中直接点击查看链接开具处方，如果已经开具过处方会提供查看对应病历的链接。

##### 诊断

###### 查看病历

* 查看病历模块可以通过患者ID查询对应患者的所有病历，如果患者ID不存在或者不曾挂过登录医生的号就会提示“不存在该病人或您无权查看该病人的病历，请重新输入！”
* 查询出的病历基本信息包括处方单ID、挂号日期、处方开具时间、患者ID、患者姓名、主治医生ID、主治医生姓名、主治医生科室，并可以通过链接查看详细病历内容。
* 也可以在查看病历模块直接输入处方单ID查看对应病历的详细内容，如果处方单ID不存在会提示“不存在该病历，请重新查看！”，如果查看病历的病人不曾挂过登录医生的号就会提示“您无权查看该病历！”。
* 病历详细内容包含处方单、检查单、检验单、药品单，如果做过手术会包含手术单。
  * 处方单包含患者ID和处理意见。
  * 检查单和检验单会包含每一项项目的名称和结果。
  * 药品单包含每一项药品的ID、名称、数量以及领取状态。
  * 手术单包含手术ID、手术项目ID、手术名称、手术室ID、主刀医生ID、姓名、开始时间、结束时间，并可以通过点击链接查看手术结果。

###### 开具处方

* 开具处方模块可以通过挂号单ID开具一个处方，与在挂号查询中点击链接相同，如果挂号单ID不存在或挂的不是登录医生的号，就会提示“不存在该挂号单或您无权开具该处方单，请重新输入！”，如果挂号单已经开具过处方会提供查看对应病历的链接。
* 开具处方界面会显示挂号单ID、医生ID、患者ID、患者姓名信息，填入处置方案并点击“确认开具”就可以开具一个处方。

###### 安排检查

* 安排检查模块可以给对应处方安排检查项目。
* 检查项目ID和名称任填其一即可，或者需要ID和姓名对应。
* 如果输入的检查项目不存在，或者ID和姓名不对应会提示“不存在这项检查，请重新输入！”。
* 如果处方单ID不存在，或者该处方单不由登录医生开具，会提示“不存在该处方单或您无权对该处方单安排检查！”。
* 如果检查项目ID和名称都为空，会提示“检查项目ID和项目名称请至少填写一项！”。
* 如果该处方单已安排过此项检查会提示“该处方单已安排过此项检查，请重新输入！”。

###### 安排检验

* 安排检验模块可以给对应处方安排检验项目。
* 检验项目ID和名称任填其一即可，或者需要ID和姓名对应。
* 如果输入的检验项目不存在，或者ID和姓名不对应会提示“不存在这项检验，请重新输入！”。
* 如果处方单ID不存在，或者该处方单不由登录医生开具，会提示“不存在该处方单或您无权对该处方单安排检验！”。
* 如果检验项目ID和名称都为空，会提示“检验项目ID和项目名称请至少填写一项！”。
* 如果该处方单已安排过此项检验会提示“该处方单已安排过此项检验，请重新输入！”。

###### 开具药品

* 开具药品模块可以给对应的处方开具药品。
* 药品ID和名称任填其一即可，或者需要ID和姓名对应。
* 如果开具的药品不存在，或者ID和姓名不对应会提示“不存在这种药品，请重新输入！”。
* 如果处方单ID不存在，或者该处方单不由登录医生开具，会提示“不存在该处方单或您无权对该处方单开具药品！”。
* 如果开具的药品ID和名称都为空，会提示“药品的ID和名称请至少填写一项！”。
* 如果该处方单已开具过这种药品，会提示“该处方单已开具过此种药品，请重新输入！”。
* 药品数量为必填项。

##### 退出登录

* 退回到子系统选择界面。

### 管理子系统

##### 登录

* 用户名任意
* 默认密码为 rootlab505

##### 挂号

* 这个功能模块可以进行一次挂号操作。
* 患者ID和医生ID是必填项。
* 如果是新患者需要选中新患者选项并填写患者的基本信息。
* 如果检测新旧患者与填写不符会进行提示。
* 如果挂号成功会返回挂号的患者和医生姓名。

##### 检查检验

* 录入检查结果模块可以为指定处方单的指定检查项目录入结果。
* 录入检验结果模块可以为指定处方单的指定检验项目录入结果。
* 如果处方单ID不存在或者处方单中并没有开具指定的检查（检验）会提示“没有该项检查，请重新录入！”（“没有该项检验，请重新录入！”）。

##### 手术

###### 查询手术

* 查询手术模块可以选择查询开始时间和查询结束时间来查询与该时间段相交的内所有的手术记录。
* 可以选填手术室ID来进行定向查询。
* 查询手术模块也可以直接填入手术ID查询指定手术的记录。
* 手术记录包含手术ID、处方ID、手术项目名称、手术室ID、主刀医生姓名、病人ID、开始时间和结束时间信息。

###### 安排手术

* 安排手术模块可以输入处方ID、手术项目ID、医生ID、手术室ID、开始时间和结束时间来安排一场手术。
* 如果选择的主刀医生在对应时间段内已安排有手术会提示“该主刀医生此时间段内已安排有手术，请重新输入！”。
* 如果选择的手术室在对应时间段内已安排有手术会提示“该手术室此时间段内已安排有手术，请重新输入！”。
* 如果处方单对应的患者对应时间段内已安排有手术会提示“该患者此时间段内已安排有手术，请重新输入！”。

###### 录入手术结果

* 录入手术结果模块可以为指定手术录入手术结果。
* 如果输入的手术ID不存在，会提示“没有该场手术，请重新录入！”。

##### 病房

###### 查询病房

* 查询病房模块可以选择查询开始时间和查询结束时间来查询与该时间段相交的内所有的病房记录。
* 也可以选填病房ID来进行定向查询。
* 病房记录包含病房ID、所属科室、病房容量、病人ID、开始日期、结束日期信息。

###### 安排病房

* 安排病房模块可以输入患者ID、病房ID、入院日期和出院日期来安排病房。
* 如果患者ID不存在，会提示“没有该病人，请重新输入！”。

* 如果病房在对应时间段内已经住满，会提示“该时间段内此病房无法安排新病人，请重新输入！”。
* 如果患者在对应时间段内已安排有病房，会提示“该时间段内此病人已安排病房，请重新输入！”。

##### 药品

###### 查询库存

* 在查询库存模块中直接点击“确认查询”可以查询所有药品库存。
* 可以选填药品ID或名称来进行定向查询，如果两项都填需要ID和名称对应。

###### 领取药材

* 领取药材模块可以输入处方单ID来领取对应处方单开具的药品，如果处方单中部分药品已经领取过，只会领取新开具的药品。

* 如果处方单ID不存在，或者处方单没有开具药品，或者处方单开具的药品已全部领取会提示“没有该处方单，或该处方单没有未领取的药品，请重新输入！”。
* 如果处方单内开具的某些药品库存不足，会提示“药品 XXX 库存不足，不能领取！”。

###### 药材入库

* 药材入库模块可以登记药品入库。
* 药品ID和名称填写一项即可，如果两项都填需要ID和名称对应。
* 如果药品ID或名称不存在，或ID和名称不对应会提示“没有该种药品，请重新输入！”。
* 入库数量是必填项。

##### 费用

###### 治疗费用

* 治疗费用模块可以输入患者ID查询它所有的处方单对应的治疗费用。
* 挂号记录包含患者ID、患者姓名、处方单ID信息，可以通过点击链接查看处方单对应的费用。
* 治疗费用模块也可以直接输入处方单ID查看对应的费用。
* 治疗费用的详细信息包括处方ID、患者ID、患者姓名信息，费用部分包括挂号费用、药品费用、检查费用、检验费用、手术费用和总费用。

###### 病房费用

* 病房费用模块可以输入患者ID并选择查询开始时间和查询结束时间来查询与该时间段相交的内指定患者所有的病房费用记录。
* 病房费用记录包含患者ID、患者姓名、病房ID、开始日期、结束日期和病房费用信息，同时表格提供费用汇总功能。

##### 退出登录

* 退回到子系统选择界面。