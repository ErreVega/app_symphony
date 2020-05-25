<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Test extends WebTestCase
{
    public function testLogin(): void
    {
        // El cliente es inicializado
        $client = static::createClient();

        // Se solicita la página de inicio de sesión, y se confirma que es accesible
        $loginCrawler = $client->request('GET', '/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // El formulario de inicio de sesión es obtenido y rellenado con los datos falsos de la fixture
        $loginForm = $loginCrawler->selectButton('loginSubmit')->form();
        $loginForm['email'] = 'pepe';
        $loginForm['password'] = 'pepe';

        // Una vez rellenado el formulario es enviado, se comprueba que el envío provoca una redirección
        // Si no se produjese una redirección se debería a algún error o dato incorrecto
        $client->submit($loginForm);
        $this->assertTrue($client->getResponse()->isRedirect());

        // Se sigue la redirección, y comprueba que la respuesta de esta es accesible
        $homeCrawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Por último, se comprueba que la redirección lleva a la página principal
        $this->assertEquals('http://localhost/main', $homeCrawler->getUri());

        $msgSendCrawler = $client->request('GET', '/sendMsg');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $sendForm = $msgSendCrawler->selectButton('new_msg_form[Enviar]')->form();

        $text =  "TEST_AUTOMATICO";
        $sendForm["new_msg_form[to]"] = "ana";
        $sendForm["new_msg_form[subject]"] = $text;
        $sendForm["new_msg_form[msgbody]"] = $text;

        $client->submit($sendForm);

        $msgSendCrawler = $client->request('GET', '/sent');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertGreaterThan(0, $msgSendCrawler->filter(".asunto:contains({$text})")->count() );

    }
}
