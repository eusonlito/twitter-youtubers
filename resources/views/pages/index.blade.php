@extends('layouts.html')

@section('body')

<table class="table table-hover">
    <tbody>
        <tr>
            <th>Profiles</th>
            <td class="text-center">{{ $profiles }}</td>
        </tr>

        <tr>
            <th>Followers</th>
            <td class="text-center">{{ $followers }}</td>
        </tr>

        <tr>
            <th>Followings Followers</th>
            <td class="text-center">{{ $followings }}</td>
        </tr>

        <tr>
            <th>Tweets</th>
            <td class="text-center">{{ $statuses }}</td>
        </tr>

        <tr>
            <th>Medias</th>
            <td class="text-center">{{ $medias }}</td>
        </tr>

        <tr>
            <th>Unique URLs</th>
            <td class="text-center">{{ $urls }}</td>
        </tr>

        <tr>
            <th>Total URL Shares</th>
            <td class="text-center">{{ $shares }}</td>
        </tr>
    </tbody>
</table>

@stop