@extends('layouts.html')

@section('body')

<table class="table table-hover">
    <thead>
        <tr>
            <th class="fixed">URL</th>
            <th class="text-center">Shared</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($stats as $stat)
        <tr>
            <td class="fixed"><a href="{{ $stat->url }}" target="_blank">{{ $stat->url }}</a></td>
            <td class="text-center"><a href="{{ route('url', ['id' => $stat->id]) }}">{{ $stat->count }}</a></td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop