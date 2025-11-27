<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance - {{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .maintenance-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            width: 90%;
            backdrop-filter: blur(10px);
        }
        .maintenance-icon {
            font-size: 4rem;
            color: #667eea;
            margin-bottom: 1.5rem;
        }
        .maintenance-title {
            color: #333;
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 2.5rem;
        }
        .maintenance-message {
            color: #666;
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        .progress {
            height: 8px;
            margin-bottom: 2rem;
            border-radius: 10px;
        }
        .contact-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 2rem;
        }
        .countdown {
            font-size: 1.5rem;
            font-weight: bold;
            color: #667eea;
            margin: 1rem 0;
        }
        .social-links a {
            color: #667eea;
            font-size: 1.5rem;
            margin: 0 10px;
            transition: color 0.3s ease;
        }
        .social-links a:hover {
            color: #764ba2;
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-icon">
            <i class="fas fa-tools"></i>
        </div>
        
        <h1 class="maintenance-title">We'll Be Back Soon!</h1>
        
        <div class="maintenance-message">
            <p>We're currently performing scheduled maintenance to improve your experience.</p>
            <p>Thank you for your patience. We're working hard to get back online as soon as possible.</p>
        </div>

        <!-- Progress Bar -->
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" 
                 role="progressbar" 
                 style="width: 75%; background-color: #667eea;" 
                 aria-valuenow="75" 
                 aria-valuemin="0" 
                 aria-valuemax="100">
            </div>
        </div>

        <!-- Countdown Timer -->
        <div class="countdown">
            <i class="fas fa-clock me-2"></i>
            <span id="maintenance-timer">00:00:00</span>
        </div>

        <!-- Contact Information -->
        <div class="contact-info">
            <h5><i class="fas fa-headset me-2"></i>Need Immediate Assistance?</h5>
            <p class="mb-1">
                <i class="fas fa-envelope me-2"></i>
                Email: <a href="mailto:{{ \App\Models\Setting::getSettings()->email ?? 'support@example.com' }}">
                    {{ \App\Models\Setting::getSettings()->email ?? 'support@example.com' }}
                </a>
            </p>
            <p class="mb-0">
                <i class="fas fa-phone me-2"></i>
                Phone: {{ \App\Models\Setting::getSettings()->phone ?? '+880 XXXX-XXXXXX' }}
            </p>
        </div>

        <!-- Social Links -->
        <div class="social-links mt-4">
            @php
                $settings = \App\Models\Setting::getSettings();
            @endphp
            @if($settings->facebook)
                <a href="{{ $settings->facebook }}" target="_blank"><i class="fab fa-facebook"></i></a>
            @endif
            @if($settings->instagram)
                <a href="{{ $settings->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>
            @endif
            @if($settings->twitter)
                <a href="{{ $settings->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a>
            @endif
        </div>

        <!-- Admin Login Link -->
        @if(!auth()->check())
            <div class="mt-4">
                <a href="{{ route('login') }}" class="btn btn-outline-primary">
                    <i class="fas fa-sign-in-alt me-2"></i>Admin Login
                </a>
            </div>
        @endif
    </div>

    <script>
        // Countdown Timer (for demonstration)
        function startCountdown() {
            let time = 2 * 60 * 60; // 2 hours in seconds
            const timerElement = document.getElementById('maintenance-timer');
            
            const interval = setInterval(() => {
                const hours = Math.floor(time / 3600);
                const minutes = Math.floor((time % 3600) / 60);
                const seconds = time % 60;
                
                timerElement.textContent = 
                    `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                if (time <= 0) {
                    clearInterval(interval);
                    timerElement.textContent = "00:00:00";
                    // Auto reload when time is up
                    setTimeout(() => {
                        window.location.reload();
                    }, 5000);
                } else {
                    time--;
                }
            }, 1000);
        }

        // Start countdown when page loads
        document.addEventListener('DOMContentLoaded', startCountdown);

        // Check every 30 seconds if maintenance is over
        setInterval(() => {
            fetch('/check-maintenance')
                .then(response => response.json())
                .then(data => {
                    if (!data.maintenance_mode) {
                        window.location.reload();
                    }
                })
                .catch(error => console.error('Error checking maintenance status:', error));
        }, 30000);
    </script>
</body>
</html>