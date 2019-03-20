<html lang="en"><head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>{{ $title or '' }}</title>
		<style>
			body{font-family: 'Helvetica'; font-size: 13px; margin: 10px 23px;}
			h1{font-size: 24px;}
			h3{font-size: 14px;}
			h4{font-size: 12px;}
			.float-left{float:left;}
			.float-right{float:right;}
			td{border-bottom: 0px solid #000000; vertical-align:top;}
			th{text-align: left;}
			@page { margin: 250px 23px 20px 23px; font-family: Helvetica; }
			.page-break { page-break-after: always;}
			.header { position: fixed; left: 23px; top: -220px; right: 23px; height: 220px; background-color: transparent; border-bottom: 0px solid #cccccc; }
			/*.header_content {border-bottom: 1px solid #cccccc; border-top: 1px solid #cccccc;}*/
			.footer { position: fixed; left: 23px; bottom: 0px; right: 23px; height: 20px; background-color: transparent; }
     		/*#footer .page:after { content: "Page " counter(page); }*/
     		.no_break{page-break-inside: avoid;}
     		.bill-fixed-bottom{ position: fixed; left: 23px; bottom: 0px; right: 23px; height: 100px; }
     		.or-fixed-bottom{ position: fixed; left: 23px; bottom: 0px; right: 23px; height: 185px; }
     		.invisible{ visibility:hidden; }
				.text-left {text-align: left;}
				.text-right {text-align: right;}
				.text-center {text-align: center;}

				.table {border-collapse: collapse;}

				.table td {
					padding: 3px;
					border: 1px solid #666666;
				}

				.striped tbody tr:nth-child(odd) {
				   background-color: #ededed;
				}

				.bold {font-weight: bold;}
				.small {font-size: 0.8em;}

				.tr-header td{
				  background-color: #dfdfdf;
				  font-weight: bolder;
				}

		</style>
	</head><body>
			<div class="header">
				<div style="width: 40%" class="float-left">
					<img src="{{ asset('img/logo-ojh.png') }}">
				</div>
				<div style="width: 60%" class="float-right text-right">
					<h1>{{ config('myapp.client_name') }} {{ $title or ''}}</h1>
				</div>
				<div class="header_content" style="clear:both; margin-top: 20px">
				@stack('header')
				</div>
			</div>
			<script type="text/php">
				$text = 'Page: {PAGE_NUM} / {PAGE_COUNT}';
				$font = Font_Metrics::get_font("helvetica", "bold");
				$y = $pdf->get_height() - 24;
				$x = 36;
				$pdf->page_text($x, $y, $text, $font, 9);
			</script>
    		@stack('content')
			<div class="footer">
				<div class="small">Tel : {{ config('myapp.contact1') }} | {{ config('myapp.web_url')}} | email : {{ config('myapp.admin_email') }} | Printed : {{ date('d M Y, H:i:s') }} | {{ $ref or '' }}</div>
			</div>
    </body></html>