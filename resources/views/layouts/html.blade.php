<!DOCTYPE HTML>
<html lang="es">
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
        <link href="//getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet" />

        <script src="//code.jquery.com/jquery-2.2.4.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <style>
        .fixed {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nowrap {
            white-space: nowrap;
        }

        .well h3 {
            margin: 0;
        }
        </style>

        <script>
        var WWW = '{{ url('/') }}/';

        jQuery(function ($) {
            $('#stats-form select').on('change', function(e) {
                location.href = WWW + $(this).val();
            });

            $('.back').on('click', function(e) {
                e.preventDefault();

                window.history.back();
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
