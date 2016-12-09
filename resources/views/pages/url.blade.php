@extends('layouts.html')

@section('body')

<div class="well">
    <h3><a href="{{ route('url-shares') }}">&laquo;</a> {{ $url->url }}</h3>
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
        @foreach ($statuses as $status)
        <tr>
            <td>{{ $status->text }}</td>
            <td class="nowrap"><a href="https://twitter.com/{{ $status->hash }}/status/{{ $status->id }}" target="_blank">{{ $status->created_at }}</a></td>
            <td class="text-center"><a href="{{ route('profile', ['id' => $status->profile_id]) }}">{{ $status->hash }}</a></td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop