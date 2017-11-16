@extends('layout.template1')

@section('conteudo')
<div class="container">
	@foreach($caixas as $caixa)
		<a href="{{url('caixa/'.$caixa->id_caix)}}">>{{$caixa->nome_caix}} </a>
	@endforeach

	<h1>Novo Caixa</h1>
	
	<form action="{{url('caixa/novo')}}" method="POST">
		<input type="hidden" name="_token" value="{{csrf_token()}}">	
		<input type="text" name="nome_caix" placeholder="Nome" required>
		<input type="text" name="descricao_caix" placeholder="Descrição">
		<button value="submit">Criar</button>
	</form>	
</div>
@endsection