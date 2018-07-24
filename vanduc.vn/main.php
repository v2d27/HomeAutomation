<?php
	include_once 'login_check.php';
	if (isset($_COOKIE["data"])) {
		if(login_check($_COOKIE["data"]) != "1")
		{
			header("Location: login.php");
		}
	}
	else
	{
		header("Location: login.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>IoT Project</title>
  <link rel="shortcut icon" href="image/homeiot.ico">
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
</head>
<style type="text/css">
*, *:before, *:after {
  margin: 0;
  /*padding: 0;*/
  box-sizing: border-box;
}

html, body {
  height: 100vh;
  -webkit-text-size-adjust:none;
}

body {
  font: 14px/1 'Open Sans', sans-serif;
  color: #555;
  background: #eee;
}

h1 {
  padding: 50px 0;
  font-weight: 400;
  text-align: center;
}

p {
  margin: 0 0 15px;
  line-height: 1.5;
}

.main {
  max-width: 600px;
  padding: 30px;
  padding-top: 30px;
  margin: 0 auto;
  background: #fff;
}

section {
  display: none;
  padding: 30px 15px 30px;
  border-top: 1px solid #22ac3c;
}

footer {
  text-align: center;
  background: #cac6fb;
  padding-top: 12px;
}

footer + label {
  font-size: 15px;
}

.tab input[type='radio'] {
  display: none;
}

.tab label#tabname{
  display: inline-block;
  margin: 0 0 -1px;
  padding: 15px 15px;
  font-weight: 500;
  text-align: center;
  color: #22ac3c;
  border: 1px solid transparent;
  cursor: pointer;
}

.tab label#tabname:before {
  color: #22ac3c;
  font-family: fontawesome;
  font-weight: normal;
  margin-right: 10px;
}

.tab label#tabname:hover {
  background: #eee;
  border-radius: 4px 4px 0 0;
  border-bottom: 1px transparent;
  color: #2e823e;
}

.tab input[type='radio']:checked + label#tabname{
  color: #555;
  border: 1px solid #22ac3c;
  border-bottom: 1px solid #fff;
  border-radius: 4px 4px 0 0;
}

.tab input[type='radio']:checked + label#tabname:hover {
  background: transparent;
  cursor: default;
}

#tab1:checked ~ #content1,
#tab2:checked ~ #content2,
#tab3:checked ~ #content3,
#tab4:checked ~ #content4 {
  display: block;
}

/*
@media screen and (max-width: 650px) {
  label {
    font-size: 0;
  }
  label:before {
    margin: 0;
    font-size: 10px;
  }
}

@media screen and (max-width: 400px) {
  label {
    padding: 0px;
  }
}*/
</style>

<!-- Style for Role Control -->
<style type="text/css">
.role label{
  cursor: pointer;
  text-indent: -9999px;
  width: 80px;
  height: 22px;
  background: grey;
  display: inline-block;
  border-radius: 20px;
  position: relative;
}
.role label:after {
  content: '';
  position: absolute;
  top: 2px;
  left: 2px;
  width: 18px;
  height: 18px;
  background: #fff;
  border-radius: 90px;
  transition: 0.2s;
}

.role input[type='checkbox'] {
  display: none;
  padding-top: 5px;
  font-size: 150%;
}

.role input[type='checkbox']:checked + label {
    background: #00cc00;
}

.role input:checked + label:after {
  left: calc(100% - 5px);
  transform: translateX(-100%);
}

.role label:active:after {
  width: 20px;
  text-align: center;
}

.items
{
  padding: 0px 70px;
  padding-top: 10px;
  padding-bottom: 18px;
  margin: 0px 60px 0px;
  border-radius: 1px;
  border-bottom: 1px solid #b9b9b9;
}

.items:hover
{
  background: #eee;
}

.text
{
    font-size: 150%;
}

.introduce
{
  cursor: pointer;
  background: #CAC6FB;
  text-align: center;
  padding-top: 5px;
}

.introduce label
{
  margin-left: 1px;
  font-size: 48px;
}


</style>


