<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat {{ $data->training->nama }}</title>
    <meta charset="utf-8" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <style type="text/css">
        /* To remove margin while generating PDF. */
        * {
            margin:0;
            padding:0
        }
    	@page {
    		margin: 0;
    		height: 8.27in;
    		width: 11.69in;
    		background-image: url('images/certificate-bg.jpg') no-repeat 0 0;
    		background-image-resize: 6;
            /* background-size: 6in 3in;
    		background-repeat: no-repeat; */
            /* background-position: center; */
            /* background-size: cover; */
    	}
    	.name {
            font-family: 'dancing-scripts';
            font-size: .8in;
            line-height: .44in;
            font-weight: 500;
            color: #004479;
            margin-top: 4.3in;
            margin-left: 5in;
    	}
        
    	.training {
            font-size: 13pt;
            line-height: .44in;
            font-weight: 500;
            margin-top: .4in;
            text-align: center;
    	}

        
    	.tgl {
            font-size: 11pt;
            line-height: .44in;
            font-weight: 500;
            margin-top: 1.2in;
            margin-left: 2.1in;
    	}
    </style>
</head>
<body>
    <br>
	<div class="name">{{ $data->user->nama }}</div>

    <div class="training">
        Atas penyelesaian pelatihan <b>
        {{ $data->training->nama }}<b>
    </div>

    <div class="tgl"> Bandung, {{ \Carbon\Carbon::parse($data->tgl)->translatedFormat('d F Y') }}
</body>
</html>