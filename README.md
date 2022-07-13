hello World! This is my 1st GitHub repository!

# 定制的企业微信消息推送系统 by aVr0Ra

# About
本推送系统是基于[weworkapi_php示范文档](https://github.com/sbzhu/weworkapi_php)进行设计的，基于php7.3, MariaDB 10.3.35 进行开发的开源的定制消息推送系统，可以实现消息的自定义推送功能。
# 支持的操作有：
- 根据excel表格，进行一人一条消息的便捷推送。起始网页位于 /api/ExcelMessageSending/fileUpload.php <br />
-- 目前支持.csv, .xls, .xlsx文件 <br />
-- 可以支持一人一条消息的推送，也支持多人推送同一条消息 <br />
-- 服务器中会存储相关消息推送文件，以便查找 <br />
-- 本功能由[PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet)构架支撑excel表格的阅读功能。<br />
-- 操作指南请见 /api/ExcelMessageSending/README.md <br /> <br />

# Custom Wework Message Sending System by aVr0Ra

# About
This system is constructed based on [weworkapi_php](https://github.com/sbzhu/weworkapi_php) and PHP ver7.3, MariaDB 10.3.35.

# Function
- This system can send message from an Excel chart. File Upload Page is at /api/ExcelMessageSending/fileUpload.php <br />
-- Excel Chart supported extension: .csv, .xls, .xlsx <br />
-- It can send everyone in the chart a different message or send multiple users the same message.<br />
-- The Excel Chart uploaded by user will be saved in the server for further searching purpose. <br />
-- This repository is supported by [PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet) to help to read the Excel chart. <br />
-- Please check /api/ExcelMessageSending/README.md for further instruction. <br /> <br />


By aVr0Ra, all right reserved. <br />
To use the code, please mark GitHub @aVr0Ra. <br />
Last edited at July, 13th, 2022.
