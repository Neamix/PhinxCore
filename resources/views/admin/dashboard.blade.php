@extends('admin.layouts.app')

@section('content')
<div class="chart mt-4 container-fluid">
  
</div>
@endsection

@section('component_script')
<script src="{{ asset('admin/js/charts.js') }}"></script>
<script>
  charts('.tour','Tour',null,'area')
  charts('.hotel','Hotel',200)
  charts('.destination','Destination',200)
  charts('.blog','Blog',200)
</script>
@endsection