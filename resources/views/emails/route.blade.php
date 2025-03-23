<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your TripFlow Vacation Itinerary</title>
    <style>
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
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
        }

        /* Header styles */
        .header {
            background: linear-gradient(135deg, #8B5CF6, #6366F1);
            padding: 40px 20px;
            text-align: center;
        }

        .logo-container {
            margin-bottom: 20px;
        }

        .logo {
            max-width: 240px;
            height: auto;
            width: 100%;
        }

        .header h1 {
            margin: 0;
            color: white;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
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
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
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
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
            transition: transform 0.3s ease;
        }

        .day-card:hover {
            transform: translateY(-2px);
        }

        .day-card h3 {
            color: #A78BFA;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 22px;
            display: flex;
            align-items: center;
        }

        .day-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 18px;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, #8B5CF6, #6366F1);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(139, 92, 246, 0.3);
            position: relative;
            overflow: hidden;
        }

        .day-number::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0));
            border-radius: 10px;
        }

        .day-card p {
            color: #E2E8F0;
            margin: 15px 0;
        }

        .route-link {
            display: inline-block;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.15), rgba(99, 102, 241, 0.15));
            padding: 12px 20px;
            border-radius: 10px;
            margin-top: 15px;
            transition: all 0.3s;
            border: 1px solid rgba(139, 92, 246, 0.2);
        }

        .route-link:hover {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.25), rgba(99, 102, 241, 0.25));
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.2);
        }

        .day-card a {
            color: #A78BFA;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .day-card a svg {
            margin-right: 10px;
        }

        /* Summary card styles */
        .summary-card {
            text-align: center;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(99, 102, 241, 0.1));
            border-radius: 12px;
            padding: 35px 30px;
            margin-bottom: 30px;
            border: 1px solid rgba(139, 92, 246, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
        }

        .summary-card p.highlight {
            font-size: 22px;
            font-weight: 600;
            color: #A78BFA;
            margin-bottom: 20px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
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
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(99, 102, 241, 0.2));
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .social-icon:hover {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.3), rgba(99, 102, 241, 0.3));
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.2);
        }

        .contact-link {
            color: #8B5CF6 !important;
            text-decoration: none !important;
            font-weight: 600;
            padding-bottom: 2px;
            border-bottom: 1px solid rgba(139, 92, 246, 0.3);
            transition: all 0.3s;
        }

        .contact-link:hover {
            border-bottom-color: rgba(139, 92, 246, 0.8);
        }

        .copyright {
            font-size: 12px;
            color: #64748B;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid rgba(139, 92, 246, 0.1);
        }

        .brand-highlight {
            background: linear-gradient(135deg, #8B5CF6, #6366F1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
            font-weight: 700;
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
                flex-wrap: wrap !important;
            }

            .day-number {
                width: 36px !important;
                height: 36px !important;
                font-size: 16px !important;
                margin-right: 12px !important;
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
            }
        }

        /* Fix for Outlook */
        @media screen and (-webkit-min-device-pixel-ratio:0) {
            .day-number {
                display: inline-block !important;
            }

            .social-icon {
                display: inline-block !important;
            }

            .brand-highlight {
                background: none !important;
                -webkit-text-fill-color: #8B5CF6 !important;
                color: #8B5CF6 !important;
            }
        }

        /* Fix for Gmail app */
        u ~ div .email-container {
            min-width: 100vw;
        }

        /* Fix for Samsung Mail */
        #MessageViewBody, #MessageWebViewDiv {
            width: 100% !important;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header with Logo -->
        <div class="header">
            <div class="logo-container">
                <img src="{{ $message->embed(public_path('images/tripflow-email-logo.svg')) }}" alt="TripFlow AI" class="logo">
            </div>
            <h1>Your Adventure Awaits</h1>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="intro">
                <h2>Your Personalized Vacation Itinerary</h2>
                <p>We've crafted the perfect journey based on your preferences. Explore and enjoy!</p>
            </div>

            @foreach ($info as $day => $details)
            <div class="day-card">
                <h3>
                    <div class="day-number">{{ $day }}</div>
                    {{ $details['description'] }}
                </h3>
                <div class="route-link">
                    <a href="{{ $details['places'] }}" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"></path>
                            <circle cx="12" cy="9" r="2.5"></circle>
                        </svg>
                        View Google Maps Route
                    </a>
                </div>
            </div>
            @endforeach

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
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                    </div>
                </a>
                <a href="#" target="_blank">
                    <div class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </div>
                </a>
                <a href="#" target="_blank">
                    <div class="social-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                        </svg>
                    </div>
                </a>
            </div>
            <p>Have questions about your itinerary? <a href="mailto:support@tripflow.ai" class="contact-link">Contact us</a></p>
            <p>Powered by <span class="brand-highlight">TripFlow AI</span></p>
            <p class="copyright">© {{ date('Y') }} TripFlow AI. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
