<?php

class IndexController extends Zend_Controller_Action
{
    /**
     * @var array
     */
    protected $config;

    public function init()
    {
        $this->config = Bootstrap::get('config');
    }

    public function indexAction()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->view->form = $form = $this->_helper->getForm('register');
        $this->view->maxplayers = Bootstrap::get('model')->getMaxPlayers();
        $this->view->ichb = $this->config['ichb'];
        $form->setAction($urlHelper->url(array(
            'controller' => 'index',
            'action' => 'register'
        ))
        );
    }

    public function registerAction()
    {
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return $this->_helper->redirector('index');
        }
        $form = $this->_helper->getForm('register');
        if (!$form->isValid($request->getPost())) {
            return $this->_forward('index');
        }
        $values = $form->getValues();
        // success
        switch ($values["kadres"]) {
            case "kap":
                $contact = $values["pemail0"];
                break;
            case "reg":
                $contact = $values["email"];
                break;
            case "list":
                $contact = $values["tlist"];
                break;
            case "other":
                $contact = $values["dradr"];
                break;
            default:
                $contact = '';
        }
        $values["contact"] = $contact;
        $result = Bootstrap::get('model')->addTeamData($values);
        if ($result !== true) {
            $this->view->error = $result;
            return; // redisplay form with error
        }
        $teamname = $this->_helper->translit($values["name"]);
        $mail = new Reg2_Mail('newreg');
        $view = $mail->getView();
        $view->maxplayers = Bootstrap::get('model')->getMaxPlayers();
        $view->data = $values;
        $mail->getMailer()
            ->addTo($this->config['mail']['register'])
            ->setSubject("ICHB-{$this->config['ichb']['year']} - New Registration: $teamname");
        $mail->send();

        if ($values["zlist"] == 'n' && !empty($values["zsubs"])) {
            $mail = new Reg2_Mail('subscribe');
            $view = $mail->getView();
            $mail->getMailer()
                ->addTo($this->config['mail']['pochta'])
                ->setSubject("ICHB-{$this->config['ichb']['year']} - Subscribe");
            $view->name = $values["name"];
            $view->list = $values["zsubs_list"];
            $view->kod = $values["zsubs_kod"];
            $view->addr = $values["zsubs"];
            $mail->getMailer()->setReplyTo($values["zsubs"], $values["name"]);
            $mail->send();
            $this->view->list_desc = 1;
            $this->view->pochta = $this->config['mail']['pochta'];
        }
    }

    public function postDispatch()
    {
        $this->view->placeholder('upnav')->set($this->view->render("index/nav.phtml"));
    }

}

