<?php

namespace Goteo\Controller\Admin {

    use Goteo\Core\View,
        Goteo\Core\Redirection,
        Goteo\Core\Error,
		Goteo\Library\Text,
        Goteo\Model\User\Donor,
		Goteo\Library\Message,
		Goteo\Library\Newsletter as Boletin;

    class Newsletter {

        public static function process ($action = 'list', $id = null) {

            switch ($action) {
                case 'init':
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $template = $_POST['template'];
                        $suject = \strip_tags($_POST['subject']);
                        if ($_POST['test']) {
                            $receivers = Boletin::getTesters();
                        } elseif ($template == 33) {
                            // los destinatarios de newsletter
                            $receivers = Boletin::getReceivers();
                        } elseif ($template == 27 || $template == 38) {
                            // los cofinanciadores de este año
                            $receivers = Boletin::getDonors(Donor::$currYear);
                        }
                        if (Boletin::initiateSending($suject, $receivers, $template)) {

                            $mailing = Boletin::getSending();

                            return new View(
                                'view/admin/index.html.php',
                                array(
                                    'folder' => 'newsletter',
                                    'file' => 'init',
                                    'mailing' => $mailing,
                                    'receivers' => $receivers
                                )
                            );
                        }
                    }

                    throw new Redirection('/admin/newsletter');

                    break;
                case 'activate':
                    if (Boletin::activateSending()) {
                        Message::Info('Se ha activado un nuevo envío automático');
                    } else {
                        Message::Error('No se pudo activar el envío. Iniciar de nuevo');
                    }
                    throw new Redirection('/admin/newsletter');
                    break;
                case 'detail':
                    $list = Boletin::getDetail($id);

                    return new View(
                        'view/admin/index.html.php',
                        array(
                            'folder' => 'newsletter',
                            'file' => 'detail',
                            'detail' => $id,
                            'list' => $list
                        )
                    );
                    break;
                default:
                    $mailing = Boletin::getSending();

                    return new View(
                        'view/admin/index.html.php',
                        array(
                            'folder' => 'newsletter',
                            'file' => 'list',
                            'mailing' => $mailing
                        )
                    );
            }

        }
    }

}
