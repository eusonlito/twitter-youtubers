@extends('layouts.html')

@section('body')

<div class="well">
    <h3>
        <a href="{{ route('profile-shares') }}">&laquo;</a>
        {{ '@'.$profile->hash }}
        <small>{{ $profile->name }}</small>
    </h3>
</div>

<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#panel-tweets" aria-controls="panel-tweets" role="tab" data-toggle="tab">Tweets</a></li>
    <li role="presentation"><a href="#panel-links" aria-controls="panel-links" role="tab" data-toggle="tab">Links</a></li>
</ul>

  <!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="panel-tweets">
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tweet</th>
                        <th class="nowrap">Date</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($statuses as $status)
                    <tr>
                        <td>{{ $status->text }}</td>
                        <td class="nowrap">{{ $status->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div role="tabpanel" class="tab-pane" id="panel-links">
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="fixed">URL Uniques</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($urls as $url)
                    <tr>
                        <td class="fixed"><a href="{{ $url->url }}" target="_blank">{{ $url->url }}</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop