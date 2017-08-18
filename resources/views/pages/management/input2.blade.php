@extends('master.master')

@section('content')
<form method="post" action="{{url('')}}/management/graph2">
	<div class="row">
		<div class="form-group col-md-5">
			<input type="text" class="form-control inputs" name="tanggal" required/>
		</div>
		<div class="form-group col-md-5">
			<button class="btn btn-success" style="margin-left: -15px" type="submit">Pilih</button>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-5">
			<label style="color:red">*Sistem akan otomatis menentukan minggu dari tanggal yang diinput</label>
		</div>
	</div>
	{{ csrf_field() }}
</form>
<script>
	$(function() {
		$('input[name="tanggal"]').daterangepicker({
			singleDatePicker: true,
			locale: {
				format:'YYYY-MM-DD',
			}
		});
	});
</script>
@stop