    <h1>TP : Injection de dépendances en Symfony</h1>

    <p>Le but de ce TP est de se familiariser avec l’injection de dépendances en Symfony. Pour cela, nous allons concevoir un système qui permet de traiter les notifications (WhatsApp, SMS et Email).</p>

    <section id="initialisation">
      <h2>Initialisation du projet</h2>
      <ul>
        <li>Création du projet : <code>symfony new TP-injection_dependances</code></li>
        <li>Lancement initial du projet : <code>symfony serve -d</code></li>
      </ul>
    </section>

    <section id="diff-injections">
      <h2>Différentes façons d'injections de dépendance</h2>

      <h3>Méthode 1 : Injection avec constructeur</h3>
      <p>La plus commune injection est l'injection via le constructeur. Elle sert à passer une instance du service désiré, par exemple <code>EmailRequestHandler</code>, directement en paramètre du constructeur du contrôleur.</p>

      <h3>Méthode 2 : Injection avec constructeur + autowiring</h3>
      <p>Cette méthode permet de typer explicitement le paramètre à injecter, évitant toute confusion.</p>
      <blockquote>
        Extrait du cours :<br>
        "Ne pas confondre l’autowiring et l’injection de dépendance :<br>
        L’autowiring est le fait de typer les arguments du constructeur, permettant au Service Container d'injecter automatiquement la bonne instance.<br>
        L’injection de dépendances est le fait d’injecter des instances via le constructeur de la classe."
      </blockquote>

      <h3>Méthode 3 : Injection avec Setter</h3>
      <p>On peut utiliser un setter comme <code>setEmailHandler()</code>, mais ce n'est pas adapté ici car le service est utilisé dès l'instanciation du contrôleur, ce qui pourrait générer une exception sur valeur <code>null</code>. Cette méthode est souvent utilisée pour des services additionnels.</p>
      <p>Pour éviter une exception, il faut configurer le service dans <code>services.yaml</code> afin de passer le paramètre du setter lors de l'instanciation.</p>
    </section>

    <section id="implementation-interface">
      <h2>Création et implémentation de l'interface RequestHandlerInterface</h2>
      <p>Nous avons créé l'interface <code>RequestHandlerInterface</code> et trois implémentations : <code>EmailRequestHandler</code>, <code>SMSRequestHandler</code> et <code>WhatsAppRequestHandler</code>.</p>

      <h3>Résultat obtenu</h3>
      <p>Autowiring seul ne sait pas quelle classe utiliser pour l'interface. Solutions possibles :</p>

      <h4>Solution 1 : Spécification dans <code>services.yaml</code></h4>
      <p>Définir la classe concrète pour l'interface directement dans le fichier de configuration, puis utiliser le contrôleur normalement.</p>

      <h4>Solution 2 : Utiliser l'annotation <code>@Autowire</code></h4>
      <p>Permet de spécifier quelle implémentation utiliser sur le paramètre du constructeur sans modifier <code>services.yaml</code>.</p>

      <h3>Résumé</h3>
      <p>Il existe plusieurs méthodes pour réaliser l'injection de dépendance. Dans ce TP, nous avons préféré :</p>
      <ul>
        <li><strong>Lisibilité :</strong> Le code est plus maintenable, compréhensible et extensible.</li>
        <li><strong>Extensibilité :</strong> L'utilisation de l'interface <code>RequestHandlerInterface</code> combinée à <code>#[Autowire(service: 'App\Handler\EmailRequestHandler')]</code> permet de changer facilement l'implémentation sans modifier beaucoup de code, facilitant l'adaptation aux futures modifications.</li>
      </ul>
    </section>

    <section id="consignes">
      <h2>Consignes</h2>
      <ul>
        <li>Envoyer le projet avant <strong>Vendredi soir</strong> à : <a href="mailto:khadiri.issam@gmail.com">khadiri.issam@gmail.com</a>.</li>
        <li>N'inclure pas les dossiers <code>vendor</code> et <code>var</code> dans l'archive.</li>
        <li>Rédiger un rapport PDF expliquant votre code, vos solutions et décisions.</li>
        <li>Travail individuel — l'utilisation d'IA est inutile car vous serez interrogé sur le TP lors de l'examen.</li>
        <li>Tout travail non reçu d'ici Vendredi ne sera pas accepté.</li>
        <li>Un code non fonctionnel est considéré comme annulé.</li>
      </ul>

      <p>Bon courage.</p>
    </section>

