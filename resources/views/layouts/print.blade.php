<html lang="en">
	<header>
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
			@page { margin: 200px 23px 20px 23px; font-family: Helvetica; }
			.page-break { page-break-after: always;}
			.header { position: fixed; left: 23px; top: -190px; right: 23px; height: 190px; background-color: transparent; border-bottom: 1px solid #cccccc; }
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

				.striped tbody tr:nth-child(odd) {
				   background-color: #ededed;
				}

				.striped td {
					padding: 3px;
				}

				.bold {font-weight: bold;}
				.small {font-size: 0.8em;}
		</style>
	</header>
    <body>
			<div class="header">
				<h1>{{ config('myapp.client_name') }} {{ $title or ''}}</h1>
				<div class="header_content">
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
				<div class="small">Tel : {{ config('myapp.contact1') }} | {{ config('myapp.web_url')}} | email : {{ config('myapp.admin_email') }} | Printed : {{ date('d M Y, H:i:s') }}</div>
			</div>
    </body>
</html>