# 操作方法

1. 请先将企业信息corp_id、应用ID和secret填入到config.php中。同时，请给upload文件夹读写权限。如sudo chmod -R 777 upload
2. 打开localhost/wework/api/ExcelMessageSending/fileUpload.php，即可打开网页上传本地的excel表格。支持.csv .xls .xlsx三种格式的excel表格
3. 上传的文件存储于upload文件夹中，可以随时查看、修改
4. 查询成员的部门可以进行修改，详情请查看processFile.php进行修改
5. 查询的数据为extattr中的“学号”一项，需要修改也可以在processFile.php中进行修改

# Excel表格要求格式
1. Excel表格只接受A、B两列数据。其中，A列为学号数据，B列为需要给同一行A列数据学号的人进行发送的消息
2. 发送消息的规则如下： <br />
i. 如果一一对应，即每一个人后面都有一条消息，则程序将一一发送各自的消息 <br />
ii. 如果没有一一对应，也接受多人发同一条消息，格式如下： <br />

|----A----|-----B-----| <br />
|---ID1---|message1| <br />
|---ID2---|message2| <br />
|---ID3---|-----------| <br />
|---ID4---|-----------| <br />
|---ID5---|message3| <br />


则学号1的同学将收到消息1，学号2、3、4的同学将收到消息2，学号5的同学将收到消息3。以此类推。如果学号后无消息，则默认取用向上搜索到的最近的一条消息进行发送。

# 报错
以下的两种情况将会报错
1. 所有excel表格A列中的人任意一个同学的学号未被搜索到（学号错误），程序将报错并指示出表格中所有没有找到对应成员的学号具体位置并报错。
2. 第一位同学发送的消息为空

# Instuction

1. Please fill in your corp_id, app_id and app secret into config.php. 
[At the same time] Please give write and read administration to folder upload/ . For instance, sudo chmod -R 777 upload
2. Open page localhost/wework/api/ExcelMessageSending/fileUpload.php where you can upload your Excel chart. .xls, .xlsx and .csv are the supported extension format.
3. Excel chart uploaded by user will be stored in the upload/ folder, which you can read/write them at any time.
4. The department id of students can be changed in processFile.php
5. Student ID number are returned in the variable "extattr", and the name can be changed in processFile.php

# The requirements of the Excel chart
1. The program will only read data from columns A and B. Data from column A are students' ID numbers and column B are the messages supposed to be sent.
2. Rules are as follows: <br />
i. If cell Bx is not NULL, then student ID Ax will receive a message Bx. <br />
ii. If cell Bx is NULL, the format will be like this tiny chart: <br />

|----A----|-----B-----| <br />
|---ID1---|message1| <br />
|---ID2---|message2| <br />
|---ID3---|-----------| <br />
|---ID4---|-----------| <br />
|---ID5---|message3| <br />

Then <br />
student ID1 will receive message1,  <br />
student ID2 ID3, ID4, will receive the same message2, <br />
student ID5 will receive message3. <br />

# Warnings
In these 2 conditions, the program will echo warnings.
1. There are at least one student ID in column A is invalid. The program will echo a warning and reveal the locations of all the invalid student ID cells.
2. The message in cell B1 is NULL.


By aVr0Ra, all right reserved. <br />
To use the code, please mark GitHub @aVr0Ra. <br />
Last edited at July, 13th, 2022.