<script type="text/javascript">
  var data = [0, 0, 0, 0, 1];
  var gpio_click = 0;
  var gpio_state = 0;
  var toggle_hover = 0;
  var sec = 0;
  var _SYSTEM_START_TIME = 1502791987596; /*15.08.2017 00:00:00 from 1979*/
  var getJSON = function(url, callback) {
    var xhr;
    if(window.XMLHttpRequest) {
      xhr = new XMLHttpRequest();
    }
    else {
      xhr = new ActiveXObject('Microsoft.XMLHTTP');
    }  
    xhr.open('GET', url, true);
      /*xhr.responseType = 'json';*/
      xhr.onload = function() {
        var status = xhr.status;
        if (status == 200 && xhr.readyState == 4) {
          callback(null, xhr.response);
        } else {
          callback(status);
        }
      };
      xhr.send();
  };

  function onpageresize()
  {
    var width = document.body.clientWidth;
    var height = document.body.clientHeight;
    console.log(width + ", " + height);

    if (window.screen.availWidth < 800) { //tabet or moblie mode
      console.log("window:" + window.screen.availWidth + ", " + window.screen.availHeight);
    }

    if (width <= 550) {
      for (var i = 0; i < 16; i++) {
        document.getElementsByClassName("items")[i].style.padding = "10px 10px 18px 10px";
        document.getElementsByClassName("items")[i].style.margin = "0px 0px 0px";
      }
      for (var i = 0; i < 1; i++) {
        document.getElementsByClassName("main")[i].style.padding = "0px 0px 0px 0px";
        document.getElementsByClassName("main")[i].style.maxWidth = "initial";
      }
      
    }
    else
    {
      for (var i = 0; i < 16; i++) {
        document.getElementsByClassName("items")[i].style.padding = "10px 50px 18px 50px";
        document.getElementsByClassName("items")[i].style.margin = "0px 60px 0px";
      }
      for (var i = 0; i < 1; i++) {
        document.getElementsByClassName("main")[i].style.padding = "30px 30px 30px 30px";
        document.getElementsByClassName("main")[i].style.maxWidth = "600px";
      }
    }
  }

  function onpageload() {
    if (history.pushState) {
      history.pushState({}, "", "");
    }
    onpageresize();
    checking_login_state();
    update_ipaddress();
    update_database();
    update_title_color();
    update_alarm();
    process();
  }

  function update_alarm()
  {
    getJSON("/server/alarm_get.php", function(error, data)
    {
      if (error == null) {
        var json = JSON.parse(data);
        for(var i = 0; i < json.length; i++)
        {
            alarm_insert_item(json[i].role_id, json[i].on_time, json[i].off_time, json[i].active);
        }
        table_margin_footer();
        console.log("Alarm: " + data);
      }
      else
      {
        console.log('Getting data error..!' + data);
      }
    });
  }

  function  alarm_insert_item(role_id, on_time, off_time, active) {
    var table = document.getElementById("table_alarm");
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var cell = row.insertCell(0);
    cell.innerHTML += "<div>" + (rowCount) + "</div>";
    var cell = row.insertCell(1);
    cell.innerHTML += (role_id - parseInt(role_id/10)*10);
    var cell = row.insertCell(2);
    cell.innerHTML += (role_id < 10 ? 1 : parseInt(role_id/10));
    var cell = row.insertCell(3);
    cell.innerHTML += on_time.substring(0, 5);
    var cell = row.insertCell(4);
    cell.innerHTML += off_time.substring(0, 5);
    var cell = row.insertCell(5);
    if (active == "1") {
      cell.innerHTML += "Kích hoạt";
    }
    else
    {
      cell.innerHTML += "Dừng";
    }
    var cell = row.insertCell(6);
    cell.innerHTML += '<img src="image/setting.png" class="table_items_tool" onclick="table_setting_proc(this);"/>';
    cell.innerHTML += '<img src="image/delete.png" class="table_items_tool" onclick="table_delete_proc(this);"/>';
  }

  function update_title_color()
  {
    var arr_color = [
    'rgba(222, 27, 180, 0.58)',
    'rgba(93, 27, 222, 0.58)',
    'rgba(27, 132, 222, 0.58)',
    'rgba(27, 222, 195, 0.58)',
    'rgba(48, 222, 27, 0.58)',
    'rgba(219, 222, 27, 0.58)',
    'rgba(222, 81, 27, 0.58)' ];
    var random = Math.floor(Math.random() * (6 - 0 + 1)) + 0;

    document.getElementById("header").style.backgroundColor = arr_color[random];
    document.getElementById("footer").style.backgroundColor = arr_color[random];
  }

  function getCookie(name) {
      name = name + "=";
      var cookies = document.cookie.split(';');
      for(var i = 0; i <cookies.length; i++) {
          var cookie = cookies[i];
          while (cookie.charAt(0)==' ') {
              cookie = cookie.substring(1);
          }
          if (cookie.indexOf(name) == 0) {
              return cookie.substring(name.length,cookie.length);
          }
      }
      return "";
  }

  function checking_login_state()
  {
    var userdata = getCookie("data");
    if (userdata == "") {
      window.location.replace("login.php");
    }
    else {
      getJSON("/login_check.php?data=" + userdata, function(error, data) {
        if (error != null || data != 1) {
            window.location.replace("login.php");
          }
        else
        {
          $("user_id").innerHTML = getCookie("user_id");
        }
      });
    }
  }

  function update_ipaddress() {
    getJSON('/server/func.php?option=getipaddress', function(error, data)
    {
      if (error == null) {
        $("ipAddress").innerHTML = data;
      }
      else
      {
        $("ipAddress").innerHTML = "127.0.0.1";
      }
    });
  }

  function update_database()
  {
    load_DB();
    setTimeout('update_database()', 5000);
  }

  function process(){
    timer(); 
    setTimeout('process()',1000);
  }

  function timer()
  {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = m >= 10 ? m : "0" + m;
    s = s >= 10 ? s : "0" + s;
    $('currenttime').innerHTML = h + ":" + m + ":" + s;

    var runtime = parseInt((today.getTime() - _SYSTEM_START_TIME)/1000);
    var time = "";
    var hour = parseInt(runtime/3600);
    time = (hour >= 10 ? hour : "0" + hour);
    var min = parseInt((runtime - hour*3600)/60);
    time += ":" + (min >= 10 ? min : "0" + min);
    var secs = runtime - hour*3600 - min*60;
    time += ":" + (secs >= 10 ? secs : "0" + secs);
    $('runtime').innerHTML = time;

    var time = "";
    sec++;
    var hour = parseInt(sec/3600);
    time = (hour >= 10 ? hour : "0" + hour);
    var min = parseInt((sec - hour*3600)/60);
    time += ":" + (min >= 10 ? min : "0" + min);
    var secs = sec - hour*3600 - min*60;
    time += ":" + (secs >= 10 ? secs : "0" + secs);
    $('uptime').innerHTML = time;
  }

  function refresh(obj)
  {
    for(var i = 1; i <= 8; i++)
    {
      if (obj == 1) {
        $(i).checked = false; 
      }
      else
      {
        $(20+i).checked = false; 
      }
      
    }
    load_DB();
  }

  function load_DB()
  {
    getJSON('/server/get.php', function(err, data) {
    if (err != null) {
      console.log('Getting missing error. Error code ' + err);
    } 
    else 
    {
      // console.log('Your Json result is:  ' + data);
      var obj = JSON.parse(data);
      $(1).checked = (obj.role1 == 1 ? true : false);
      $(2).checked = (obj.role2 == 1 ? true : false);
      $(3).checked = (obj.role3 == 1 ? true : false);
      $(4).checked = (obj.role4 == 1 ? true : false);
      $(5).checked = (obj.role5 == 1 ? true : false);
      $(6).checked = (obj.role6 == 1 ? true : false);
      $(7).checked = (obj.role7 == 1 ? true : false);
      $(8).checked = (obj.role8 == 1 ? true : false);
      $("entry_id").innerHTML = obj.entry_id;
      $("last_get_times").innerHTML = obj.last_get_times;
      $("last_update_times").innerHTML = obj.last_update_times;

      $(21).checked = (obj.role21 == 1 ? true : false);
      $(22).checked = (obj.role22 == 1 ? true : false);
      $(23).checked = (obj.role23 == 1 ? true : false);
      $(24).checked = (obj.role24 == 1 ? true : false);
      $(25).checked = (obj.role25 == 1 ? true : false);
      $(26).checked = (obj.role26 == 1 ? true : false);
      $(27).checked = (obj.role27 == 1 ? true : false);
      $(28).checked = (obj.role28 == 1 ? true : false);
      $("entry_id_2").innerHTML = obj.entry_id2;
      $("last_get_times_2").innerHTML = obj.last_get_times2;
      $("last_update_times_2").innerHTML = obj.last_update_times2;

      $result = calc_esp8266_state(obj.last_get_times);
      $("esp8266_state").innerHTML = $result;
      $("status").innerHTML = $result;
      if ($result == "is online")
      {
        $("img_online").style.display = 'inline-block';
      }
      else
      {
        $("img_online").style.display = 'none';
      }

      $result = calc_esp8266_state(obj.last_get_times2)
      $("esp8266_state_2").innerHTML = $result;
      $("status2").innerHTML = $result;
      if ($result == "is online")
      {
        $("img_online2").style.display = 'inline-block';
      }
      else
      {
        $("img_online2").style.display = 'none';
      }
    }
    });
  }

  function calc_esp8266_state(time)
  {
    var today = new Date();
    var h = parseInt(today.getHours());
    var m = parseInt(today.getMinutes());
    var s = parseInt(today.getSeconds());

    var last_get_times = time;
    var hour = parseInt(last_get_times.substring(11, 13));
    var min =  parseInt(last_get_times.substring(14, 16));
    var sec =  parseInt(last_get_times.substring(17, 19));
    
    if (parseInt(today.getDate()) > parseInt(last_get_times.substring(0, 2)))
    {
      //fix day
      s += (parseInt(today.getDate())-parseInt(last_get_times.substring(0, 2)))*24*60*60;
    }

    sec = (h*3600+m*60+s - (hour*3600+min*60+sec));
    if (sec <= 25) {
      return "is online";
    }
    else
    {
      var unit = "second";
      if (sec >= 60) {
        unit = "minute";
        sec = parseInt(sec/60);
      }
      return "active " + sec + " "+ unit + (sec <= 1 ? "" : "s") + " ago";
    }
    return "n/a";
  }


  function select_all(id) {
    var url = "";
    if (id == 1) {
      url = "/server/update.php?esp8266=12&role1=1&role2=1&role3=1&role4=1&role5=1&role6=1&role7=1&role8=1";
    }
    else if(id == 2)
    {
      url = "/server/update.php?esp8266=1&role1=1&role2=1&role3=1&role4=1&role5=1&role6=1&role7=1&role8=1";
    }
    else
    {
      return console.log("Out of range device.");
    }

    var xhr;
    if(window.XMLHttpRequest) {
      xhr = new XMLHttpRequest();
    }
    else {
      xhr = new ActiveXObject('Microsoft.XMLHTTP');
    }  
    xhr.open('GET', url, false);
    xhr.send();

    console.log("Response: " + xhr.response);

    if (id == 1) {
      for (var i = 1; i <= 8; i++) {
        $(i).checked = true;
      }
    }
    else
    {
      for (var i = 1; i <= 8; i++) {
        $(20+i).checked = true;
      }
    }
  }

  function select_none(id) {
    var url = "";
    if (id == 1) {
      url = "/server/update.php?esp8266=12&role1=0&role2=0&role3=0&role4=0&role5=0&role6=0&role7=0&role8=0";
    }
    else if(id == 2)
    {
      url = "/server/update.php?esp8266=1&role1=0&role2=0&role3=0&role4=0&role5=0&role6=0&role7=0&role8=0";
    }
    else
    {
      return console.log("Out of range device.");
    }

    var xhr;
    if(window.XMLHttpRequest) {
      xhr = new XMLHttpRequest();
    }
    else {
      xhr = new ActiveXObject('Microsoft.XMLHTTP');
    }  
    xhr.open('GET', url, false);
    xhr.send();

    console.log("Response: " + xhr.response);

    if (id == 1) {
      for (var i = 1; i <= 8; i++) {
        $(i).checked = false;
      }
    }
    else
    {
      for (var i = 1; i <= 8; i++) {
        $(20+i).checked = false;
      }
    }
  }


  /*Function JavaScript*/
  function $(element_id) {
    return document.getElementById(element_id);
  }

  function slider(role_id) {
    var url = "/server/update.php?esp8266=12&role" + role_id + "=" + ($(role_id).checked == true ? "1" : "0");

    var xhr;
    if(window.XMLHttpRequest) {
      xhr = new XMLHttpRequest();
    }
    else {
      xhr = new ActiveXObject('Microsoft.XMLHTTP');
    }  
    xhr.open('GET', url, false);
    xhr.send();

    console.log("Response: " + xhr.response);
  }

  function slider2(role_id) {
    var url = "/server/update.php?esp8266=1&role" + role_id + "=" + ($(20+role_id).checked == true ? "1" : "0");

    var xhr;
    if(window.XMLHttpRequest) {
      xhr = new XMLHttpRequest();
    }
    else {
      xhr = new ActiveXObject('Microsoft.XMLHTTP');
    }  
    xhr.open('GET', url, false);
    xhr.send();

    console.log("Response: " + xhr.response);
  }


  function  sign_out() {
    document.cookie = 'user_id=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    document.cookie = 'data=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    window.location.replace("login.php");
  }

  function table_reset_list_number()
  {
    var table = $('table_alarm');
    var raws_length = table.rows.length;
    if (__Adding_Table_Items) {
      raws_length--;
    }
    if (raws_length >= 1) {
      for(var i = 1; i < raws_length; i++)
      {
        table.rows[i].cells[0].innerHTML = i;
      }
    }
  }

  function table_margin_footer() {
    var table = $('table_alarm');
    var height = table.rows.length*37;
    if (height >= 148) {
      $('content2').style.height = String(430+height-148) + 'px';
    }
  }

  function table_setting_proc(obj)
  {
    var rowSelected = obj.parentNode.parentNode.rowIndex;
    var table = $('table_alarm');
    var row_setting = table.rows.length;
    if (__Adding_Table_Items == 1) {
      table.deleteRow(table.rows.length-1); //Delete last raws
      __Adding_Table_Items = 0;
    }
    add_items();

    //update list number
    table.rows[table.rows.length-1].cells[0].innerHTML = rowSelected;

    //update role_id
    var obj = $('table_role_id');
    var str = table.rows[rowSelected].cells[1].innerHTML;
    for(var i = 0; i < obj.options.length; i++)
    {
      if(obj.options[i].text == str)
      {
        obj.selectedIndex = i;
        break;
      }
    }

    //update esp8266
    var obj = $('table_device');
    var str = table.rows[rowSelected].cells[2].innerHTML;
    for(var i = 0; i < obj.options.length; i++)
    {
      if(obj.options[i].text == str)
      {
        obj.selectedIndex = i;
        break;
      }
    }

    //update ontime
    var obj = $('table_ontime_hour');
    var str = table.rows[rowSelected].cells[3].innerHTML.substring(0, 2);
    for(var i = 0; i < obj.options.length; i++)
    {
      if(obj.options[i].text == str)
      {
        obj.selectedIndex = i;
        break;
      }
    }
    var obj = $('table_ontime_min');
    var str = table.rows[rowSelected].cells[3].innerHTML.substring(3, 5);
    for(var i = 0; i < obj.options.length; i++)
    {
      if(obj.options[i].text == str)
      {
        obj.selectedIndex = i;
        break;
      }
    }

    //update offtime
    var obj = $('table_offtime_hour');
    var str = table.rows[rowSelected].cells[4].innerHTML.substring(0, 2);
    for(var i = 0; i < obj.options.length; i++)
    {
      if(obj.options[i].text == str)
      {
        obj.selectedIndex = i;
        break;
      }
    }
    var obj = $('table_offtime_min');
    var str = table.rows[rowSelected].cells[4].innerHTML.substring(3, 5);
    for(var i = 0; i < obj.options.length; i++)
    {
      if(obj.options[i].text == str)
      {
        obj.selectedIndex = i;
        break;
      }
    }

    //update status
    var obj = $('table_status');
    var str = table.rows[rowSelected].cells[5].innerHTML;
    for(var i = 0; i < obj.options.length; i++)
    {
      if(obj.options[i].text == str)
      {
        obj.selectedIndex = i;
        break;
      }
    }

    return console.log("table_setting_proc: " + rowSelected);
  }

  function table_delete_proc(obj)
  {
    var rowIndex = obj.parentNode.parentNode.rowIndex;
    var role_id = $('table_alarm').rows[rowIndex].cells[1].innerHTML;
    var esp8266 = $('table_alarm').rows[rowIndex].cells[2].innerHTML;
    if (esp8266 == 2) {
      role_id = parseInt(esp8266)*10+parseInt(role_id);
    }
    getJSON("/server/alarm_delete.php?role_id=" + role_id, function(error, data)
    {
      if (error == null) {
        if (data == "1") {
          $('table_alarm').deleteRow(rowIndex);
          table_margin_footer();
          return table_reset_list_number();
        }
      }
      console.log('Can not delete data: ' + data);
    });
  }

  var __ADD_ITEM_PROC__Role = "";
  var __ADD_ITEM_PROC__esp8266 = "";
  var __ADD_ITEM_PROC__on_time = "";
  var __ADD_ITEM_PROC__off_time = "";
  var __ADD_ITEM_PROC__active = "";

  function add_items_proc()
  {
    var temp_id = $("table_role_id");
    var role_id = temp_id.options[temp_id.selectedIndex].text;

    temp_id = $("table_device");
    var device = temp_id.options[temp_id.selectedIndex].text;

    temp_id = $("table_ontime_hour");
    var ontime = temp_id.options[temp_id.selectedIndex].text;
    temp_id = $("table_ontime_min");
    ontime += ":" + temp_id.options[temp_id.selectedIndex].text;   

    temp_id = $("table_offtime_hour");
    var offtime = temp_id.options[temp_id.selectedIndex].text;
    temp_id = $("table_offtime_min");
    offtime += ":" + temp_id.options[temp_id.selectedIndex].text;   

    temp_id = $("table_status");
    var status = temp_id.options[temp_id.selectedIndex].value;

    __ADD_ITEM_PROC__role_id = role_id;
    __ADD_ITEM_PROC__esp8266 = device;
    __ADD_ITEM_PROC__on_time = ontime;
    __ADD_ITEM_PROC__off_time = offtime;
    __ADD_ITEM_PROC__active = temp_id.options[temp_id.selectedIndex].text;

    var uri = "/server/alarm_update.php?esp8266=" + device 
            + "&role_id=" + role_id
            + "&ontime=" + ontime
            + "&offtime=" + offtime
            + "&status=" + status;

    getJSON(uri, function(error, data)
    {
      if (error == null) {
        if (data == "1") {
          var table = $("table_alarm");
          table.deleteRow(table.rows.length-1); //delete last add row
          var rows = table.insertRow(table.rows.length);

          rows.insertCell(0).innerHTML = table.rows.length;
          rows.insertCell(1).innerHTML = __ADD_ITEM_PROC__role_id;
          rows.insertCell(2).innerHTML = __ADD_ITEM_PROC__esp8266;
          rows.insertCell(3).innerHTML = __ADD_ITEM_PROC__on_time;
          rows.insertCell(4).innerHTML = __ADD_ITEM_PROC__off_time;
          rows.insertCell(5).innerHTML = __ADD_ITEM_PROC__active;
          rows.insertCell(6).innerHTML = '<img src="image/setting.png" class="table_items_tool" onclick="table_setting_proc(this);"><img src="image/delete.png" class="table_items_tool" onclick="table_delete_proc(this);">';
          __Adding_Table_Items = 0;
          return table_reset_list_number();
        }
        else if (data == "2") {
          var table = $('table_alarm');
          table.deleteRow(table.rows.length-1); //delete last add row
          for(var i = 1; i < table.rows.length; i++)
          {
            if(table.rows[i].cells[1].innerHTML == __ADD_ITEM_PROC__role_id)
            {
              if(table.rows[i].cells[2].innerHTML == __ADD_ITEM_PROC__esp8266)
              {
                table.rows[i].cells[3].innerHTML = __ADD_ITEM_PROC__on_time;
                table.rows[i].cells[4].innerHTML = __ADD_ITEM_PROC__off_time;
                table.rows[i].cells[5].innerHTML = __ADD_ITEM_PROC__active;

                __Adding_Table_Items = 0;
                return ;
              }
            }
          }
        }
      }
      console.log("add_items_proc: " + uri);
      console.log("Error: " + data);
    });
  }

  var __Adding_Table_Items = 0;


  function add_items()
  {
    if (__Adding_Table_Items == 0) {
      __Adding_Table_Items = 1;
    }
    else if (__Adding_Table_Items == 1) { 
      return add_items_proc();
    }
    else {
      return;
    }
    table_margin_footer();

    var table = document.getElementById("table_alarm");
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    var cell = row.insertCell(0);
    cell.innerHTML += "<div>" + (rowCount) + "</div>";
    var cell = row.insertCell(1);
    var text = '<select id="table_role_id">';
    for(var i = 1; i <= 8; i++)
    {
      text += '<option>' + i + '</option>';
    }
    cell.innerHTML += text + '</select>';
    var cell = row.insertCell(2);
    cell.innerHTML += '<select id="table_device"> <option>1</option> <option>2</option></select>';
    var cell = row.insertCell(3);
    var temp_hour = "";
    for(var i = 0; i < 24; i++)
    {
      if (i < 10) {
        temp_hour += '<option>0' + i + '</option>';
      }
      else
      {
        temp_hour += '<option>' + i + '</option>';
      }
    }
    var temp_min = "";
    for(var i = 0; i < 60; i+=5)
    {
      if (i < 10) {
        temp_min += '<option>0' + i + '</option>';
      }
      else
      {
        temp_min += '<option>' + i + '</option>';
      }
    }
    cell.innerHTML += '<select id="table_ontime_hour">' + temp_hour + '</select>';
    cell.innerHTML += '<div style="margin-left:3px; margin-right:3px; display:inline-block; font-weight: bold;">:</div>';
    cell.innerHTML += '<select id="table_ontime_min">' + temp_min + '</select>';
    var cell = row.insertCell(4);
    cell.innerHTML += '<select id="table_offtime_hour">' + temp_hour + '</select>';
    cell.innerHTML += '<div style="margin-left:3px; margin-right:3px; display:inline-block; font-weight: bold;">:</div>';
    cell.innerHTML += '<select id="table_offtime_min">' + temp_min + '</select>';
    var cell = row.insertCell(5);
    cell.innerHTML += '<select id="table_status">  <option value="1">Kích hoạt</option>  <option value="0">Dừng</option></select>';
    var cell = row.insertCell(6);
    cell.innerHTML += '<img src="image/ok.png" class="table_items_tool" onclick="add_items_proc()"/>';
    cell.innerHTML += '<img src="image/delete.png" class="table_items_tool" onclick="this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode); __Adding_Table_Items = 0;"/>';
  }


