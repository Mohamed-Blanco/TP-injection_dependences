<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
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

<img width="605" height="312" alt="image" src="https://github.com/user-attachments/assets/faf16251-8a64-4926-99b8-ef8234bf1b27" />


<h2>Différentes façons d'injections de dépendance</h2>

<h3>Méthode 1 : Injection avec constructeur</h3>
<img width="664" height="631" alt="image" src="https://github.com/user-attachments/assets/2c07b78f-073b-4f76-9bdd-f931de93c14e" />

<ul>
    <li>La plus commune injection est l'injection avec constructeur. Elle sert à passer une instance du service désiré via le constructeur du paramètre <strong>EmailRequestHandler</strong>.</li>
</ul>

<h3>Méthode 2 : Injection avec constructeur + autowiring</h3>
<img width="624" height="410" alt="image" src="https://github.com/user-attachments/assets/108a7de8-198a-4290-bc64-3c3fb94d37c4" />

<ul>
    <li>Cette méthode spécifie explicitement le type du paramètre à injecter sur le constructeur pour éviter toute confusion.</li>
    <li>Extrait du cours :<br>
        "Ne pas confondre l’autowiring et l’injection de dépendance :<br>
        L’autowiring est le fait de typer les arguments du constructeur, permettant au Service Container d'injecter automatiquement la bonne instance.<br>
        L’injection de dépendances est le fait d’injecter des instances via le constructeur de la classe."
    </li>
</ul>

<h3>Méthode 3 : Injection avec Setter</h3>
<img width="630" height="413" alt="image" src="https://github.com/user-attachments/assets/20a47d1d-8622-4871-960d-abab5aab14f9" />
<ul>
    <li>On peut utiliser l'injection avec setter <strong>setEmailHandler()</strong>, mais cela peut provoquer une exception si le service est utilisé au moment de l'instanciation du Controller.</li>
    <li>L'injection avec setter est souvent utilisée pour des services additionnels.</li>
    <li>Il faut configurer le service via <strong>services.yaml</strong> pour passer le paramètre du setter lors de l'instanciation du Controller.</li>
    <img width="661" height="172" alt="image" src="https://github.com/user-attachments/assets/fe13e177-c699-4440-af7d-5249ba93d017" />

</ul>

<h2>Création implémentation de l'interface RequestHandlerInterface</h2>

<ul>
    <li>Avec <strong>EmailHandler</strong>, <strong>SmsRequestHandler</strong> et <strong>WhatsappRequestHandler</strong></li>
    <li>Problème : L'autowiring ne peut pas savoir quelle classe utiliser pour implémenter l'interface.</li>
    <img width="664" height="110" alt="image" src="https://github.com/user-attachments/assets/57ca2457-5311-4c7e-9812-ff216e778654" />

</ul>

<h3>Solutions</h3>
<ul>
    <li><strong>Solution 1 :</strong> Spécifier la classe dans <strong>/Config/services.yaml</strong> et avoir le code du Controller correspondant.</li>
    <img width="959" height="472" alt="image" src="https://github.com/user-attachments/assets/c937269a-401b-40af-b4b8-c0d23c13e050" />
![Uploading image.png…]()

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
