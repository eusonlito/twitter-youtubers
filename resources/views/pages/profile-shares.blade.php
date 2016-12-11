@extends('layouts.html')

@section('body')

<table class="table table-hover">
    <thead>
        <tr>
            <th class="fixed fixed-33">Profile</th>
            <th class="fixed fixed-33">Name</th>
            <th class="text-center">Shared</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($stats as $row)
        <tr>
            <td class="fixed fixed-33"><a href="https://twitter.com/{{ $row->hash }}" target="_blank">{{ '@'.$row->hash }}</a></td>
            <td class="fixed fixed-33">{{ $row->name }}</td>
            <td class="text-center"><a href="{{ route('profile', ['id' => $row->id]) }}">{{ $row->count }}</a></td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop