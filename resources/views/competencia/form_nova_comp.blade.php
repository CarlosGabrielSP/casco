@extends('layout.template1')

@section('conteudo')
<div class="container">
	<h3>Competência</h3>

	<form action="{{url('competencia/novo')}}" method="POST">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<select name="mes_comp">
			<option value="01" {{date('m')=="01"?"selected":''}}>Jan</option>
			<option value="02" {{date('m')=="02"?"selected":''}}>Fev</option>
			<option value="03" {{date('m')=="03"?"selected":''}}>Mar</option>
			<option value="04" {{date('m')=="04"?"selected":''}}>Abr</option>
			<option value="05" {{date('m')=="05"?"selected":''}}>Mai</option>
			<option value="06" {{date('m')=="06"?"selected":''}}>Jun</option>
			<option value="07" {{date('m')=="07"?"selected":''}}>Jul</option>
			<option value="08" {{date('m')=="08"?"selected":''}}>Ago</option>
			<option value="09" {{date('m')=="09"?"selected":''}}>Set</option>
			<option value="10" {{date('m')=="10"?"selected":''}}>Out</option>
			<option value="11" {{date('m')=="11"?"selected":''}}>Nov</option>
			<option value="12" {{date('m')=="12"?"selected":''}}>Dez</option>
		</select>
		/
		<select name="ano_comp">
			@for($i=date('Y')+5;$i>=date('Y')-5;$i--)
			<option value="{{$i}}" {{date('Y')==$i?"selected":''}}>{{$i}}</option>
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