<?php
/*to minify*/
echo "<style>
html, body {
	overflow: hidden !important;
}
#brisk-script-manager-wrapper {
	display: none;
	position: fixed;
	z-index: 99999999;
	top: 32px;
	bottom: 0px;
	left: 0px;
	right: 0px;
	overflow-y: auto;
}


#brisk-script-manager {padding: 0px 0px 0px 0px;}

#brisk-script-manager {
	background: #EEF2F5;
	font-size: 14px;
	line-height: 1.5em;
	color: #4a545a;
	min-height: 100%;
}
#brisk-script-manager a {
	color: #4A89DD;
	text-decoration: none;
	border: none;
}
#brisk-script-manager label {
	float: none;
	opacity: 1;
}
#brisk-script-manager-header {
	/* position: fixed; */
	top: 32px;
	/* right: 0px; */
	/* display: table-caption; */
	/* bottom: 0px; */
	width: 100%;
	/* margin-left: 750px; */
	/* background: #282E34; */
}
#brisk-script-manager-header h2 {
	font-size: 24px;
	margin: 0px 0px 10px 0px;
	color: #4a545a;
	font-weight: bold;
}
#brisk-script-manager-header h2 span {
	background: #D11A2A;
	color: #ffffff;
	padding: 5px;
	vertical-align: middle;
	font-size: 10px;
	margin-left: 5px;
}
#brisk-script-manager-header p {
	font-size: 14px;
	color: #4a545a;
	font-style: italic;
	margin: 0px auto 15px auto;
}
#brisk-script-manager-tabs button {
	text-align: center;
	display: block;
	float: left;
	/* padding: 15px 20px; */
	width: 33%;
	font-size: 0.9em;
	line-height: 0.4em;
	text-align: center;
	background: #222222;
	color: #ffffff;
	/* font-weight: normal; */
	border: none;
	cursor: pointer;
	/* border-radius: 0px; */
}
#brisk-script-manager-tabs {
	overflow: hidden;
}
#brisk-script-manager-tabs button span {
	display: block;
	font-size: 12px;
	margin-top: 5px;
}
#brisk-script-manager-tabs button.active {
	width: 34%;
	background: #4a89dd;
	color: #ffffff;
}
#brisk-script-manager-tabs button:hover {
	background: #ffffff;
	color: #4A89DD;
}
#brisk-script-manager-tabs button.active:hover {
	background: #4A89DD;
	color: #ffffff;
}
#brisk-script-manager-disclaimer {
	background: #ffffff;
	display: none;
	padding: 20px 20px 10px 20px;
}
#brisk-script-manager-disclaimer p {
	font-size: 14px;
	margin: 0px 0px 10px 0px;
}
#brisk-script-manager-container {
	/* max-width: 1000px; */
	margin: 0px;
}
#brisk-script-manager-container .brisk-script-manager-title-bar {
	padding: 20px 0px 30px 30px;
	text-align: left;
}
#brisk-script-manager-container .brisk-script-manager-title-bar h1 {
	font-size: 28px;
	line-height: normal;
	font-weight: 400;
	margin: 0px;
	color: #282E34;
}
#brisk-script-manager-container .brisk-script-manager-title-bar p {
	margin: 0px;
	color: #282E34;
}
#brisk-script-manager h3 {
	padding: 5px;
    margin: 0px;
    background: #3ca900;
    font-family: unset;
    font-size: x-large;
    color: #ffffff;
    text-transform: uppercase;
    font-weight: 100;
    text-align: center;
}
.brisk-script-manager-group {
	/* box-shadow: 0 1px 6px 0 rgba(40,46,52,.3); */
	/* padding: 0px 0px 0px 0px; */
}
.brisk-script-manager-group h4 {
	font-size: 1.3em;
    font-family: sans-serif;
    line-height: 40px;
    margin: 0px;
    padding-left: 15px;
    background: #222222;
    color: #FFF;
    font-weight: 100;
    font-size: medium;
}
.brisk-script-manager-section {
	padding: 0px;
	background: #ffffff;
	margin: 0px 0px 0px 0px;
	overflow: hidden;
}
#brisk-script-manager table {
	table-layout: fixed;
	width: 100%;
	margin: 0px;
	padding: 0px;
	border: none;
	text-align: left;
	font-size: 14px;
	border-collapse: collapse;
}
#brisk-script-manager table thead {
	background: none;
	color: #282E34;
	font-weight: bold;
	border: none;
}
#brisk-script-manager table thead tr {
	border: none;
	border-bottom: 2px solid #dddddd;
}
#brisk-script-manager table thead th {
	font-size: 14px;
	padding: 8px 5px;
	vertical-align: middle;
	border: none;
}
#brisk-script-manager table tr {
	border: none;
	border-bottom: 1px solid #eeeeee;
	background: #ffffff;
}
#brisk-script-manager table tbody tr:last-child {
	border-bottom: 0px;
}
#brisk-script-manager table td {
	padding: 8px 5px;
	border: none;
	vertical-align: top;
	font-size: 14px;
}
#brisk-script-manager table td.brisk-script-manager-type {
	font-size: 14px;
	text-align: center;
	padding-top: 16px;
	text-transform: uppercase;
}
#brisk-script-manager table td.brisk-script-manager-size {
	font-size: 14px;
	text-align: center;
	padding-top: 16px;
}
#brisk-script-manager table td.brisk-script-manager-script a {
	white-space: nowrap;
}
#brisk-script-manager .brisk-script-manager-script span {
	display: block;
	max-width: 100%;
	overflow: hidden;
	text-overflow: ellipsis;
	font-size: 14px;
	font-weight: bold;
	margin-bottom: 3px;
}
#brisk-script-manager .brisk-script-manager-script a {
	display: block;
	max-width: 100%;
	overflow: hidden;
	text-overflow: ellipsis;
	font-size: 10px;
	color: #4A89DD;
	line-height: normal;
}
#brisk-script-manager .brisk-script-manager-disable, #brisk-script-manager .brisk-script-manager-enable {
	margin: 2px 0px 0px 0px; 
}
#brisk-script-manager table .brisk-script-manager-disable *:after, #brisk-script-manager table .brisk-script-manager-disable *:before {
	display: none;
}
#brisk-script-manager select {
	display: block;
	position: relative;
	height: auto;
	width: auto;
	background: #ffffff;
	background-color: #ffffff;
	padding: 7px 10px;
	margin: 0px;
	font-size: 14px;
	appearance: menulist;
	-webkit-appearance: menulist;
	-moz-appearance: menulist;
}
#brisk-script-manager select.brisk-disable-select, #brisk-script-manager select.brisk-status-select {
	border: 2px solid #27ae60;
}
#brisk-script-manager select.brisk-disable-select.everywhere, #brisk-script-manager select.brisk-status-select.disabled {
	border: 2px solid #D11A2A;
}
#brisk-script-manager select.brisk-disable-select.current {
	border: 2px solid #f1c40f;
}
#brisk-script-manager select.brisk-disable-select.hide {
	display: none;
}
#brisk-script-manager .brisk-script-manager-enable-placeholder {
	color: #bbbbbb;
	font-style: italic;
	font-size: 14px;
}
#brisk-script-manager input[type='radio'] {
	position: relative;
	display: inline-block;
	margin: 0px 3px 0px 0px;
	vertical-align: middle;
	opacity: 1;
	z-index: 0;
	appearance: radio;
	-webkit-appearance: radio;
	-moz-appearance: radio;
	vertical-align: baseline;
	height: auto;
	width: auto;
	font-size: 16px;
}
#brisk-script-manager input[type='checkbox'] {
	position: relative;
	display: inline-block;
	margin: 0px 3px 0px 0px;
	vertical-align: middle;
	opacity: 1;
	z-index: 0;
	appearance: checkbox;
	-webkit-appearance: checkbox;
	-moz-appearance: checkbox;
	vertical-align: baseline;
	height: auto;
	width: auto;
	font-size: 16px;
}
#brisk-script-manager .brisk-script-manager-controls {
	text-align: left;
}
#brisk-script-manager .brisk-script-manager-controls label {
	display: inline-block;
	margin: 0px 10px 0px 0px;
	width: auto;
	font-size: 12px;
}
#brisk-script-manager .brisk-script-manager-toolbar {
	bottom: 0px;
	box-sizing: content-box;
}
#brisk-script-manager .brisk-script-manager-toolbar-container {
	display: flex;
	align-items: center;
	justify-content: space-between;
	margin: 0px auto;
	height: 50px;
}
#brisk-script-manager input[type='submit'] {
	background: #3ca900;
	color: #ffffff;
	cursor: pointer;
	border: none;
	font-size: 14px;
	/*margin: 10px auto 0px auto;*/
	margin: 0px;
	/*padding: 15px 20px;*/
	padding: 0px 20px;
	height: 50px;
	line-height: 50px;
	width: 100%;
	border-radius: 0px;
	position: fixed;
    bottom: 0;
}
#brisk-script-manager input[type='submit']:hover {
	background: #5A93E0;
}
#script-manager-settings input[type='submit'] {
	float: left;
}
#brisk-script-manager input[type='submit'].pmsm-reset {
	width: 250px;
	float: none;
	background: #D11A2A;
	height: 35px;
    line-height: 35px;
    padding: 0px 10px;
    font-size: 12px;
    margin-bottom: 5px;
}
#brisk-script-manager input[type='submit'].pmsm-reset:hover {
	background: #c14552;
}
/* On/Off Toggle Switch */
#brisk-script-manager .brisk-script-manager-switch {
	position: relative;
	display: block;
	/*width: 48px;
	height: 28px;*/
	width: 76px;
	height: 40px;
	font-size: 1px;
}
#brisk-script-manager .brisk-script-manager-switch input[type='checkbox'] {
	display: block;
	margin: 0px;
}
#brisk-script-manager .brisk-script-manager-slider {
	position: absolute;
	cursor: pointer;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: #3ca900;
	-webkit-transition: .4s;
	transition: .4s;
}
#brisk-script-manager .brisk-script-manager-slider:before {
	position: absolute;
	content: '';
	/*height: 20px;
	width: 20px;
	right: 4px;
	bottom: 4px;*/
	width: 30px;
	top: 5px;
	right: 5px;
	bottom: 5px;
	background-color: white;
	-webkit-transition: .4s;
	transition: .4s;
}
#brisk-script-manager .brisk-script-manager-switch input:checked + .brisk-script-manager-slider {
	background-color: #D11A2A;
}
#brisk-script-manager .brisk-script-manager-switch input:focus + .brisk-script-manager-slider {
	box-shadow: 0 0 1px #D11A2A;
}
#brisk-script-manager .brisk-script-manager-switch input:checked + .brisk-script-manager-slider:before {
	/*-webkit-transform: translateX(-20px);
	-ms-transform: translateX(-20px);
	transform: translateX(-20px);*/
	-webkit-transform: translateX(-36px);
	-ms-transform: translateX(-36px);
	transform: translateX(-36px);
}

