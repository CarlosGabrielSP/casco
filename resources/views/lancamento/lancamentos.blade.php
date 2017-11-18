@extends('layout.template1')

@section('conteudo')
<div class="container">
	<h3>Competência</h3>
	<table border="1">
		<tr>
			@foreach($competencias as $comp)
			<th>
				<a href="{{url('competencia/'.$comp->id_comp)}}">
					{{$comp->mes_comp}}/{{$comp->ano_comp}}
				</a>
			</th>
			@endforeach
			<th><a href="{{url('competencia/novo_proximo')}}"><strong>Novo</strong></a></th>
		</tr>
	</table>
</div>
@endsection