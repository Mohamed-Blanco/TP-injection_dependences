<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Injection de Dépendance Symfony</title>
</head>
<body>
<h1>Initialisation</h1>

<h2>Création du projet</h2>
<ul>
    <li>symfony new TP-injection_dependances</li>
</ul>

<h2>Lancement initial du projet</h2>
<ul>
    <li>symfony serve -d</li>
</ul>

<h2>Différentes façons d'injections de dépendance</h2>

<h3>Méthode 1 : Injection avec constructeur</h3>
<ul>
    <li>La plus commune injection est l'injection avec constructeur. Elle sert à passer une instance du service désiré via le constructeur du paramètre <strong>EmailRequestHandler</strong>.</li>
</ul>

<h3>Méthode 2 : Injection avec constructeur + autowiring</h3>
<ul>
    <li>Cette méthode spécifie explicitement le type du paramètre à injecter sur le constructeur pour éviter toute confusion.</li>
    <li>Extrait du cours :<br>
        "Ne pas confondre l’autowiring et l’injection de dépendance :<br>
        L’autowiring est le fait de typer les arguments du constructeur, permettant au Service Container d'injecter automatiquement la bonne instance.<br>
        L’injection de dépendances est le fait d’injecter des instances via le constructeur de la classe."
    </li>
</ul>

<h3>Méthode 3 : Injection avec Setter</h3>
<ul>
    <li>On peut utiliser l'injection avec setter <strong>setEmailHandler()</strong>, mais cela peut provoquer une exception si le service est utilisé au moment de l'instanciation du Controller.</li>
    <li>L'injection avec setter est souvent utilisée pour des services additionnels.</li>
    <li>Il faut configurer le service via <strong>services.yaml</strong> pour passer le paramètre du setter lors de l'instanciation du Controller.</li>
</ul>

<h2>Création implémentation de l'interface RequestHandlerInterface</h2>
<ul>
    <li>Avec <strong>EmailHandler</strong>, <strong>SmsRequestHandler</strong> et <strong>WhatsappRequestHandler</strong></li>
    <li>Problème : L'autowiring ne peut pas savoir quelle classe utiliser pour implémenter l'interface.</li>
</ul>

<h3>Solutions</h3>
<ul>
    <li><strong>Solution 1 :</strong> Spécifier la classe dans <strong>/Config/services.yaml</strong> et avoir le code du Controller correspondant.</li>
    <li><strong>Solution 2 :</strong> Utiliser l'annotation <strong>@autowire</strong> sur les paramètres du constructeur pour spécifier l’implémentation sans modifier le fichier <strong>services.yaml</strong>.</li>
</ul>

<h2>Résumé</h2>
<p>Plusieurs méthodes existent pour réaliser l'injection de dépendance. Dans ce cas, j’ai préféré combiner l’injection de dépendance et l’autowiring pour :</p>
<ul>
    <li>📖 <strong>Lisibilité :</strong> Code plus maintenable, facile à comprendre et adaptable aux futures modifications.</li>
    <li>⚙️ <strong>Extensibilité :</strong> Remplacement facile de la classe par l’interface RequestHandler avec #[Autowire(service: 'App\Handler\EmailRequestHandler')], ce qui accélère l’implémentation.</li>
</ul>
</body>
</html>
