<?php

class AdminController extends Zend_Controller_Action
{
	/**
	 * @var array
	 */
	protected $config;

    public function preDispatch()
    {
        $acl = Zend_Registry::get('acl');

        if(!$acl->isAllowed(Zend_Registry::get('role'), 'admin', $this->getRequest()->action)) {
            if(!Zend_Auth::getInstance()->hasIdentity()) {
                $this->_forward('noauth', 'error');
            } else {
                $this->_forward('noacl', 'error');
            }
        }
        $this->config = Bootstrap::get('config');
    }

    /**
     * Admin menu
     *
     *
     */
    public function postDispatch()
    {
        $this->view->placeholder('nav')->set($this->view->render("admin/nav.phtml"));
    }

    public function indexAction()
    {
        $this->view->teams = Reg2_Model_Data::getModel()->countPendingTeams();
    }

    /**
     * List of pending teams
     *
     *
     */
    public function pendingAction()
    {
        $this->view->teams = Reg2_Model_Data::getModel()->getPendingTeams();
    }

    /**
     * List of registered teams
     *
     *
     */
    public function teamsAction()
    {
        $model = Reg2_Model_Data::getModel();
        $teams = $model->getTeams();
        foreach($teams as $team) {
            $id = $team->tid;
            $teamdata[$id] = $model->getTeamData($team->tid);
            $teamdata[$id]["check"] = $model->checkTeamData($teamdata[$id]);
        }
        $this->view->teams = $teamdata;
        $this->view->known_err = $model->getKnownErrors();
    }

	/**
	 * Edit/confirm pending team
	 *
	 *
	 */
    public function teamAction()
    {
        if(!$id = (int)$this->_getParam('id', false)) {
            return $this->_helper->redirector('index');
        }

        $this->view->form = $form = $this->_helper->getForm('teamconfirm', array("tid" => $id));
        $model = Reg2_Model_Data::getModel();
        $this->view->maxplayers = $model->getMaxPlayers();
        $this->view->tid = $id;
        $request = $this->getRequest();

        if($request->isPost()) {
            if($form->isValid($request->getPost())) {
                $values = $form->getValues();
                if($form->save->isChecked()) {
                    $result = $model->saveTeamData($values);
                    $form->reset();
                    $form->populate($model->getTeamData($id));
                    $this->view->error = $result;
                } elseif($form->delete->isChecked()) {
                    $model->deleteTeam($id);
                    return $this->_helper->redirector('pending');
                } elseif($form->confirm->isChecked()) {
                    // confirm data
                    $result = $model->saveTeamData($values);
                    if($result === true) {
                        $model->confirmTeam($id);
                        // send confirmation mail
                        $mail = new Reg2_Mail('confirmed');
                        $team = $model->findTeam($id);
                        $mail->getMailer()->addTo($team->list)->setSubject("ICHB-{$this->config['ichb']['year']} - Confirmed");
                        if(!empty($team->second_email)) {
                            $mail->getMailer()->addCC($team->second_email);
                        }
                        $mail->getView()->team = $team;
                        $mail->getView()->kadavr = $this->config['mail']['kadavr'];
						$mail->getView()->ichb = $this->config['ichb']['name'];
						$mail->send();
                        // send kap's pwd mail
                        $mail = new Reg2_Mail('cappwd');
                        $kap = $model->findPlayer($team->kap);
                        $mail->getMailer()->addTo($kap->email)->setSubject("ICHB-{$this->config['ichb']['year']} - Captain's Access");
                        $mail->getView()->team = $team;
                        $mail->getView()->pwd = $model->createUserPassword($kap->email, $team->tid);
                        $mail->getView()->kadavr = $this->config['mail']['kadavr'];
                        $mail->send();
                        return $this->_helper->redirector('pending');
                    } else {
                        $this->view->error = $result;
                    }
                }
            }
        } else {
            $form->populate($model->getTeamData($id));
        }
        $this->view->data_errors = $model->checkTeamData($form->getValues());
    }

    public function kapAction()
    {
        $this->view->kaps = Reg2_Model_Data::getModel()->getKaps();
    }

    public function newpwdAction()
    {
        if(!$id = (int)$this->_getParam('id', false)) {
            return $this->_helper->redirector('kap');
        }
        $model = Reg2_Model_Data::getModel();
        $kap = $model->findPlayer($id);
        $user = $model->findUserByEmail($kap->email);
        if(!$user) {
            throw new Exception("Не найдено капитанской записи для игрока номер $id");
        }
        $team = $model->findTeam($user->tid);
        if(!$team || $team->kap != $id) {
            throw new Exception("Не найдено капитанской записи для игрока номер $id");
        }
        $mail = new Reg2_Mail('cappwd');
        $mail->getMailer()->addTo($kap->email)->setSubject("ICHB-{$this->config['ichb']['year']} - Captain's Access");
        $mail->getView()->team = $team;
        $mail->getView()->pwd = $model->createUserPassword($kap->email, $team->tid);
        $mail->getView()->kadavr = $this->config['mail']['kadavr'];
        $mail->send();
        $this->view->user = $kap;
    }

    public function regnoAction()
    {
        $model = Reg2_Model_Data::getModel();
        $teams = $model->getTeams();
        $teamdata = array(); $tnames = array(); $i = 0;
		foreach($teams as $team) {
		    $teamdata["regno$i"] = $team->regno;
		    $teamdata["tid$i"] = $team->tid;
		    $tnames[$i] = $team->imia;
		    $i++;
		}
        $this->view->teamcount = $i;
        $this->view->form = $form = $this->_helper->getForm('regno', array("teams" => $tnames));
        $request = $this->getRequest();

        if($request->isPost()) {
            if($form->isValid($request->getPost())) {
                $values = $form->getValues();
                $result = $model->saveTeamRegno($values);
                $this->view->error = $result;
            }
        } else {
            $form->populate($teamdata);
        }
    }

}





