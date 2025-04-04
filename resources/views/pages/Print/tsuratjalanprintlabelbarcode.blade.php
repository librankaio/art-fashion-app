<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <style>
        /* @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path('fonts/static/OpenSans/OpenSans-Bold.ttf') }}) format("truetype");
        font-weight: 700;
        font-style: normal;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path('fonts/static/OpenSans/OpenSans-BoldItalic.ttf') }}) format("truetype");
        font-weight: 700;
        font-style: italic;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path('fonts/static/OpenSans/OpenSans-ExtraBold.ttf') }}) format("truetype");
        font-weight: 800;
        font-style: normal;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path('fonts/static/OpenSans/OpenSans-ExtraBoldItalic.ttf') }}) format("truetype");
        font-weight: 800;
        font-style: italic;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path('fonts/static/OpenSans/OpenSans-Light.ttf') }}) format("truetype");
        font-weight: 300;
        font-style: normal;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path('fonts/static/OpenSans/OpenSans-LightItalic.ttf') }}) format("truetype");
        font-weight: 300;
        font-style: italic;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path('fonts/static/OpenSans/OpenSans-Medium.ttf') }}) format("truetype");
        font-weight: 500;
        font-style: normal;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path('fonts/static/OpenSans/OpenSans-MediumItalic.ttf') }}) format("truetype");
        font-weight: 500;
        font-style: italic;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path('fonts/static/OpenSans/OpenSans-Regular.ttf') }}) format("truetype");
        font-weight: 400;
        font-style: normal;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path('fonts/static/OpenSans/OpenSans-SemiBold.ttf') }}) format("truetype");
        font-weight: 600;
        font-style: normal;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path('fonts/static/OpenSans/OpenSans-SemiBoldItalic.ttf') }}) format("truetype");
        font-weight: 600;
        font-style: italic;
    }
    
    @font-face {
        font-family: 'Open Sans';
        src: url({{ storage_path('fonts/static/OpenSans/OpenSans-Italic.ttf') }}) format("truetype");
        font-weight: 400;
        font-style: italic;
    } */
        @page {
            size: 30mm 33mm;
            margin: -1px auto;
            /* margin-top: 5px auto; */
        }

        .container {
            position: static;
            margin-left: 7px;
        }

        .split-para {
            display: block;
            /* margin:10px; */
            margin: 0px;
        }

        /* .split-para span {
      display:block; float:right ;width:50%; margin-left:10px; margin-right: 20px;
    } */
        .split-para span {
            /* display:block; float:right; padding-right:7px; padding-top:2px; */
            display: block;
            float: right;
            padding-right: 7px;
            padding-top: 0px;
        }

        /* body {
        font-family: 'Open Sans';
    } */
        body {
            /* font-family: 'Roboto';font-size: 16px; */
            font-family: 'Roboto', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Roboto', sans-serif;
        }

        td {
            font-family: 'Roboto', sans-serif;
            font-weight: bold;
        }

        p {
            word-wrap: break-word
        }

        .page_break {
            page-break-before: always;
        }
    </style>
</head>

</html>

<body>
    @foreach ($items as $item)
        @for ($i = 0; $i < $item->qty; $i++)
            <div class="container" style="padding-bottom: 15px;">
                <h5 class="split-para" style="margin: 0px auto; font-size: 6px; text-align:left; padding-bottom: 1px;"
                    id="text_code">{{ $item->name_lbl }} <span>
                        <h5 style="margin: 0px auto; font-size: 6px; float:right;"></h5>
                    </span></h5>
                <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($item->code, 'C128') }}" alt="barcode"
                    width="100" height="20" id="bgimg" />
                @if ($item->barcode == 'none' || $item->barcode == null)
                    <h5 class="split-para"
                        style="margin: 0px auto; font-size: 8px; margin-top:-7px; text-align:center;">
                        -</h5>
                @else
                    <h5 class="split-para"
                        style="margin: 0px auto; font-size: 8px; margin-top:-7px; text-align:center;">
                        {{ $item->barcode }}</h5>
                @endif
                <h5 class="split-para" style="margin: 0px auto; font-size: 8px; text-align:left; margin-top: -5px"
                    id="text_code"> <span>
                        <h5 style="margin: 0px auto; font-size: 6.5px; float:right; font-weight: bold;">RP.
                            {{ number_format($item->hrgjual, 0, '.', ',') }},-</h5>
                    </span></h5>
            </div>
            <div class="container" style="padding-bottom: 0px">
                <h5 class="split-para" style="margin: 0px auto; font-size: 6px; text-align:left; padding-bottom: 1px;"
                    id="text_code">{{ $item->name_lbl }} <span>
                        <h5 style="margin: 0px auto; font-size: 6px; float:right;"></h5>
                    </span></h5>
                <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($item->code, 'C128') }}" alt="barcode"
                    width="100" height="20" id="bgimg" />
                @if ($item->barcode == 'none' || $item->barcode == null)
                    <h5 class="split-para"
                        style="margin: 0px auto; font-size: 8px; margin-top:-7px; text-align:center;">
                        -</h5>
                @else
                    <h5 class="split-para"
                        style="margin: 0px auto; font-size: 8px; margin-top:-7px; text-align:center;">
                        {{ $item->barcode }}</h5>
                @endif
                <h5 class="split-para" style="margin: 0px auto; font-size: 8px; text-align:left; margin-top: -5px"
                    id="text_code"> <span>
                        <h5 style="margin: 0px auto; font-size: 6.5px; float:right; font-weight: bold;">RP.
                            {{ number_format($item->hrgjual, 0, '.', ',') }},-</h5>
                    </span></h5>
            </div>
            <div class="page_break"></div>
        @endfor
    @endforeach
</body>
