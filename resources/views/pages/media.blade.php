@extends('layouts.html')

@section('body')

<div class="well">
    <h3><a href="#" class="back">&laquo;</a> {{ $media->domain }}</h3>
</div>

<table class="table table-hover">
    <thead>
        <tr>
            <th class="fixed fixed-66">URL</th>
            <th class="text-center">Shared</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($urls as $row)
        <tr>
            <td class="fixed fixed-66"><a href="{{ $row->url }}" target="_blank">{{ $row->url }}</a></td>
            <td class="text-center"><a href="{{ route('url', ['id' => $row->id]) }}">{{ $row->count }}</a></td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop