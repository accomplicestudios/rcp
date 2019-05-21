<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?=$this->config->item('SITE_TITLE')?></title>
	<link rel="stylesheet" href="/css/reset.css" type="text/css" media="all" />
	<link rel="stylesheet" href="/css/styles.css" type="text/css" media="all" />
	<script type="text/javascript">
		function init() {
			document.getElementById('username').focus();
		}
	</script>
</head>
<body onload="init()">
<div id="container">

	<div id="header">
		<div class="ileft">
			<div style="padding-top: 40px"><img src="/images/RCP_Logo_Wht.svg" height="50" alt="" /></div>
		</div>

		<div class="iright">
			<img src="/images/Login_ContentManagementSystem.png" width="265" height="100" alt="" />
		</div>
	</div>

	<div id="content">

		<div class="iright">
			<img src="/images/Login_Login.png" width="" height="" alt="" />
			<form method="post" action="" id="loginform">

				<p>
				   <span>Username</span>
				   <input type="text" name="username" id="username" />
				</p>

				<p>
				   <span>Password</span>
				   <input type="password" name="password" />
				</p>
			<input type="submit" style="width: 0; height: 0; border: 0; position: absolute; left: -1000px; top: -1000px;" />
			</form>
			<a href="javascript: " onclick="document.getElementById('loginform').submit()" class="isubmit"></a>
		</div>
	</div>

	<div id="footer">
		<div class="iright">
			<!--<img src="/images/Footer_SupafrenzLogo.png" width="173" height="40" alt="" />-->
		</div>
	</div>



</div>
</body>
</html>
