@extends('layout.template1')

@php
$sessionComp = explode('/',session('competencia'));
@endphp

@section('conteudo')
<div class="container" style="background-color: white">
	<h3>Despesas Fixas</h3>
	<table border="1">
		<tr>
			<th>Tipo</th>
			<th>Fixo</th>
			<th>Data</th>
			<th>Descrição</th>
			<th>Valor</th>
			<th>Cor</th>
			<th>Operação</th>
			<!-- <th>Fornecedor</th> -->
		</tr>
		@foreach($lancamentos as $lancamento)
		<tr style="background-color: {{$lancamento->cor_lanc}}">
			<td>{{$lancamento->tipo_lanc}}</td>
			<td>{{$lancamento->fixo_lanc?'Sim':'Não'}}</td>
			<td>{{$lancamento->data_lanc}}</td>
			<td>{{$lancamento->descricao_lanc}}</td>
			<td align="right">R$ {{number_format($lancamento->valor_lanc, 2, ',', '.')}}</td>
			<td><a href="{{url('lancamentos/excluir/'.$lancamento->id_lanc)}}">Excluir</a></td>
		</tr>
		@endforeach

		@if(($sessionComp[0]>=date('m') && $sessionComp[1]==date('Y')) || $sessionComp[1]>date('Y'))
		<tr>
			<form action="{{url('lancamentos/novo')}}" method="POST">
				<td>
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<select name="tipo_lanc">
						<option value="receita">Receita</option>
						<option value="despesa">Despesa</option>
					</select>
				</td>
				<td><input type="checkbox" name="fixo_lanc"></td>
				<td><input type="date" name="data_lanc" min="{{$sessionComp[1]}}-{{$sessionComp[0]}}-01" max="{{$sessionComp[1]}}-{{$sessionComp[0]}}-31" required></td>
				<td><input type="text" name="descricao_lanc" required></td>
				<td><input type="number" name="valor_lanc" placeholder="0,00" step="0.01" required></td>
				<td><input type="color" name="cor_lanc" value="#FFFFFF"></td>
				<td><input type="submit" name="enviar"></td>
			</form>
		</tr>
		@endif
		<tr>
			<td colspan="6" align="right">
				Saldo Total:
			</td>
			<td align="right">
				R$ {{number_format($saldo_total, 2, ',', '.')}}
			</td>
		</tr>
	</table>
</div>
@endsection