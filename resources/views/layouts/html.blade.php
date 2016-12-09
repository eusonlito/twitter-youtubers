<!DOCTYPE HTML>
<html lang="es">
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
        <link href="//getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet" />
        <script src="//code.jquery.com/jquery-2.2.4.min.js" type="text/javascript"></script>

        <style>
        .table td {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        </style>

        <script>
        jQuery(function ($) {
            $('#stats-form select').on('change', function(e) {
                $(this).closest('form').submit();
            });
        });
        </script>
    </head>

    <body>
        <div class="container">
            <div class="header clearfix">
                <nav>
                    <ul class="nav nav-pills pull-right">
                        <li role="presentation" class="active"><a href="{{ route('index') }}">Home</a></li>
                        <li role="presentation"><a href="https://github.com/eusonlito/twitter-youtubers" target="blank">About</a></li>
                    </ul>
                </nav>

                <h3 class="text-muted">Twitter + Youtubers</h3>
            </div>

            <div class="row marketing">
                <form id="stats-form" method="get">
                    <div class="form-group">
                        <select name="stat" class="form-control">
                            <option value="">Select Stat</option>
                            <option value="profile-shares" {{ $STAT === 'profile-shares' ? 'selected' : '' }}>TOP USERs SHARES</option>
                            <option value="url-shares" {{ $STAT === 'url-shares' ? 'selected' : '' }}>TOP URLs SHARES</option>
                            <option value="media-links" {{ $STAT === 'media-links' ? 'selected' : '' }}>TOP MEDIAs LINKS</option>
                            <option value="media-shares" {{ $STAT === 'media-shares' ? 'selected' : '' }}>TOP MEDIAs SHARES</option>
                        </select>
                    </div>
                </form>

                @yield('body')
            </div>
        </div>
    </body>
</html>
