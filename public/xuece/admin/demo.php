<?php
	$htmlData1 = '';
	$htmlData2 = '';
	if (!empty($_POST['content1'])) {
		if (get_magic_quotes_gpc()) {
			$htmlData1 = stripslashes($_POST['content1']);
		} else {
			$htmlData1 = $_POST['content1'];
		}
	}
	if (!empty($_POST['content2'])) {
		if (get_magic_quotes_gpc()) {
			$htmlData2 = stripslashes($_POST['content2']);
		} else {
			$htmlData2 = $_POST['content2'];
		}
	}

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>KindEditor PHP</title>
	<link rel="stylesheet" href="../kindeditor/themes/default/default.css" />
	<link rel="stylesheet" href="../kindeditor/plugins/code/prettify.css" />
	<script charset="utf-8" src="../kindeditor/kindeditor.js"></script>
	<script charset="utf-8" src="../kindeditor/lang/zh-CN.js"></script>
	<script charset="utf-8" src="../kindeditor/plugins/code/prettify.js"></script>
	<script>
				
		KindEditor.ready(function(K) {
				
			var editor1 = K.create('textarea[name="content1"]', {
				cssPath : '../kindeditor/plugins/code/prettify.css',
				uploadJson : '../kindeditor/php/upload_json.php',
				fileManagerJson : '../kindeditor/php/file_manager_json.php',
				allowFileManager : true,
				
			});
			var editor2 = K.create('textarea[name="content2"]', {
				
			});
			
		});
	</script>
</head>
<body>
	<?php echo $htmlData1; ?>
	<br/>
	<?php echo $htmlData2; ?>
	<form name="example" method="post" action="demo.php">
		<textarea name="content1" style="width:700px;height:300px;"><?php echo htmlspecialchars($htmlData1); ?></textarea>
		<textarea name="content2" style="width:700px;height:300px;"><?php echo htmlspecialchars($htmlData2); ?></textarea>
		<input type="submit" name="button" value="提交内容" /> (提交快捷键: Ctrl + Enter)
	</form>
</body>
</html>

