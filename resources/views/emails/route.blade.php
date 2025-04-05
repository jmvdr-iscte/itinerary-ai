<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>Your CarefreeTrip Vacation Itinerary</title>
    <!--[if !mso]><!-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<![endif]-->
    <!--[if mso]>
    <noscript>
    <xml>
    <o:OfficeDocumentSettings>
    <o:AllowPNG/>
    <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
    </xml>
    </noscript>
    <![endif]-->
    <style>
        /* Reset styles */
        body, html {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            height: 100% !important;
        }

        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            box-sizing: border-box;
        }

        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        table, td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            max-width: 100%;
            display: block;
        }

        p, a, li, td, blockquote {
            mso-line-height-rule: exactly;
        }

        a[href^=tel], a[href^=sms] {
            color: inherit;
            cursor: default;
            text-decoration: none;
        }

        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* Base styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0F1629;
            color: #ffffff;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        /* Container styles */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #1A2333;
            border-radius: 16px;
            overflow: hidden;
        }

        /* Header styles */
        .header {
            background: linear-gradient(135deg, #8B5CF6, #6366F1);
            padding: 40px 20px;
            text-align: center;
        }

        .logo-container {
            margin-bottom: 20px;
            padding: 15px;
            display: inline-block;
            border-radius: 20px;
            background-color: rgba(26, 35, 51, 0.7);
        }

        .logo {
            max-width: 240px;
            height: auto;
            width: 100%;
            margin: 0 auto;
        }

        .header h1 {
            margin: 0;
            color: white;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* Content styles */
        .content {
            padding: 40px 30px;
        }

        .intro {
            text-align: center;
            margin-bottom: 40px;
        }

        .intro h2 {
            color: #8B5CF6;
            font-size: 26px;
            margin-top: 0;
            margin-bottom: 15px;
        }

        .intro p {
            color: #CBD5E1;
            font-size: 16px;
            margin: 0;
        }

        /* Day card styles */
        .day-card {
            background: rgba(30, 41, 59, 0.7);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            border-left: 4px solid #8B5CF6;
        }

        .day-card h3 {
            color: #A78BFA;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 22px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        .day-number {
            display: inline-block;
            margin-right: 15px;
            font-size: 16px;
            font-weight: 700;
            color: white;
            background: #8B5CF6;
            min-width: 100px;
            height: 40px;
            border-radius: 10px;
            text-align: center;
            line-height: 40px;
            vertical-align: middle;
            padding: 0 10px;
        }

        .day-card p {
            color: #E2E8F0;
            margin: 15px 0;
        }

        .route-link {
            display: block;
            background: rgba(139, 92, 246, 0.15);
            padding: 12px 20px;
            border-radius: 10px;
            margin-top: 15px;
            border: 1px solid rgba(139, 92, 246, 0.2);
            width: 100%;
            text-align: center;
        }

        .day-card a {
            color: #A78BFA;
            text-decoration: none;
            font-weight: 600;
        }

        .map-icon {
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }

        /* Summary card styles */
        .summary-card {
            text-align: center;
            background: rgba(139, 92, 246, 0.1);
            border-radius: 12px;
            padding: 35px 30px;
            margin-bottom: 30px;
            border: 1px solid rgba(139, 92, 246, 0.2);
        }

        .summary-card p.highlight {
            font-size: 22px;
            font-weight: 600;
            color: #A78BFA;
            margin-bottom: 20px;
        }

        .summary-card p.message {
            color: #E2E8F0;
            margin: 15px 0;
            font-size: 16px;
        }

        .summary-card p.signature {
            margin-top: 30px;
            font-style: italic;
            color: #CBD5E1;
            font-size: 18px;
        }

        /* Footer styles */
        .footer {
            background-color: #1E293B;
            padding: 35px 20px;
            text-align: center;
            border-top: 1px solid rgba(139, 92, 246, 0.3);
        }

        .footer p {
            color: #94A3B8;
            margin: 12px 0;
            font-size: 14px;
        }

        .social-links {
            margin: 25px 0;
        }

        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #8B5CF6;
            text-decoration: none;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(139, 92, 246, 0.2);
            border-radius: 10px;
            display: inline-block;
            text-align: center;
            line-height: 40px;
            vertical-align: middle;
        }

        .contact-link {
            color: #8B5CF6 !important;
            text-decoration: none !important;
            font-weight: 600;
            padding-bottom: 2px;
            border-bottom: 1px solid rgba(139, 92, 246, 0.3);
        }

        .copyright {
            font-size: 12px;
            color: #64748B;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid rgba(139, 92, 246, 0.1);
        }

        .brand-highlight {
            color: #8B5CF6;
            font-weight: 700;
        }

        /* Dark mode support - for clients that support it */
        @media (prefers-color-scheme: dark) {
            .email-container {
                background-color: #1A2333 !important;
            }
            body {
                background-color: #0F1629 !important;
            }
            .day-card {
                background: rgba(30, 41, 59, 0.7) !important;
            }
            .summary-card {
                background: rgba(139, 92, 246, 0.1) !important;
            }
            .footer {
                background-color: #1E293B !important;
            }
        }

        /* Enhanced Responsive styles */
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                border-radius: 0 !important;
                max-width: 100% !important;
            }

            .header {
                padding: 30px 15px !important;
            }

            .logo {
                max-width: 200px !important;
            }

            .header h1 {
                font-size: 22px !important;
            }

            .content {
                padding: 30px 20px !important;
            }

            .intro h2 {
                font-size: 22px !important;
            }

            .intro p {
                font-size: 14px !important;
            }

            .day-card {
                padding: 25px 20px !important;
                margin-bottom: 25px !important;
            }

            .day-card h3 {
                font-size: 20px !important;
            }

            .day-number {
                min-width: 90px !important;
                height: 36px !important;
                font-size: 14px !important;
                margin-right: 12px !important;
                line-height: 36px !important;
                margin-bottom: 8px !important;
            }

            .day-card p {
                font-size: 14px !important;
            }

            .route-link {
                padding: 10px 16px !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }

            .day-card a {
                font-size: 14px !important;
            }

            .summary-card {
                padding: 25px 20px !important;
            }

            .summary-card p.highlight {
                font-size: 20px !important;
            }

            .summary-card p.message {
                font-size: 14px !important;
            }

            .summary-card p.signature {
                font-size: 16px !important;
            }

            .footer {
                padding: 25px 15px !important;
            }

            .footer p {
                font-size: 12px !important;
            }

            .social-links a {
                margin: 0 8px !important;
            }

            .social-icon {
                width: 36px !important;
                height: 36px !important;
                line-height: 36px !important;
            }
        }

        /* Small mobile devices */
        @media only screen and (max-width: 480px) {
            .header h1 {
                font-size: 20px !important;
            }

            .intro h2 {
                font-size: 20px !important;
            }

            .day-card h3 {
                font-size: 18px !important;
            }

            .day-number {
                min-width: 80px !important;
                height: 32px !important;
                font-size: 13px !important;
                line-height: 32px !important;
            }
        }
    </style>
    <!--[if mso]>
    <style type="text/css">
        body, table, td {
            font-family: Arial, sans-serif !important;
        }
        .day-number {
            background-color: #8B5CF6 !important;
            display: inline-block !important;
            min-width: 100px !important;
            height: 40px !important;
            text-align: center !important;
            line-height: 40px !important;
            border-radius: 10px !important;
            color: white !important;
            font-weight: bold !important;
            margin-right: 15px !important;
            padding: 0 10px !important;
        }
        .brand-highlight {
            color: #8B5CF6 !important;
            font-weight: bold !important;
        }
        .email-container {
            width: 600px !important;
        }
        .header {
            background-color: #8B5CF6 !important;
        }
        .logo-container {
            background-color: #1A2333 !important;
            padding: 15px !important;
            border-radius: 20px !important;
        }
        .day-card {
            border-left: 4px solid #8B5CF6 !important;
            background-color: #1E293B !important;
        }
        .route-link {
            background-color: #f5f3ff !important;
        }
        .summary-card {
            background-color: #f5f3ff !important;
        }
        .social-icon {
            background-color: #f5f3ff !important;
        }
        h1, h2, h3, p {
            font-family: Arial, sans-serif !important;
        }
    </style>
    <![endif]-->
