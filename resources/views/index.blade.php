<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<style>
    .dropdown {
        display: none;
        position: absolute;
        left: 0;
        background: #fff;
        width: 500px;
    }

    .pushright {
        display: none;
        position: absolute;
        background: #fff;
    }

    .link {
        position: relative;
    }
    
    .link:hover .dropdown{
        display: block
    }

    .secondlink {
        position: relative;
    }

    .secondlink:hover .pushright{
        display: block
    }
</style>
    <ul>
        @foreach ($carBrands as $carBrand)
            <li class="link" style="display: inline; border: 1px solid #000; padding: 5px; margin: 2px;">{{ $carBrand->name }}
                <div class="dropdown">
                    @foreach($carBrand->models as $model)
                    <ul>
                        <li class="secondlink" style="display: block; border: 1px solid #000; padding: 5px; margin: 2px;">{{ $model->name }}
                        <div class="pushright">
                            @foreach($model->bodies as $body)
                            <ul>
                                <li>{{ $body->name }}</li>
                            </ul>
                            @endforeach
                        </div>
                        </li>
                    </ul>
                    @endforeach
                </div>
            </li>
        @endforeach
    </ul>

</body>
</html>