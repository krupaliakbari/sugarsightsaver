<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sugar Sight Saver - Diabetes Awareness</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #634299 0%, #8b5fbf 100%);
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 30px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #f0f0f0;
        }

        /* Banner Section */
        .banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .banner h1 {
            font-size: 48px;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .banner p {
            font-size: 20px;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .cta-button {
            display: inline-block;
            background: #634299;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(99, 66, 153, 0.3);
        }

        .cta-button:hover {
            background: #5a3a8a;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 66, 153, 0.4);
        }

        /* About Diabetes Section */
        .about-section {
            padding: 80px 0;
            background: white;
        }

        .section-title {
            text-align: center;
            font-size: 36px;
            color: #634299;
            margin-bottom: 50px;
            font-weight: 700;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: start;
        }

        .content-card {
            background: #f8f9fa;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border-left: 5px solid #634299;
        }

        .content-card h3 {
            color: #634299;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .content-card p {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
        }

        /* Types Section */
        .types-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .types-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .type-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .type-card:hover {
            transform: translateY(-5px);
        }

        .type-card h4 {
            color: #634299;
            font-size: 20px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .type-card p {
            color: #666;
            line-height: 1.6;
        }

        /* Myths vs Facts Section */
        .myths-section {
            padding: 80px 0;
            background: white;
        }

        .myth-fact {
            display: flex;
            margin-bottom: 30px;
            background: #f8f9fa;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .myth {
            flex: 1;
            padding: 20px;
            background: #ff6b6b;
            color: white;
        }

        .fact {
            flex: 1;
            padding: 20px;
            background: #51cf66;
            color: white;
        }

        .myth h4, .fact h4 {
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        /* Call to Action */
        .cta-section {
            background: linear-gradient(135deg, #634299 0%, #8b5fbf 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .cta-section h2 {
            font-size: 36px;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .cta-section p {
            font-size: 18px;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        /* Footer */
        .footer {
            background: #2c3e50;
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        .footer p {
            margin-bottom: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 20px;
            }

            .nav-links {
                gap: 20px;
            }

            .banner h1 {
                font-size: 36px;
            }

            .banner p {
                font-size: 18px;
            }

            .content-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .types-grid {
                grid-template-columns: 1fr;
            }

            .myth-fact {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="{{ route('public.home') }}" class="logo">
                    <i class="fas fa-heartbeat"></i> Sugar Sight Saver
                </a>
                <nav class="nav-links">
                    <a href="{{ route('public.home') }}">Home</a>
                    <a href="{{ route('public.diabetes-details') }}">Diabetes Details</a>
                    @auth('web')
                        <a href="/doctor/dashboard">Dashboard</a>
                    @else
                        <a href="/doctor/login">Doctor Login</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Banner Section -->
    <section class="banner">
        <div class="container">
            <h1>Your Health is in Your Hands</h1>
            <p>With awareness, care, and the right choices, diabetes can be prevented and managed for a brighter, healthier future.</p>
            <a href="{{ route('public.diabetes-details') }}" class="cta-button">
                Learn More About Diabetes <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <!-- About Diabetes Section -->
    <section class="about-section">
        <div class="container">
            <h2 class="section-title">About Diabetes</h2>
            <div class="content-grid">
                <div class="content-card">
                    <h3>What is Diabetes?</h3>
                    <p>Diabetes is a long-term health condition that affects how your body turns food into energy. Normally, the body breaks down most of the food you eat into sugar (glucose) and releases it into your bloodstream. Insulin, a hormone made by the pancreas, helps glucose enter your cells to be used as energy.</p>
                    <p>With diabetes, your body either does not make enough insulin or cannot use insulin properly. This causes too much glucose to stay in the blood, which over time can lead to serious health problems such as heart disease, kidney damage, eye issues, and nerve problems.</p>
                </div>
                <div class="content-card">
                    <h3>Building a Healthier Tomorrow</h3>
                    <p>Building a healthier tomorrow starts today — stay active, eat well, and protect your family from diabetes with simple lifestyle choices.</p>
                    <p>Small changes in your daily routine can make a big difference in preventing and managing diabetes. Regular exercise, a balanced diet, and maintaining a healthy weight are key factors in diabetes prevention and management.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Types of Diabetes Section -->
    <section class="types-section">
        <div class="container">
            <h2 class="section-title">Types of Diabetes</h2>
            <div class="types-grid">
                <div class="type-card">
                    <h4>Type 1 Diabetes</h4>
                    <p>An autoimmune condition where the body attacks insulin-producing cells in the pancreas. Usually diagnosed in children and young adults, but can occur at any age.</p>
                </div>
                <div class="type-card">
                    <h4>Type 2 Diabetes</h4>
                    <p>The most common type of diabetes. The body either does not use insulin effectively (insulin resistance) or does not produce enough. Can be managed with healthy lifestyle changes, oral medicines, and sometimes insulin.</p>
                </div>
                <div class="type-card">
                    <h4>Gestational Diabetes</h4>
                    <p>Develops during pregnancy in women who have never had diabetes before. Usually disappears after childbirth but increases the risk of developing Type 2 diabetes later in life for both mother and child.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Myths vs Facts Section -->
    <section class="myths-section">
        <div class="container">
            <h2 class="section-title">Myths vs Facts</h2>
            <div class="myth-fact">
                <div class="myth">
                    <h4>MYTH</h4>
                    <p>Eating too much sugar causes diabetes.</p>
                </div>
                <div class="fact">
                    <h4>FACT</h4>
                    <p>While unhealthy diets can increase the risk, diabetes is influenced by genetics, lifestyle, and other health factors.</p>
                </div>
            </div>
            <div class="myth-fact">
                <div class="myth">
                    <h4>MYTH</h4>
                    <p>Only overweight people get diabetes.</p>
                </div>
                <div class="fact">
                    <h4>FACT</h4>
                    <p>Anyone can develop diabetes, regardless of body weight.</p>
                </div>
            </div>
            <div class="myth-fact">
                <div class="myth">
                    <h4>MYTH</h4>
                    <p>Diabetes is not a serious disease.</p>
                </div>
                <div class="fact">
                    <h4>FACT</h4>
                    <p>If left unmanaged, diabetes can lead to life-threatening complications.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Are you a Diabetic Patient?</h2>
            <p>Click here to get related details and comprehensive information about diabetes management.</p>
            <a href="{{ route('public.diabetes-details') }}" class="cta-button">
                Get Detailed Information <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Sugar Sight Saver. All rights reserved.</p>
            <p>Empowering healthier lives through diabetes awareness and management.</p>
        </div>
    </footer>
</body>
</html>
