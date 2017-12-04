<!DOCTYPE html>
<html>
<head>
	<title>CASH CONTROL</title>
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
	<a href="{{route('index')}}">Home</a>
	<a href="{{route('caixa')}}">Caixa</a>
	<a href="{{route('lancamentos')}}">Lançamentos</a>
	<a href="{{url('lancamentos/atualiza')}}">Atualizar</a>
	<br><br>
	@if(session('caixa'))
		<h1>{{session('caixa.nome_caix')}}</h1>
	@endif
	@if(session('competencia'))
		<h3>{{session('competencia')}}</h3>
	@endif
	@if(session('msg'))
		<p>{{session('msg')}}</p>
	@endif
	@yield('conteudo')
</body>
</html>