</script>

<style type="text/css">
.title
{
  height: 40px;
  padding-left: 30px;
  padding-right: 30px;
  padding-top: 5px;
  padding-bottom: 5px;
  max-width: 600px;
  margin: 0 auto;
  background: #fff;
  display: block;
}
.user
{
  float: right;
  font-size: 14px;
  display: inline-block;
}

.title_text
{
  vertical-align: -webkit-baseline-middle;
  font-size: 14px;
}

/*

#text_user
{
  vertical-align: text-top;
  text-align: center;
}

#img_user
{
  margin-left: 30px;
}
*/
#sign_out
{
  cursor: pointer; 
  color: #2e823e; 
  display: inline-block;
  text-align: center;
}

#sign_out:hover
{
  text-decoration: underline;
}

.role_panel
{
  height: 40px;
  display: block;
  padding: 10px, 20px;
  text-align: center;
}

.role_panel #item:hover
{
  background: #eee;
  border: 1px solid #ddd;
}

.role_panel #item
{
  display: inline-block;
  cursor: pointer;
  width: 36px;
  height: 36px;
  padding: 5px;
}


.table_title
{
  background: #22ac3c;
  text-align: center;
  color: #fff;
  height: 30px;
  padding: 8px;
}

.table_add 
{
  cursor: pointer;
  background: #7e867f;
  text-align: center;
  color: #fff;
  height: 30px;
  padding: 8px;
}

