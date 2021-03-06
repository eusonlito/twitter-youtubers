@extends('layouts.html')

@section('body')

<table class="table table-hover">
    <thead>
        <tr>
            <th>Domain</th>
            <th class="text-center">Shared</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($stats as $row)
        <tr>
            <td><a href="http://{{ $row->domain }}" target="_blank">{{ $row->domain }}</a></td>
            <td class="text-center"><a href="{{ route('media', ['id' => $row->id]) }}">{{ $row->count }}</a></td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop