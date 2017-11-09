<!DOCTYPE html>
<html>
<head>
	<title>CASH CONTROL</title>
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
	<br><br>
	@if(session('caixa'))
		<h1>{{session('caixa.nome_caix')}} , {{session('caixa.descricao_caix')}}</h1>
	@endif
	@yield('conteudo')
</body>
</html>