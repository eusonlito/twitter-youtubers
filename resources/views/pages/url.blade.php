@extends('layouts.html')

@section('body')

<div class="well">
    <h3><a href="#" class="back">&laquo;</a> {{ $url->url }}</h3>
</div>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Tweet</th>
            <th>Created at</th>
            <th>User</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($statuses as $row)
        <tr>
            <td>{{ $row->text }}</td>
            <td class="nowrap"><a href="https://twitter.com/{{ $row->hash }}/status/{{ $row->id }}" target="_blank">{{ $row->created_at }}</a></td>
            <td class="text-center"><a href="{{ route('profile', ['id' => $row->profile_id]) }}">{{ $row->hash }}</a></td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop