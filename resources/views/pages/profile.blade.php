@extends('layouts.html')

@section('body')

<div class="well">
    <h3>
        <a href="#" class="back">&laquo;</a>
        {{ '@'.$profile->hash }}
        <small>{{ $profile->name }}</small>
    </h3>
</div>

<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#panel-tweets" aria-controls="panel-tweets" role="tab" data-toggle="tab">Tweets</a></li>
    <li role="presentation"><a href="#panel-links" aria-controls="panel-links" role="tab" data-toggle="tab">Links</a></li>
    <li role="presentation"><a href="#panel-medias" aria-controls="panel-medias" role="tab" data-toggle="tab">Medias</a></li>
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
                    @foreach ($statuses as $row)
                    <tr>
                        <td>{{ $row->text }}</td>
                        <td class="nowrap"><a href="https://twitter.com/{{ $profile->hash }}/status/{{ $row->id }}" target="_blank">{{ $row->created_at }}</a></td>
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
                        <th class="fixed fixed-66">URL Uniques</th>
                        <th class="text-center">Shared</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($urls as $row)
                    <tr>
                        <td class="fixed fixed-66"><a href="{{ $row->url }}" target="_blank">{{ $row->url }}</a></td>
                        <td class="text-center"><a href="{{ route('url', ['id' => $row->id]) }}"><i class="glyphicon glyphicon-th-list"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div role="tabpanel" class="tab-pane" id="panel-medias">
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="fixed fixed-66">Medias</th>
                        <th class="text-center">Shared</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($medias as $row)
                    <tr>
                        <td class="fixed fixed-66"><a href="http://{{ $row->domain }}" target="_blank">{{ $row->domain }}</a></td>
                        <td class="text-center"><a href="{{ route('media', ['id' => $row->id]) }}">{{ $row->count }}</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop