<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code d'Accès SGIH</title>
    <style>
        body { font-family: Arial, sans-serif; background: #F7FAFD; margin: 0; padding: 40px 20px; }
        .container { max-width: 520px; margin: 0 auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(10,58,138,0.1); }
        .header { background: linear-gradient(135deg, #0A3A8A 0%, #1565D8 100%); padding: 36px 40px; text-align: center; }
        .header img { height: 48px; margin-bottom: 16px; }
        .header h1 { color: white; font-size: 22px; margin: 0; font-weight: 700; }
        .header p { color: rgba(255,255,255,0.7); font-size: 13px; margin: 8px 0 0 0; }
        .body { padding: 40px; }
        .otp-box { background: #EFF6FF; border: 2px dashed #1565D8; border-radius: 12px; padding: 24px; text-align: center; margin: 24px 0; }
        .otp-label { font-size: 11px; color: #1565D8; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 12px; }
        .otp-code { font-size: 42px; font-weight: 900; color: #0A3A8A; letter-spacing: 0.3em; font-family: monospace; }
        .otp-expiry { font-size: 12px; color: #6B7280; margin-top: 10px; }
        .role-badge { display: inline-block; background: #18D4CF20; color: #0A3A8A; border: 1px solid #18D4CF; border-radius: 999px; padding: 4px 16px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; }
        .text { color: #374151; font-size: 15px; line-height: 1.6; }
        .register-url { display: block; background: #1565D8; color: white; text-align: center; padding: 14px 24px; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 15px; margin: 24px 0; }
        .footer { text-align: center; padding: 20px 40px; border-top: 1px solid #F3F4F6; }
        .footer p { font-size: 11px; color: #9CA3AF; margin: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SGIH HospiCare</h1>
            <p>Système de Gestion Hospitalière Intégré</p>
        </div>
        <div class="body">
            <p class="text">Bonjour,</p>
            <p class="text">
                La Direction de l'établissement vous a accordé un accès au système <strong>SGIH HospiCare</strong>.
                Votre rôle assigné est :
                <br><br>
                <span class="role-badge">{{ $invitation->role === 'doctor' ? 'Médecin' : 'Réceptionniste / Admin' }}</span>
            </p>

            <div class="otp-box">
                <div class="otp-label">Votre Code d'Accès Unique</div>
                <div class="otp-code">{{ $invitation->code }}</div>
                <div class="otp-expiry">Valide pendant 7 jours · Expire le {{ $invitation->expires_at->format('d/m/Y à H:i') }}</div>
            </div>

            <p class="text">
                Pour créer votre compte, cliquez sur le bouton ci-dessous et entrez ce code d'accès ainsi que votre email professionnel.
            </p>

            <a href="{{ url('/register') }}" class="register-url">Créer mon compte →</a>

            <p class="text" style="font-size:13px; color:#9CA3AF;">
                Si vous n'avez pas demandé cet accès ou si vous pensez avoir reçu ce message par erreur, veuillez contacter immédiatement l'administration.
            </p>
        </div>
        <div class="footer">
            <p>© 2026 SGIH HospiCare · Confidentiel</p>
        </div>
    </div>
</body>
</html>