</head>
<body>
    <!--[if mso]>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#0F1629">
    <tr>
    <td>
    <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
    <tr>
    <td>
    <![endif]-->

    <div class="email-container">
        <!-- Header with Logo -->
        <div class="header">
            <div class="logo-container">
                <!--[if !mso]><!-->
                <!-- Embedded SVG Logo for modern email clients -->
                <svg xmlns="http://www.w3.org/2000/svg" width="240" height="80" viewBox="0 0 240 80" style="max-width: 240px; height: auto; width: 100%;">
                  <style>
                    .logo-text {
                      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                      font-weight: 700;
                      fill: white;
                    }
                    .pin-body {
                      fill: #8B5CF6;
                    }
                    .wavy-line {
                      fill: none;
                      stroke: white;
                      stroke-width: 3;
                      stroke-linecap: round;
                      filter: drop-shadow(0px 0px 2px rgba(0, 0, 0, 0.5));
                    }
                  </style>

                  <!-- Pin Logo -->
                  <g transform="translate(20, 15)">
                    <path class="pin-body" d="M30,0 C13.4315,0 0,13.4315 0,30 C0,41.4228 7.2362,51.1654 15,58.1818 C22.7638,65.1982 30,70 30,70 C30,70 37.2362,65.1982 45,58.1818 C52.7638,51.1654 60,41.4228 60,30 C60,13.4315 46.5685,0 30,0 Z" />
                    <path class="wavy-line" d="M15,30 C20,25 25,35 30,30 C35,25 40,35 45,30" />
                  </g>

                  <!-- Text -->
                  <text x="90" y="45" class="logo-text" font-size="28">CarefreeTrip</text>
                </svg>
                <!--<![endif]-->

                <!-- Fallback for Outlook and other email clients that don't support SVG -->
                <!--[if mso]>
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                <td align="center">
                    <img src="https://i.imgur.com/placeholder-for-tripflow-logo.png" alt="CarefreeTrip" width="240" style="width: 240px; max-width: 240px; height: auto; display: block; margin: 0 auto;">
                </td>
                </tr>
                </table>
                <![endif]-->
            </div>

            <!--[if !mso]><!-->
            <h1>Your Adventure Awaits</h1>
            <!--<![endif]-->

            <!--[if mso]>
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr>
            <td align="center" style="padding-top: 10px;">
                <h1 style="font-family: Arial, sans-serif; font-size: 28px; color: white; font-weight: bold; margin: 0;">Your Adventure Awaits</h1>
            </td>
            </tr>
            </table>
            <![endif]-->
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="intro">
                <!--[if !mso]><!-->
                <h2>Your Personalized Vacation Itinerary</h2>
                <!--<![endif]-->

                <!--[if mso]>
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                <td align="center">
                    <h2 style="font-family: Arial, sans-serif; font-size: 26px; color: #8B5CF6; font-weight: bold; margin-top: 0; margin-bottom: 15px;">Your Personalized Vacation Itinerary</h2>
                </td>
                </tr>
                </table>
                <![endif]-->

                <p>We've crafted the perfect journey based on your preferences. Explore and enjoy!</p>
            </div>

            <!-- Example Day Cards - Replace with your dynamic content -->
            @if(isset($info) && is_array($info))
                @foreach($info as $day => $details)
                <div class="day-card">
                    <!--[if !mso]><!-->
                    <h3>
                        <div class="day-number">{{ $day }}</div>
                        {{ $details['description'] }}
                    </h3>
                    <!--<![endif]-->

                    <!--[if mso]>
                    <h3 style="font-family: Arial, sans-serif; font-size: 22px; color: #A78BFA; margin-top: 0; margin-bottom: 20px;">
                        <span class="day-number">{{ $day }}</span>
                        {{ $details['description'] }}
                    </h3>
                    <![endif]-->

                    <div class="route-link">
                        <a href="{{ $details['places'] }}" target="_blank">
                            <!--[if !mso]><!-->
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="map-icon">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"></path>
                                <circle cx="12" cy="9" r="2.5"></circle>
                            </svg>
                            <!--<![endif]-->

                            <!--[if mso]>
                            <span style="font-family: Arial, sans-serif; font-size: 14px; color: #A78BFA;">📍</span>
                            <![endif]-->

                            View Google Maps Route
                        </a>
                    </div>
                    @if(isset($details['booking_urls']) && !empty($details['booking_urls']))
                        <div style="margin-top: 15px;">
                            <p style="color: #E2E8F0; margin-bottom: 10px;">Booking Links:</p>
                            @foreach($details['booking_urls'] as $place_name => $url)
                                <div class="route-link" style="margin-top: 8px;">
                                    <a href="{{ $url }}" target="_blank">
                                        <!--[if !mso]><!-->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="map-icon">
                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                            <polyline points="15 3 21 3 21 9"></polyline>
                                            <line x1="10" y1="14" x2="21" y2="3"></line>
                                        </svg>
                                        <!--<![endif]-->

                                        <!--[if mso]>
                                        <span style="font-family: Arial, sans-serif; font-size: 14px; color: #A78BFA;">🔗</span>
                                        <![endif]-->
                                        {{$place_name}}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                @endforeach
            @else
                <!-- Fallback content if no itinerary data is available -->
                <div class="day-card">
                    <h3>
                        <div class="day-number">Day 1</div>
                        Sample Itinerary Day
                    </h3>
                    <div class="route-link">
                        <a href="#" target="_blank">
                            <!--[if !mso]><!-->
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="map-icon">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"></path>
                                <circle cx="12" cy="9" r="2.5"></circle>
                            </svg>
                            <!--<![endif]-->

                            <!--[if mso]>
                            <span style="font-family: Arial, sans-serif; font-size: 14px; color: #A78BFA;">📍</span>
                            <![endif]-->

                            View Google Maps Route
                        </a>
                    </div>
                </div>
            @endif

            <div class="summary-card">
                <p class="highlight">Ready for an unforgettable experience?</p>
                <p class="message">Your adventure has been carefully planned to create lasting memories.</p>
                <p class="signature">Enjoy your trip!</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="social-links">
                <a href="#" target="_blank">
                    <div class="social-icon">
                        <!--[if !mso]><!-->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                        <!--<![endif]-->

                        <!--[if mso]>
                        <span style="font-family: Arial, sans-serif; font-size: 14px; color: #8B5CF6;">f</span>
                        <![endif]-->
                    </div>
                </a>
                <a href="#" target="_blank">
                    <div class="social-icon">
                        <!--[if !mso]><!-->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                        <!--<![endif]-->

                        <!--[if mso]>
                        <span style="font-family: Arial, sans-serif; font-size: 14px; color: #8B5CF6;">ig</span>
                        <![endif]-->
                    </div>
                </a>
                <a href="#" target="_blank">
                    <div class="social-icon">
                        <!--[if !mso]><!-->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                        </svg>
                        <!--<![endif]-->

                        <!--[if mso]>
                        <span style="font-family: Arial, sans-serif; font-size: 14px; color: #8B5CF6;">tw</span>
                        <![endif]-->
                    </div>
                </a>
            </div>
            <p>Have questions about your itinerary? <a href="mailto:support@tripflow.ai" class="contact-link">Contact us</a></p>
            <p>Powered by <span class="brand-highlight">CarefreeTrip</span></p>
            <p class="copyright">© {{ date('Y') }} CarefreeTrip. All rights reserved.</p>
        </div>
    </div>

    <!--[if mso]>
    </td>
    </tr>
    </table>
    </td>
    </tr>
    </table>
    <![endif]-->
</body>
</html>
