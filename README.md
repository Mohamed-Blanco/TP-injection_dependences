<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Injection de dépendances - Symfony</title>
  <style>
    body {
      font-family: "Segoe UI", Roboto, Arial, sans-serif;
      line-height: 1.6;
      margin: 20px;
      background-color: #f8f9fa;
      color: #333;
    }
    h1, h2, h3 {
      color: #0056b3;
    }
    h1 {
      text-align: center;
      margin-bottom: 30px;
    }
    .section {
      background: #fff;
      border-left: 6px solid #0056b3;
      padding: 15px 20px;
      margin-bottom: 25px;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .highlight {
      background: #eaf4ff;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #bcdffb;
      font-family: Consolas, monospace;
      white-space: pre-wrap;
    }
    .note {
      background: #fff3cd;
      border: 1px solid #ffeeba;
      padding: 10px;
      border-radius: 6px;
      margin: 10px 0;
    }
    ul {
      margin-left: 20px;
    }
    strong {
      color: #d63384;
    }
  </style>
</head>
<body>

  <h1>Injection de Dépendances avec Symfony</h1>

  <div class="section">
    <h2>Initialisation</h2>
    <p><strong>Création du projet :</strong></p>
    <div class="highlight">symfony new TP-injection_dependances</div>

    <p><strong>Lancement initial du projet :</strong></p>
    <div class="highlight">symfony serve -d</div>
  </div>

  <div class="section">
    <h2>Méthodes d'injection</h2>

    <h3>Méthode 1 : Injection par Constructeur</h3>
    <p>L’injection par constructeur est la plus courante. Elle permet de passer une instance du service directement au constructeur (ex: <code>EmailRequestHandler</code>).</p>

    <h3>Méthode 2 : Constructeur + Autowiring</h3>
    <p>On peut préciser explicitement le type du paramètre injecté dans le constructeur pour éviter toute confusion.</p>
    <div class="note">
      <strong>Remarque :</strong><br>
      - L’autowiring consiste à typer les arguments du constructeur afin que Symfony injecte automatiquement la bonne instance.<br>
      - L’injection de dépendances consiste à fournir les instances via le constructeur de la classe.
    </div>

    <h3>Méthode 3 : Injection par Setter</h3>
    <p>Possible avec une méthode <code>setEmailHandler()</code>, mais déconseillée dans notre cas car le service est nécessaire dès l’instanciation du Controller (risque de <code>null</code>).</p>
    <p>Cependant, cette approche peut être utile pour des services additionnels.</p>
    <p>Il faut alors configurer <code>services.yaml</code> pour éviter les erreurs d’instanciation.</p>
  </div>

  <div class="section">
    <h2>Implémentation</h2>
    <p>Création de l’implémentation de l’interface <code>RequestHandlerInterface</code> avec :</p>
    <ul>
      <li>EmailHandler</li>
      <li>SmsRequestHandler</li>
      <li>WhatsappRequestHandler</li>
    </ul>
    <p>Problème : l’autowiring ne peut pas deviner quelle implémentation utiliser.</p>
  </div>

  <div class="section">
    <h2>Solutions</h2>

    <h3>Solution 1 : Configuration dans services.yaml</h3>
    <p>Spécifier la classe directement dans <code>services.yaml</code>.</p>

    <h3>Solution 2 : Annotation @autowire</h3>
    <p>Utiliser l’annotation <code>@autowire</code> sur les paramètres du constructeur pour choisir l’implémentation, sans modifier <code>services.yaml</code>.</p>
  </div>

  <div class="section">
    <h2>Résumé</h2>
    <p>Il existe plusieurs méthodes pour réaliser l’injection de dépendance. Dans ce cas, l’injection de dépendance combinée à l’autowiring a été retenue car elle présente plusieurs avantages :</p>
    <ul>
      <li><strong>Lisibilité :</strong> code plus maintenable, clair et évolutif.</li>
      <li><strong>Extensibilité :</strong> changement rapide d’implémentation en utilisant l’interface <code>RequestHandler</code> avec l’annotation <code>#[Autowire(service: 'App\Handler\EmailRequestHandler')]</code>.</li>
    </ul>
  </div>

</body>
</html>
