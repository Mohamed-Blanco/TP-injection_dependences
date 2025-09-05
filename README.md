<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TP — Injection de dépendances (Symfony)</title>
</head>
<body>
  <main>
    <h1>TP : Injection de dépendances en Symfony</h1>

    <p>Le but de ce TP est de se familiariser avec l’injection de dépendances en Symfony. Pour cela, nous allons concevoir un système qui permet de traiter les notifications (WhatsApp, SMS et Email).</p>

    <section id="installation">
      <h2>Installation du projet</h2>
      <ol>
        <li>Créer un projet Symfony depuis le début : <code>symfony new TP-injection_dependances</code></li>
        <li>Lancement initial du projet : <code>symfony serve -d</code></li>
        <li>Installer et configurer votre projet Symfony (composer, .env, etc.). Vérifier que la page d'accueil fonctionne.</li>
        <li>Créer un contrôleur comportant une action mappée sur l'URL <code>/send</code>. Cette action récupérera la requête HTTP et simulera l'envoi de la notification.</li>
      </ol>
    </section>

    <section id="manipulation-services">
      <h2>Manipulation des services</h2>
      <p>L'objectif est de mettre en place une architecture correcte pour gérer les notifications.</p>

      <h3>EmailRequestHandler</h3>
      <ul>
        <li>Créer le service dans <code>src/Handler/EmailRequestHandler.php</code>.</li>
        <li>Le service doit comporter une seule méthode <code>handle(Request $request)</code> qui ne fera pas d'envoi réel mais appellera <code>dump()</code> pour montrer qu'il a été appelé.</li>
        <li>Injecter ce service dans votre contrôleur et appeler la méthode <code>handle</code>.</li>
      </ul>

      <pre><code>namespace App\Handler;

use Symfony\Component\HttpFoundation\Request;

class EmailRequestHandler implements RequestHandlerInterface
{
    public function handle(Request $request): void
    {
        // Ne pas envoyer d'email, juste afficher un dump pour la validation
        dump('EmailRequestHandler appelé', $request->request->all());
    }
}
</code></pre>

      <h3>SMSRequestHandler</h3>
      <p>Suivre les mêmes étapes que pour <code>EmailRequestHandler</code>. Conserver la même signature <code>handle(Request $request)</code>.</p>

      <pre><code>namespace App\Handler;

use Symfony\Component\HttpFoundation\Request;

class SMSRequestHandler implements RequestHandlerInterface
{
    public function handle(Request $request): void
    {
        dump('SMSRequestHandler appelé', $request->request->all());
    }
}
</code></pre>

      <h3>WhatsAppRequestHandler</h3>
      <p>Suivre les mêmes étapes que pour Email et SMS.</p>

      <pre><code>namespace App\Handler;

use Symfony\Component\HttpFoundation\Request;

class WhatsAppRequestHandler implements RequestHandlerInterface
{
    public function handle(Request $request): void
    {
        dump('WhatsAppRequestHandler appelé', $request->request->all());
    }
}
</code></pre>

    </section>

    <section id="interface">
      <h2>Mise en place d'une interface</h2>
      <p>Créer une interface commune <code>RequestHandlerInterface</code> dans <code>src/Handler</code> afin d'harmoniser le code.</p>

      <pre><code>namespace App\Handler;

use Symfony\Component\HttpFoundation\Request;

interface RequestHandlerInterface
{
    public function handle(Request $request): void;
}
</code></pre>

      <p>Faire implémenter l'interface par les trois services et injecter l'interface dans le contrôleur pour plus d'abstraction.</p>

      <h3>Exemples d'injection dans le contrôleur</h3>

      <h4>1) Injection par constructeur (recommandée)</h4>
      <p>Autowiring Symfony injecte le service correspondant au type indiqué.</p>
      <pre><code>namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Handler\RequestHandlerInterface;

class NotificationController extends AbstractController
{
    private RequestHandlerInterface $handler;

    public function __construct(RequestHandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    public function send(Request $request): Response
    {
        $this->handler->handle($request);
        return new Response('Notification simulée (voir dump).');
    }
}
</code></pre>

      <h4>2) Injection via setter (ou méthode marquée Required)</h4>
      <pre><code>use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Component\DependencyInjection\Attribute\Required; // PHP 8+

class NotificationController extends AbstractController
{
    private RequestHandlerInterface $handler;

    #[Required]
    public function setHandler(RequestHandlerInterface $handler): void
    {
        $this->handler = $handler;
    }

    public function send(Request $request): Response
    {
        $this->handler->handle($request);
        return new Response('OK');
    }
}
</code></pre>

      <h4>3) Récupération depuis le conteneur (service locator) — moins recommandé</h4>
      <pre><code>public function send(Request $request): Response
{
    // Accéder directement au conteneur et récupérer le service
    $handler = $this->container->get(App\Handler\EmailRequestHandler::class);
    $handler->handle($request);

    return new Response('OK');
}
</code></pre>

      <h4>Configuration (services.yaml) — autowire</h4>
      <pre><code>services:
    App\Handler\:
        resource: '../src/Handler'
        autowire: true
        autoconfigure: true
</code></pre>

      <h3>Remarques et erreurs possibles</h3>
      <ul>
        <li>Si plusieurs services implémentent la même interface, l'autowiring par type provoquera une erreur d'ambiguïté. Solution : injecter un service précis (par son id) ou utiliser un <em>named alias</em> / <em>service binding</em>.</li>
        <li>Pour tester sans envoi réel, utilisez <code>dump()</code> ou le logger pour vérifier que le bon handler est appelé.</li>
        <li>Évitez d'utiliser systématiquement le conteneur <code>$this->container->get()</code> — cela rend le code moins testable et moins explicite.</li>
      </ul>

    </section>

    <section id="consignes">
      <h2>Consignes</h2>
      <ul>
        <li>Vous avez jusqu'à <strong>Vendredi soir</strong> pour envoyer votre projet à : <a href="mailto:khadiri.issam@gmail.com">khadiri.issam@gmail.com</a>.</li>
        <li>N'inclure pas les dossiers <code>vendor</code> et <code>var</code> dans l'archive envoyée.</li>
        <li>Écrire un rapport au format PDF expliquant votre code en détail (solutions, décisions, difficultés rencontrées).</li>
        <li>Tout travail non reçu d'ici Vendredi ne sera pas accepté.</li>
        <li>Ce TP sera noté et compté dans la note finale.</li>
        <li>Travail individuel — il est inutile d'utiliser une IA car vous serez interrogé sur le TP lors de l'examen.</li>
        <li>Un code non fonctionnel est considéré comme annulé.</li>
      </ul>

      <p>Bon courage.</p>
    </section>
  </main>
</body>
</html>