#brisk-script-manager .brisk-script-manager-slider:after {
	content:'ON';
	color: white;
	display: block;
	position: absolute;
	transform: translate(-50%,-50%);
	top: 50%;
	left: 27%;
	font-size: 10px;
	font-family: Verdana, sans-serif;
}

#brisk-script-manager .brisk-script-manager-switch input:checked + .brisk-script-manager-slider:after {  
	left: unset;
	right: 0%;
  	content:'OFF';
}

#brisk-script-manager .brisk-script-manager-assets-disabled p {
	margin: 20px 0px 0px 0px;
	text-align: center;
	padding: 10px 0px 0px 0px;
	border-top: 1px solid #f8f8f8;
}
/*Settings View*/
#script-manager-settings table th {
	width: 200px;
	vertical-align: top;
	border: none;
}
#script-manager-settings .switch {
  position: relative;
  display: inline-block;
  width: 48px;
  height: 28px;
  font-size: 1px;
}
#script-manager-settings .switch input {
  display: block;
  margin: 0px;
}
#script-manager-settings .slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}
#script-manager-settings .slider:before {
  position: absolute;
  content: '';
  height: 20px;
  width: 20px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}
#script-manager-settings input:checked + .slider {
  background-color: #2196F3;
}

#script-manager-settings input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}
#script-manager-settings input:checked + .slider:before {
  -webkit-transform: translateX(20px);
  -ms-transform: translateX(20px);
  transform: translateX(20px);
}
#jquery-message {
	font-size: 12px;
	font-style: italic;
	color: #27ae60;
	margin-top: 5px;
}
@media (max-width: 800px) {
	#brisk-script-manager {
		padding-left: 20px;
	}
	#brisk-script-manager-header {
		position: relative;
		top: 0px;
		width: 100%;
		overflow: hidden;
		margin-bottom: 20px;
	}
	#brisk-script-manager .brisk-script-manager-toolbar {
		left: 0px;
	}
}
</style>";