.table_add:hover
{
  background-color: #545454;
}

.table_items_tool
{
  cursor: pointer;
  width: 24px;
  height: 24px;
  margin-right: 5px;
}

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

th {
    border: 1px solid #dddddd;
    text-align: center;
    padding: 8px;
}

td {
    border: 1px solid #dddddd;
    text-align: center;
    padding: 0px;
    padding-top: 5px;
    padding-bottom: 5px;
}

/*
tr:nth-child(even) {
    background-color: #dddddd;
}
*/
</style>

<body onload="onpageload()" onresize="onpageresize()">
  <div class="introduce" onclick="window.location.reload();" id="header">
    <img src="image/Streamline-18-512.png" alt="name" width=60 height=60 style="margin-left: 40px;" />
    <label style="color: #0072FF; margin-left: 20px; cursor: pointer;">I</label>
    <label style="color: #17C91B; cursor: pointer;";>o</label>
    <label style="color: #0072FF; cursor: pointer;">T</label>
    <label style="font-size: 32px; cursor: pointer;"> Project</label>
  </div>



  <span class="title" >
    <span class="title_text">
      Quản lý mọi thiết bị ở nhà bạn dù bạn ở bất cứ nơi đâu!
    </span>
    <span class="user">
      <img src="image/images.png" width="24" height="24" id="img_user" style="    vertical-align: -webkit-baseline-middle;"></img>
      <span style="    vertical-align: -webkit-baseline-middle;"><a id="user_id">N.A</a> • </span>
      <a onclick="sign_out()" id="sign_out" style="    vertical-align: -webkit-baseline-middle;">Đăng xuất</a>
    </span>
  </span>


  <div class="main">

    <span class="tab">
      <input id="tab1" type="radio" name="tabs" checked>
      <label for="tab1" id="tabname">Điều khiển</label>
        
      <input id="tab2" type="radio" name="tabs">
      <label for="tab2" id="tabname">Hẹn giờ</label>
        
      <input id="tab3" type="radio" name="tabs">
      <label for="tab3" id="tabname">Kết nối</label>
        
      <input id="tab4" type="radio" name="tabs">
      <label for="tab4" id="tabname">Thông tin</label>

  
      <section id="content1">
        <!-- Role o ngoai quan ======================================= -->
        <p class="text" style="text-align: center;">Role ngoài quán
          <img src="image/online.png" width="10" height="10" style=" margin-top: 10px;" id="img_online">
          <a id="status" style="display: inline-block; font-size: 12px;">pending.</a>
        </p>
        <div class="role_panel">
          <img id="item" src="image/select_all.png" onclick="select_all(1)"></img>
          <img id="item" src="image/select_none.png" onclick="select_none(1)"></img>
          <img id="item" src="image/Refresh-icon.png" onclick="refresh(1)"></img>
        </div>
          

        <span class="role">
          <div class="items">
              <input type="checkbox" id="1" onclick="slider(1)">1. Tạp hoá cổng sau</input>
              <label for="1" id="toggle" style="float: right; margin-right: 30px;">Toggle</label>
          </div>
          <div class="items">
              <input type="checkbox" id="2" onclick="slider(2)">2. Tạp hoá gian giữa</input>
              <label for="2" id="toggle" style="float: right; margin-right: 30px;">Toggle</label>
          </div>
          <div class="items">
              <input type="checkbox" id="3" onclick="slider(3)">3. Thiết bị số 3</input>
              <label for="3" id="toggle" style="float: right; margin-right: 30px;">Toggle</label>
          </div>
          <div class="items">
              <input type="checkbox" id="4" onclick="slider(4)">4. Thiết bị số 4</input>
              <label for="4" id="toggle" style="float: right; margin-right: 30px;">Toggle</label>
          </div>
          <div class="items">
              <input type="checkbox" id="5" onclick="slider(5)">5. Bóng ở quán nước</input>
              <label for="5" id="toggle" style="float: right; margin-right: 30px;">Toggle</label>
          </div>
          <div class="items">
              <input type="checkbox" id="6" onclick="slider(6)">6. Bóng ở đường đi</input>
              <label for="6" id="toggle" style="float: right; margin-right: 30px;">Toggle</label>
          </div>
          <div class="items">
              <input type="checkbox" id="7" onclick="slider(7)">7. Bóng trước tạp hoá</input>
              <label for="7" id="toggle" style="float: right; margin-right: 30px;">Toggle</label>
          </div>
          <div class="items">
              <input type="checkbox" id="8" onclick="slider(8)">8. Bóng quầy thu ngân</input>
              <label for="8" id="toggle" style="float: right; margin-right: 30px;">Toggle</label>
          </div>

          <div style="margin-top: 25px; text-align: center; font-size: 12px;">
            <p>Điều khiển <a id="entry_id"></a> lượt. Dữ liệu tự động cập nhật 5 giây một lần.</p>
          </div>
        </span>

        <!-- Role o trong nha ======================================= -->
        <p class="text" style="text-align: center;">Role trong nhà
          <img src="image/online.png" width="10" height="10" style=" margin-top: 10px;" id="img_online2">
          <a id="status2" style="display: inline-block; font-size: 12px;">pending.</a>
        </p>
        <div class="role_panel">
          <img id="item" src="image/select_all.png" onclick="select_all(2)"></img>
          <img id="item" src="image/select_none.png" onclick="select_none(2)"></img>
          <img id="item" src="image/Refresh-icon.png" onclick="refresh(2)"></img>
        </div>


        <span class="role">
          <div class="items">
              <input type="checkbox" id="21" onclick="slider2(1)">1. Bóng trước nhà</input>
              <label for="21" id="toggle" style="float: right; margin-right: 30px;">Toggle</label>
          </div>
          <div class="items">
              <input type="checkbox" id="22" onclick="slider2(2)">2. Bóng bên hồi L</input>
              <label for="22" id="toggle" style="float: right; margin-right: 30px;">Toggle</label>
          </div>
          <div class="items">
              <input type="checkbox" id="23" onclick="slider2(3)">3. Thiết bị số 3</input>
              <label for="23" id="toggle" style="float: right; margin-right: 30px;">Toggle</label>
          </div>
          <div class="items">
              <input type="checkbox" id="24" onclick="slider2(4)">4. Thiết bị số 4</input>
              <label for="24" id="toggle" style="float: right; margin-right: 30px;">Toggle</label>
          </div>
          <div class="items">
              <input type="checkbox" id="25" onclick="slider2(5)">5. Thiết bị số 5</input>
              <label for="25" id="toggle" style="float: right; margin-right: 30px;">Toggle</label>
          </div>
          <div class="items">
              <input type="checkbox" id="26" onclick="slider2(6)">6. Thiết bị số 6</input>
              <label for="26" id="toggle" style="float: right; margin-right: 30px;">Toggle</label>
          </div>
          <div class="items">
              <input type="checkbox" id="27" onclick="slider2(7)">7. Thiết bị số 7</input>
              <label for="27" id="toggle" style="float: right; margin-right: 30px;">Toggle</label>
          </div>
          <div class="items">
              <input type="checkbox" id="28" onclick="slider2(8)">8. Thiết bị số 8</input>
              <label for="28" id="toggle" style="float: right; margin-right: 30px;">Toggle</label>
          </div>
          <div style="margin-top: 25px; text-align: center; font-size: 12px;">
            <p>Điều khiển <a id="entry_id_2"></a> lượt. Dữ liệu tự động cập nhật 5 giây một lần.</p>
          </div>
        </span>
      </section>
        
      <section id="content2" style="  height: 430px;">
        <div class="table_title">Danh sách thiết bị hẹn giờ</div>
        <table id="table_alarm">
          <tr>
            <th>#</th>
            <th>Role</th>
            <th>Esp8266</th>
            <th>Thời gian bật</th>
            <th>Thời gian tắt</th>
            <th>Trạng thái</th>
            <th>Công cụ</th>
          </tr>
        </table>
        <div class="table_add" onclick="add_items();"><img src="image/add-512.png" width="16" height="16" align="center" style="margin-right: 5px;">Thêm mới</div>
        <div style="margin-top: 30px;">Lưu ý: Sau khi 'Kích hoạt' chế độ hẹn giờ cho một thiết bị thì hệ thống tự động bật role nếu đang tắt và sẽ hoạt động tương tự ở ngày tiếp theo. Nếu bạn muốn huỷ hẹn giờ thì có thể để trạng thái về 'Dừng' hoặc xoá chế độ hẹn giờ bằng cách nhấn vào nút xoá màu đỏ ở cột công cụ tương ứng với thiết bị bạn muốn huỷ.</div>
      </section>
        
      <section id="content3" style="  height: 430px;">
        <ul>
          <li>
            <p>ESP8266 1: <a id="esp8266_state"></a>.</p>
          </li>
          <li>
            <p>ESP8266 2: <a id="esp8266_state_2"></a>.</p>
          </li>
          <li>
            <p>Địa chỉ IP kết nối của bạn: <a id="ipAddress"></a>.</p>
          </li>
          <li>
            <p>Thời gian truy cập: <a id="uptime">00:00:00</a>.</p>
          </li>
          <li>
            <p>Thời gian hoạt động của máy chủ: <a id="runtime">00:00:00</a>.</p>
          </li>
          <li>
            <p>Giờ hiện tại: <a id="currenttime">00:00:00</a>.</p>
          </li>

          <li>
            <p>Lần esp8266 1 truy cập cuối cùng: <a id="last_get_times"></a>.</p>
          </li>
          <li>
            <p>Lần esp8266 2 truy cập cuối cùng: <a id="last_get_times_2"></a>.</p>
          </li>
          <li>
            <p>Thời gian cập nhật cơ sở dữ liệu esp8266 1 sớm nhất: <a id="last_update_times"></a>.</p>
          </li>
          <li>
            <p>Thời gian cập nhật cơ sở dữ liệu esp8266 2 sớm nhất: <a id="last_update_times_2"></a>.</p>
          </li>
        </ul>
      </section>
        
      <section id="content4" style="  height: 430px;">
        <ul>
          <li>
            <p>Tên dự án: Ngôi nhà tự động.</p>
          </li>
          <li>
            <p>Tác giả dự án: Vũ Văn Đức.</p>
          </li>
          <li>
            <p>Năm thực hiện: @2017.</p>
          </li>
          <li>
            <p>Ngày đưa vào hoạt động chính thức: 15/08/2017.</p>
          </li>
          <li>
            <p>Khách hàng: Tạp hoá Hoan Hường.</p>
          </li>
          <li>
            <p>Tình trạng bản quyền: Miễn phí trọn đời.</p>
          </li>
          <li>
            <p>Thông tin liên hệ: <a href="mailto:ducduc08@gmail.com">Hercules email</a>.</p>
          </li>
        </ul>      
      </section>  
    </span> 
  </div>

<footer id="footer">
  <label>Home Automation Project 2017</label><br><br>
</footer>

</body>

