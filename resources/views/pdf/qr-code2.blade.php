<html>

<head>
<title>QR Code</title>
</head>
<style>
    @page {
        margin: 0;
        font-family: "Times New Roman", Times, serif;
    }

    * {
        font-family: Arial, Helvetica, sans-serif;
    }

    #qrcode {
        height: 12mm;
        width: 12mm;
    }

    /* #logo {
        margin-top: 1px;
        font-size: 7px;
    } */

    .container-qr {
        align-content: center;
        text-align: center;
        margin-top: 4px;
    }

    .template-qr {
        border: 0.5px solid #000;
        height: 1.4cm;
        width: 1.4cm;
        padding: 2.2px;
        text-align: center;
        display: block;
    }

    .container {
        width: 90mm;
        height: 15mm;
    }
</style>

<body>
    <div class="container">
        @for ($i = 0; $i < $count; $i++)  <div class="template-qr">
            <!-- <img id="logo" src="{{ public_path('/assets/img/logo-dexa.png') }}"> -->
            <!-- <p id="logo">PT. DEXA</p> -->
            <div class="container-qr" id="qr">
                <img id="qrcode" src="data:image/png;base64, {!! base64_encode($qrcode) !!}">
            </div>
            <br>
            <br>
    </div>
    @endfor
    </div>
</body>

</html>