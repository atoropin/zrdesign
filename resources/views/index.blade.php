<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<style>
    body {
        width: 960px;

        background: #000;
    }

    ul {
        list-style: none;
        padding: 0;
        margin: 0;
        background: #222;
    }

    ul li {
        display: block;
        position: relative;
        float: left;
        background: #222;
    }

    li ul { display: none; }

    ul li a {
        display: block;
        padding: 1em;
        text-decoration: none;
        white-space: nowrap;
        color: #fff;
    }

    ul li a:hover { background: #2c3e50; }

    li:hover > ul {
        display: block;
        position: absolute;
    }

    li:hover li { float: none; }

    li:hover a { background: #222; }

    li:hover li a:hover { background: #2c3e50; }

    .main-navigation li ul li { border-top: 0; }

    ul ul ul {
        left: 100%;
        top: 0;
    }

    ul:before,
    ul:after {
        content: " "; /* 1 */
        display: table; /* 2 */
    }

    ul:after { clear: both; }
</style>

    <ul class="main-navigation">
        @foreach ($brands as $brand)
            <li><a href="#">{{ $brand->name }}</a>
                <ul>
                    @foreach($brand->models as $model)
                        <li><a href="#">{{ $model->name }}</a>
                            <ul>
                                @foreach($model->bodies as $body)
                                    <li><a href="/body/{{ $body->id }}">{{ $body->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>

</body>
</html>