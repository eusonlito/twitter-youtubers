@extends('layouts.html')

@section('body')

<table class="table table-hover">
    <thead>
        <tr>
            <th>URL</th>
            <th class="text-center">Shared</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($stats as $stat)
        <tr>
            <td><a href="{{ $stat->url }}" target="_blank">{{ $stat->url }}</a></td>
            <td class="text-center">{{ $stat->count }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop