<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glass Ripple Pond</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #1a1a1a;
            margin: 0;
        }

        #pond {
            width: 800px;
            height: 500px;
            background-image: url('https://images.unsplash.com/photo-1518884948985-78265492d506?q=80&w=2070');
            background-size: cover;
            background-position: center;
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            cursor: pointer;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        /* The Glass Shade */
        #glass-shade {
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            pointer-events: none; /* Let clicks pass through to the pond */
            transform: translate(-50%, -50%);
            transition: transform 0.1s ease-out;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        /* Ripple Effect */
        .ripple {
            position: absolute;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.5);
            transform: scale(0);
            animation: ripple-effect 1.5s linear forwards;
            pointer-events: none;
        }

        @keyframes ripple-effect {
            to { transform: scale(1); opacity: 0; }
        }
    </style>
</head>
<body>

    <div id="pond">
        <div id="glass-shade"></div>
    </div>

    <script>
        const pond = document.getElementById('pond');
        const glass = document.getElementById('glass-shade');

        // Move glass shade with mouse
        pond.addEventListener('mousemove', (e) => {
            const rect = pond.getBoundingClientRect();
            glass.style.left = (e.clientX - rect.left) + 'px';
            glass.style.top = (e.clientY - rect.top) + 'px';
        });

        // Ripple Effect on Click
        pond.addEventListener('click', (e) => {
            const rect = pond.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const ripple = document.createElement('div');
            ripple.className = 'ripple';
            const size = 100;
            
            ripple.style.width = ripple.style.height = `${size}px`;
            ripple.style.left = `${x - size / 0.5}px`;
            ripple.style.top = `${y - size / 2}px`;

            pond.appendChild(ripple);
            setTimeout(() => ripple.remove(), 1500);
        });
    </script>
</body>
</html>