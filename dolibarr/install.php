<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
	<title>ติดตั้ง diGco ลงในเครื่องของคุณ</title>
	<style>
	html,body{margin:0px;padding:0px;}
	body{
		font-family:"Verdana";
		font-size:14px;
		text-align:center;
		background:#FAFAFA;
	}
	#wrapper{
		margin:0 auto;
		padding:10px;
		width:550px;
		margin-top:30px;
		text-align:left;
		border:1px solid #0070CF;
		-moz-border-radius:15px;
		background:#FFFFFF;
	}
	#wrapper h1{
		font-size:16px;
		color:darkgreen;
		border-bottom:1px solid #0070CF;
		margin:0px;
		padding:0px;
	}
	#wrapper p{
		text-align:justify;
		text-indent:20px;
	}
	p.footer{
		margin:2px;
		padding:1px;
		text-align:center;
		font-size:12px;
		color:#007BE4;
		text-shadow:0px 1px #E3E3E3;
	}
	p.footer a{
		color:#8D8D8D;
		text-decoration:none;
	}
	p.footer a:hover{
		color:#2C80C7;
	}
	#wrapper table{
		font-size:13px;
		margin-top:10px;
		padding:3px;
	}
	</style>
</head>
<body>
	<div id="wrapper">
		<h1>ยินดีต้อนรับเข้าสู่การติดตั้ง diGco</h1>
		<?php
		$get=isset($_GET['get'])?$_GET['get']:'1';
		switch($get){
			case "1";
			?>
			<p>เนื่องจากระบบไม่สามารถตรวจสอบไฟล์คอนฟิกที่จำเป็นต่อระบบ อาจจะเป็นไปได้ว่า คุณทำการติดตั้งเป็นครั้งแรก หรือ ไฟล์คอนฟิกที่สำคัญสูญหาย จึงจำเป็นที่จะต้องทำการติดตั้งใหม่อีกครั้งหนึ่ง ซึ่งข้อมูลดังต่อไปนี้เป็นข้อมูลสำคัญที่ไฟล์คอนฟิกของคุณ จำเป็นต้องพึงมี ดังรายละเอียดดังต่อไปนี้</p>
			<ul>
				<li>ชื่อ Host ของคุณ หากคุณติดตั้งในเครื่องของคุณเอง 99% จะเป็น localhost</li>
				<li>ชื่อ Username ของคุณ ในการเข้าใช้งาน MySql</li>
				<li>รหัสผ่าน ของคุณ ในการเข้าใช้งาน MySql</li>
				<li>ชื่อฐานข้อมูลของคุณ (แนะนำให้คุณสร้างฐานข้อมูลเปล่ารองรับไว้ก่อน)</li>
			</ul>
			<input type="button" value="คลิกถัดไป" onclick="location.href='?get=2';"/>
			<?php
			break;
			case "2":
				?>
				<form name="frminstall" method="POST" action="?get=3">
				<table border="0" width="500">
					<tr>
						<td>Host name : </td>
						<td><input type="text" name="txthost" value="localhost"/></td>
					</tr>
					<tr>
						<td>User name : </td>
						<td><input type="text" name="txtuser" value="root"/></td>
					</tr>
					<tr>
						<td>Password : </td>
						<td><input type="password" name="txtpassword" value=""/></td>
					</tr>
					<tr>
						<td>Database : </td>
						<td><input type="text" name="txtdb" value="digco"/></td>
					</tr>
					<tr>
						<td>Username Admin</td>
						<td><input type="text" name="txtadmin" value="admin"/></td>
					</tr>
					<tr>
						<td>Password Admin</td>
						<td><input type="password" name="txtpassadmin" value="1234"/> * 1234</td>
					</tr>
					<tr>
						<td>ชื่อ Blog ของคุณ</td>
						<td><input type="text" name="txttitle" value="Welcome To diGco Thai Free CMS" style="width:300px;"/></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" name="txtsubmit" value="ติดตั้งเดียวนี้"/></td>
					</tr>
				</table>
				</form>
				<?php
			break;
			case "3";
				$content="<?php\ndefine(\"DB_HOST\",\"".$_POST['txthost']."\");\n";
				$content.="define(\"DB_USER\",\"".$_POST['txtuser']."\");\n";
				$content.="define(\"DB_PASS\",\"".$_POST['txtpassword']."\");\n";
				$content.="define(\"DB_NAME\",\"".$_POST['txtdb']."\");\n";
				$content.="define(\"BASE_URL\",\"http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/\");\n";
				$content.="define(\"ADMIN_URL\",\"http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/dc_admin/\");\n?>";
				$fsave=@fopen("dc_inc/config.inc.php","w");
				fwrite($fsave,$content);
				fclose($fsave);

				if($fsave)
				{
					require('dc_inc/config.inc.php');
					require('dc_inc/class_db.inc.php');
					require('dc_inc/function.inc.php');

					$insert=_insert("INSERT INTO tb_users values('".$_POST['txtadmin']."','".md5($_POST['txtpassadmin'])."','administrator','ผู้ดูแลระบบ','1')");
					$bloghead=_insert("UPDATE tb_setting SET contents='".$_POST['txttitle']."' where subject='title'");

					?>
					<form name="frm" method="POST" action="dc_admin/index.php">
					<p>บันทึกข้อมูลเสร็จเรียบร้อย</p>
					<ul>
						<li>User name Admin : <?=$_POST['txtadmin']?></li>
						<li>Password Admin: <?=$_POST['txtpassadmin']?></li>
					</ul>
					<input type="hidden" name="title" value="<?=$_POST['txttitle']?>"/>
					<input type="submit" value="เริ่มเข้าใช้งาน"/>
					</form>
				<?php
				}
			break;
		}
		?>
	</div>
	<p class='footer'>&copy 2010 | diGco version 1.0 อนุญาติให้ใช้งานได้ฟรี เพียงแค่ระบุแหล่งที่มา</p>
	<p class='footer'>พัฒนา โดย นายบัณฑิต แสนคำภา MSN: kalamell@hotmail.com , Website : <a href="http://www.kalamell.com" title="kalamell.com">http://www.kalamell.com</a></p>
</body>
</html>
