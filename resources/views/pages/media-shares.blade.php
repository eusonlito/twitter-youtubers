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
        @foreach ($stats as $stat)
        <tr>
            <td><a href="http://{{ $stat->domain }}" target="_blank">{{ $stat->domain }}</a></td>
            <td class="text-center">{{ $stat->count }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop