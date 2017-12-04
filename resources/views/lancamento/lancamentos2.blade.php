@extends('layout.template1')

@section('conteudo')
<div class="container" style="background-color: white">
	<table border="1">
		<tr>
			<th>tipo</th>
			<th>data</th>
			<th>descrição</th>
			<th>valor</th>
			<th>Operação</th>
			<!-- <th>Fornecedor</th> -->
		</tr>
		@foreach($lancamentos as $lancamento)
		<tr>
			<td>{{$lancamento->tipo_lanc}}</td>
			<td>{{$lancamento->data_lanc}}</td>
			<td>{{$lancamento->descricao_lanc}}</td>
			<td align="right">{{$lancamento->valor_lanc}}</td>
		</tr>
		@endforeach
		<tr>
			<form action="{{url('lancamento/novo')}}" method="POST">
				<td>
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<select name="tipo_lanc">
						<option value="receita">Receita</option>
						<option value="despesa">Despesa</option>
					</select>
				</td>
				<td><input type="date" name="data_lanc" required></td>
				<td><input type="text" name="descricao_lanc" required></td>
				<td><input type="number" name="valor_lanc" placeholder="0,00" step="0.01" min="0.01" required></td>
				<td><input type="submit" name="enviar"></td>
			</form>
		</tr>
	</table>
</div>
@endsection