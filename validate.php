<html>
<head>
	<meta charset="UTF-8">
	<title>XML 검증</title>
	<link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/materia/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-crimson">
	<div class="container">
		<a class="navbar-brand" href="index.html">문어 자료 정보 관리 도구</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarColor01">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="index.html">대문</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="inputs">정보 신규입력/갱신</a>
					<div class="dropdown-menu" aria-labelledby="inputs">
						<a class="dropdown-item" href="input.html">원전 사용 승인 / 서지 정보 입력</a>
						<a class="dropdown-item" href="input2.html">원시 말뭉치 파일 정보 입력</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="viewer.html">인덱스 리스트 뷰어</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="exports">내보내기</a>
					<div class="dropdown-menu" aria-labelledby="exports">
						<a class="dropdown-item" href="export_json.php">JSON(note 포함)</a>
						<a class="dropdown-item" href="export_xml.php">XML(note 포함)</a>
						<a class="dropdown-item" href="export_csv.php">CSV(note 제외)</a>
					</div>
				</li>
			</ul>
			<?php
			session_start();
			if(!isset($_SESSION["user_id"]))echo('
		<form class="form-inline my-2 my-lg-0 navbar-nav" method="post" action="login.php">
			<input class="form-control mr-sm-2 nav-link active" type="text" placeholder="아이디" style="width: 70px" name="id" required>
			<input class="form-control mr-sm-2 nav-link active" type="password" placeholder="비밀번호" style="width: 70px" name="password" required>
			<button class="btn btn-secondary my-2 my-sm-0" type="submit">로그인</button>
		</form>');
			else echo('
		<form class="form-inline my-2 my-lg-0 navbar-nav" action="logout.php">
			<a class="nav-link" href="pwchange.html">'.$_SESSION["user_name"].'님</a>
			<button class="btn btn-secondary my-2 my-sm-0" type="submit">로그아웃</button>
		</form>');
			?>
		</div>
	</div>
</nav>
<div class="container">
<?php
$cnt=count($_FILES["new_file"]["tmp_name"]);
if(isset($_POST["fileFrom"])&&$_POST["fileFrom"]>0)
{
	Header("Location: validate.html?under_construction");
	exit();
}
else if($cnt==0)
{
	Header("Location: validate.html?not_uploaded");
	exit();
}
libxml_use_internal_errors(true);
for($i=0;$i<$cnt;++$i)
{
	$xml=simplexml_load_file($_FILES["new_file"]["tmp_name"][$i]);
	if($xml==false)
	{
		$errors="";
		foreach(libxml_get_errors() as $error)$errors.="<br>".$error->message;
		echo('
<div class="alert alert-dismissible alert-danger">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4 class="alert-heading">['.$_FILES["new_file"]["name"][$i].'] 검증에 실패했습니다.</h4>
	<p class="mb-0">XML에 오류가 있습니다:'.$errors.'</p>
</div>');
	}
	else echo('
<div class="alert alert-dismissible alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4 class="alert-heading">['.$_FILES["new_file"]["name"][$i].'] 검증에 성공했습니다.</h4>
	<p class="mb-0">XML에 오류가 없습니다.</p>
</div>');
}
?>
<button type="submit" class="btn btn-primary" onclick="window.location.href='validate.html'">돌아가기</button>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>
