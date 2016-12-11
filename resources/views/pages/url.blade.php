@extends('layouts.html')

@section('body')

<div class="well">
    <h3><a href="#" class="back">&laquo;</a> {{ $url->url }}</h3>
</div>

<div class="row row-table-head hidden-xs">
    <div class="col-sm-6">Tweet</div>
    <div class="col-xs-6 col-sm-3">Created at</div>
    <div class="col-xs-6 col-sm-3 text-center">User</div>
</div>

@foreach ($statuses as $row)
<div class="row row-table-body">
    <div class="col-sm-6 row-table-body-12">{{ $row->text }}</div>
    <div class="col-xs-6 col-sm-3 nowrap"><a href="https://twitter.com/{{ $row->hash }}/status/{{ $row->id }}" target="_blank">{{ $row->created_at }}</a></div>
    <div class="col-xs-6 col-sm-3 text-center"><a href="{{ route('profile', ['id' => $row->profile_id]) }}">{{ $row->hash }}</a></div>
</div>
@endforeach

@stop