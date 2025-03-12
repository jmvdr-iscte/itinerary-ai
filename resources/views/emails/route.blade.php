<!DOCTYPE html>
<html>
<head>
	<title>Your Vacation Itinerary</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #1a0b43;
			color: #ffffff;
			text-align: center;
			margin: 0;
			padding: 20px;
		}
		h2 {
			color: #a566ff;
			margin-bottom: 20px;
		}
		h3 {
			color: #d4aaff;
		}
		a {
			color: #a566ff;
			text-decoration: none;
			font-weight: bold;
		}
		a:hover {
			text-decoration: underline;
		}
		.itinerary {
			max-width: 90%;
			margin: 0 auto;
			background: rgba(255, 255, 255, 0.1);
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
		}
		hr {
			border: none;
			height: 1px;
			background: #a566ff;
			margin: 20px 0;
		}
		@media (max-width: 600px) {
			body {
				padding: 10px;
			}
			.itinerary {
				padding: 15px;
			}
			h2, h3 {
				font-size: 1.2em;
			}
			p {
				font-size: 1em;
			}
		}
	</style>
</head>
<body>
	<div class="itinerary">
		<h2>Your Personalized Vacation Itinerary</h2>

		@foreach ($info as $day => $details)
			<h3>Day {{$day}}: {{ $details['description'] }}</h3>
			<p><strong>Google Maps Route:</strong>
				<a href="{{ $details['places'] }}" target="_blank">View Route</a>
			</p>
			<hr>
		@endforeach

		<p>Enjoy your trip!</p>
	</div>
</body>
</html>
