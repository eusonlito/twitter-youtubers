@extends('layouts.html')

@section('body')

<table class="table table-hover">
    <thead>
        <tr>
            <th>Profile</th>
            <th>Name</th>
            <th class="text-center">Shared</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($stats as $stat)
        <tr>
            <td><a href="https://twitter.com/{{ $stat->hash }}" target="_blank">{{ '@'.$stat->hash }}</a></td>
            <td>{{ $stat->name }}</td>
            <td class="text-center">{{ $stat->count }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop