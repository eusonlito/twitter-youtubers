<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
        <link href="//getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet" />
        <link href="{{ url('css/styles.css') }}" rel="stylesheet" />

        <script>
        var WWW = '{{ url('/') }}/';
        </script>

        <script src="//code.jquery.com/jquery-2.2.4.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="{{ url('js/scripts.js') }}"></script>
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
                            <option value="profile-shares" {{ $SECTION === 'profile-shares' ? 'selected' : '' }}>TOP USERs SHARES</option>
                            <option value="url-shares" {{ $SECTION === 'url-shares' ? 'selected' : '' }}>TOP URLs SHARES</option>
                            <option value="media-links" {{ $SECTION === 'media-links' ? 'selected' : '' }}>TOP MEDIAs LINKS</option>
                            <option value="media-shares" {{ $SECTION === 'media-shares' ? 'selected' : '' }}>TOP MEDIAs SHARES</option>
                        </select>
                    </div>
                </form>

                @yield('body')
            </div>
        </div>
    </body>
</html>
