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
        @foreach ($stats as $row)
        <tr>
            <td><a href="https://twitter.com/{{ $row->hash }}" target="_blank">{{ '@'.$row->hash }}</a></td>
            <td>{{ $row->name }}</td>
            <td class="text-center"><a href="{{ route('profile', ['id' => $row->id]) }}">{{ $row->count }}</a></td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop