@extends('layout.template1')

@section('conteudo')
<div class="container">
	<h3>Competência</h3>
	<div>
		<ul>
			@foreach($competencias as $comp)
			<li>
				<a href="{{url('competencia/'.$comp->id_comp)}}">
					{{$comp->mes_comp}}/{{$comp->ano_comp}}
				</a>
			</li>
			@endforeach
		</ul>

	</div>

	<form action="{{url('competencia/novo')}}" method="POST">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<select name="mes_comp">
			<option value="01">Jan</option>
			<option value="02">Fev</option>
			<option value="03">Mar</option>
			<option value="04">Abr</option>
			<option value="05">Mai</option>
			<option value="06">Jun</option>
			<option value="07">Jul</option>
			<option value="08">Ago</option>
			<option value="09">Set</option>
			<option value="10">Out</option>
			<option value="11">Nov</option>
			<option value="12">Dez</option>
		</select>
		/
		<select name="ano_comp">
			@for($i=date('Y');$i>=date('Y')-10;$i--)
			<option value="{{$i}}">{{$i}}</option>
			@endfor
		</select>
		<br><br>
		<label>
			Saldo Inicial: 
			<input type="number" name="saldoInicial_comp" placeholder="Saldo Inicial" value="0.00" step="0.01" min="0.00" 
			required>
		</label>
		<br><br>
		<button value="submit">Criar</button>
	</form>
</div>
@endsection