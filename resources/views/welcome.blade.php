<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SGIH - Accueil</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    <!-- NAVBAR -->
    <nav class="bg-white shadow px-8 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-blue-600">HospiCare</h1>

        <div>
            <a href="{{ route('login') }}" class="text-blue-600 mr-4">Connexion</a>
            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                Inscription
            </a>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="text-center mt-16 px-6">
        <h2 class="text-4xl font-bold text-gray-800 mb-4">
            Gestion moderne des soins hospitaliers
        </h2>

        <p class="text-gray-600 max-w-2xl mx-auto mb-8">
            SGIH est une plateforme web conçue pour améliorer la gestion des patients, 
            des médecins et des rendez-vous dans les établissements hospitaliers. 
            Elle permet un accès rapide, sécurisé et efficace aux informations médicales, 
            tout en optimisant l’organisation du personnel de santé.
        </p>

        <a href="{{ route('login') }}" 
           class="bg-green-600 text-white px-6 py-3 rounded shadow">
            Accéder au système
        </a>
    </section>

    <!-- FEATURES -->
    <section class="grid md:grid-cols-3 gap-6 mt-16 px-10">

        <div class="bg-white p-6 rounded shadow">
            <h3 class="font-semibold text-lg text-blue-600 mb-2">
                Gestion des patients
            </h3>
            <p class="text-gray-600 text-sm">
                Enregistrement et suivi des patients avec accès rapide aux informations.
            </p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h3 class="font-semibold text-lg text-green-600 mb-2">
                Rendez-vous
            </h3>
            <p class="text-gray-600 text-sm">
                Planification efficace des consultations et suivi des disponibilités.
            </p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h3 class="font-semibold text-lg text-orange-500 mb-2">
                Facturation
            </h3>
            <p class="text-gray-600 text-sm">
                Gestion des factures et paiements de manière fiable et sécurisée.
            </p>
        </div>

    </section>

</body>
</html>