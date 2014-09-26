<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $components = array(
        'Session',
        'DebugKit.Toolbar',
        'Acl',
        'Auth' => array(
            'authenticate' => array('Form' => array(
                'passwordHasher' => 'Blowfish'
                )
            ),
            /*'authorize' => array(
                'Actions' => array('actionPath' => 'controllers')
            )*/
        ),
        'Cookie', 'Security'
    );

    public $dispatchComponents = array();

    public $helpers = array(
        'Session',
        'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
        'Form' => array('className' => 'BoostCake.BoostCakeForm'),
        'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
        'AclLink'
    );

    public function beforeFilter()
    {
        //set Clickjacking prevent
        if (empty($this->request->requested)) {
            $this->response->disableCache();
            $this->response->header('X-Frame-Options', 'DENY');
        }

        //set Security blackHole
        $this->Security->blackHoleCallback = 'blackhole';
        //$this->Security->requireSecure();

        //set cookie
        //$this->Cookie->secure = true;  // i.e. only sent if using secure HTTPS
        $this->Cookie->httpOnly = true;

        //Config Authenticate
        $this->Auth->loginRedirect = Configure::read('Auth.loginRedirect');
        $this->Auth->logoutRedirect = Configure::read('Auth.logoutRedirect');
        $this->Auth->loginAction = Configure::read('Auth.loginAction');
        $this->Auth->flash = Configure::read('Auth.flash');
        $this->layout = 'admin';

        //user checking
        //$this->firstTimeLogIn();
        //$this->stillValid();
          
    }
    
    public function firstTimeLogIn () {
        if ($this->Auth->loggedIn()) {
            $user = $this->Auth->user();
            if (empty($user['last_login_date']) && !in_array($this->request->action, array('changePassword', 'logout'))) {
                $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'changePassword'
                 ));               
            } 
         
        }
    }
    
    public function stillValid() {
       if ($this->Auth->loggedIn()) {
            $id = $this->Auth->user('id');
            $this->loadModel('User');
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $id
                )
            ));
            
            if (!$user) {
                $this->redirect($this->Auth->logout());
            }
            
            if ($user['User']['active'] == false) {
                $this->redirect($this->Auth->logout());
            }
       }
    }

    public function blackhole($type) {
        debug($type);
        //exit;
        switch ($type) {
            case 'csrf':
                throw new BadRequestException('Token Expired');
                break;
            case 'secure':
                $this->redirectHttps();
                break;
            default:
                //throw new NotFoundException();
                break;
        }
    }

    public function redirectHttps() {
        if (!empty($this->request->query)) {
            $url = Router::url(array('?' => $this->request->query), true);
        } else {
            $url = Router::url(array(), true);
        }
        return $this->redirect(str_replace('http://', 'https://', $url));
    }
}
