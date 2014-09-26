<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Users Controller
 *
 */
class UsersController extends AppController
{

    public $components = array('Paginator', 'AclPermission', 'Recaptcha.Recaptcha', 'Security', 'Condition');
    public $helpers = array('Aw', 'AwPaginator');
    public $uses = array('User','Country','UserCountry', 'Group', 'Book', 'Node');
    public $ATTEMPTS = 3;
    
    /**
     * index method
     * @throws NotFoundException
     * @return void
     */
    public function admin_index()
    {
        $this->set('title_for_layout', 'User Management');
        
        $conditions = array(
                'User.username' => 'LIKE',
                'User.email' => 'LIKE',
                'User.group_id',
                'User.active'
        );

        $this->Paginator->settings = array(
                'paramType' => 'querystring',
                'fields' => array(
                        'User.id',
                        'User.username', 
                        'User.email', 
                        'Group.name', 
                        'User.active'
                ),
                'limit' => 10, 
                'order' => array(
                        'User.username' => 'DESC'
                ),
                'contain' => array('Group'),
                'conditions' => $this->Condition->createConditions($conditions) 
        );
        $this->set('roles', $this->Group->find('list')); 
        try {
            $this->set('users', $this->Paginator->paginate('User'));
        } catch (NotFoundException $e) {
            $this->redirect(array('action' => 'admin_index', 'admin' => true));
        }
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function admin_view($id = null)
    {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $this->set('user', $this->User->find('first', $options));
    }

/**
 * add method
 *
 * @return void
 */
    public function admin_add()
    {
        $this->set('title_for_layout', 'User Management');

        if ($this->request->is('post')) {       
            $password = generate_password(8);
            $this->request->data['User']['password'] = $password;
            
            $verifyToken = md5(uniqid(mt_rand(),true));
            $this->request->data['User']['verify_token'] = $verifyToken;
            
             if ($this->User->saveUser($this->request->data)) {
                 //variables to be used in Email template
                 $variables = array(
                    'full_name' => h($this->request->data['User']['full_name']),
                    'username' => h($this->request->data['User']['username']),
                    'password' => $password,
                    'verify_token' => $verifyToken
                );
                 
               $from = cf('smtp.from');
               
                if ($this->_sendVerifyEmail($this->request->data['User']['email'], $variables, 'verify_email', $from, 'Your PMI-GAP account has been created. ')) {
                    $this->Session->setFlash(__('The user has been saved.'), 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-success'
                    ));
                } else {
                   $this->Session->setFlash(__('Problems sending email to user.'), 'alert', array(
                       'plugin' => 'BoostCake',
                       'class' => 'alert-danger'
                   ));
                }

                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
            }
                
        }
        $this->set('groups', $this->User->Group->getGroupList());
        $this->set('countries', $this->Country->getCountryList());
        
    }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function admin_edit($id = null)
    {
        $this->set('title_for_layout', 'User Management');

        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            
            if ($this->User->updateUser($this->request->data)) {
                
                $this->Session->setFlash(__('The user has been saved.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));

                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
            }
        } else {
            $options = array(
                'fields' => array('User.id','User.username', 'User.full_name', 'User.email', 'User.group_id', 'User.active'),
                'conditions' => array('User.' . $this->User->primaryKey => $id),
                'contain' => array('UserCountry')
            );
    
            $this->request->data = $this->User->find('first', $options);
            
            if (!empty($this->request->data['UserCountry'])) {   
                 $this->request->data['User']['countries_id'] = $this->User->formatCountryArrayForView($this->request->data['UserCountry']);
            }
        }

        $this->set('groups', $this->User->Group->getGroupList());
        $this->set('countries', $this->Country->getCountryList());
        
    }

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function admin_delete($id = null)
    {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        
        if ($this->Auth->user('id') == $id) {
            $this->Session->setFlash(__('Cannot delete your own account.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger alert-dismissable'
            ));
            return $this->redirect(array('action' => 'index'));
        }
        
        if ($this->User->delete($id)) {
            $this->UserCountry->deleteAll(array('user_id' => $id), false);
            $this->Session->setFlash(__('The user has been deleted.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success alert-dismissable'
                ));
        } else {
            $this->Session->setFlash(__('The user could not be deleted. Please, try again.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger alert-dismissable'
                ));
        }

        return $this->redirect(array('action' => 'index'));
    }
 
 /**
  * change User's status (Active/Inactive)
  * @param  string  $id
  * @param  boolean $active
  * @return redirect 
  */
    public function admin_toggleStatus($id = null, $active = false) {
            if (!$this->User->exists($id)) {
                throw new NotFoundException(__('Invalid user'));
            } 
            
            if ($this->Auth->user('id') == $id) {
                $this->Session->setFlash(__('Permission denied'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger alert-dismissable'
                )); 
                return $this->redirect(array('action' => 'index'));
            }
            
            $data = array(
                'User' => array(
                    'id' => $id,
                    'active' => !$active
                )
            );
            
            $this->User->save($data, array(
                'validate' => false,
                'fields' => array('active')
            ));      
         return $this->redirect(array('action' => 'index'));
    }
    
    /**
     * login method
     * @return void
     */
    public function login()
    {
        $this->set('title_for_layout', 'Log in');
        if ($this->Auth->loggedIn()) {
             return $this->redirect($this->Auth->redirectUrl($this->Auth->loginRedirect)); 
        }
        
        $this->layout = 'default';
        if ($this->request->is('post')||$this->request->is('put')) {
            if ($this->Auth->login()) {              
                $user = $this->Auth->user();
                // if user's account is not verify
                if (!$user['verify']) {
                    $this->Session->setFlash(__('Your account has not been verified.'), 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-danger alert-dismissable'
                    ));
                    return($this->Auth->logout());     
                }
                //if user's account is not active
                if(!$user['active']) {
                    $this->Session->setFlash(__('Your account has been locked. Please contact system administrator.'), 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-danger alert-dismissable'
                    ));
                    return($this->Auth->logout());                    
                }
                //if user's account is logged in for the first time
                if (empty($user['last_login_date'])) {
                    $this->Session->setFlash(__('Logging in for the first time? Please change your password.'), 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-success alert-dismissable'
                    ));
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'changePassword'
                    ));                  
                }

                $data = array(
                    'User' => array(
                    'id' => $user['id'],
                    'last_login_date' => date("Y-m-d H:i:s"),
                    'login_count' => 0
                    )
                );
                
                $this->User->save($data, array(
                    'validate' => false,
                    'fieldList' => array('last_login_date', 'login_count')
                ));
                
                $this->AclPermission->setActionPermission();
                return $this->redirect($this->Auth->redirectUrl($this->Auth->loginRedirect));            
         }   
            $result = $this->User->find('first', array(
                'conditions' => array('User.username' => $this->request->data['User']['username'])
            ));
            $attempts = '';
            if ($result) {
                //if user account is not active
                if (!$result['User']['active']) {
                    $this->Session->setFlash(__('Your account has been locked. Please contact system administrator.'), 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-danger alert-dismissable'
                    ));
                    return false;
                }

                    $count = $this->User->countLogin($result['User']['login_count']);
                    if ($count == $this->ATTEMPTS) { // 3 attempts then lock account
                        $data = array(
                            'User' => array(
                                'id' => $result['User']['id'],
                                'login_count' => $count,
                                'active' => false
                            )
                        );
                        $this->User->save($data, array(
                            'validate' => false,
                            'fields' => array('login_count', 'active')
                        ));
                        $this->Session->setFlash(__('Your account has been locked. Please contact system administrator.'), 'alert', array(
                            'plugin' => 'BoostCake',
                            'class' => 'alert-danger alert-dismissable'
                        ));
                        return false;
                    } else {
                        $data = array(
                            'User' => array(
                                'id' => $result['User']['id'],
                                'login_count' => $count
                            )
                        );
                        $this->User->save($data, array(
                            'validate' => false,
                            'fields' => array('login_count')
                        ));
                    }

                $attempts = ($this->ATTEMPTS - $count) > 1 ? sprintf("( %d attempts left)", $this->ATTEMPTS - $count) : sprintf("( %d attempt left)", $this->ATTEMPTS - $count); 
            }
            $this->Session->setFlash(__('Invalid username or password, try again '.$attempts), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger alert-dismissable'
            ));
        }
    }
    
    /**
     * logout method
     * @return void
     */
    public function logout()
    {
        $this->Session->delete('Auth.Permission');
        $this->Session->setFlash('You have been logged out successfully', 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-success alert-dismissable'
                    ));
        return $this->redirect($this->Auth->logout());
    }
    
    /**
     * changePassword method
     * @return void
     */
    public function changePassword(){
       $this->set('title_for_layout', 'Reset Password'); 
       $user = $this->Auth->user();
       if (empty($user['last_login_date'])) {
           $this->layout = 'forgot_password';
       }
       
        if ($this->request->is('post')||$this->request->is('put')) {
            $this->request->data['User']['id']  = $this->Auth->user('id');
           
               if ($this->User->updatePassword($this->request->data)) {
                    $this->Session->setFlash('Your password has been changed successfully', 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-success alert-dismissable'
                    ));
                     $this->logout();
                }
                unset($this->request->data);
        } 
    }
    
    /**
     * forgotPassword method
     * @return void
     */
    public function forgotPassword()
    {
        $this->set('title_for_layout', 'Forgot Password');
        if ($this->Auth->loggedIn()) {
             return $this->redirect($this->Auth->redirectUrl($this->Auth->loginRedirect)); 
        }
        
        $this->layout = 'forgot_password';
        if ($this->request->is('post')) {
            if ($this->Recaptcha->verify()) { //verify Captcha
                $forgotToken = md5(uniqid(mt_rand(),true));
                $input = array(
                    'User' => array(
                        'forgot_token' => $forgotToken,
                        'email' => $this->request->data['User']['email']
                    )
                );
                $result = $this->User->saveForgotToken($input);
               if ($result) {
                    $variables = array(
                        'full_name' => h($result['User']['full_name']),
                        'username' => h($result['User']['username']),
                        'forgot_token' => $forgotToken
                    );
                    $from = cf('smtp.from');
                    if ($this->_sendVerifyEmail($result['User']['email'], $variables, 'forgot_password', $from, 'Reset your PMI-GAP password')) {//verify Send email                           
                        $this->render('forgot_password_email');                                   
                    } else {
                        $this->Session->setFlash('There was a problem sending an email to you, please try again later', 'alert', array(
                            'plugin' => 'BoostCake',
                           'class' => 'alert-danger alert-dismissable'
                        ));
                    }                                               
               }
            } else {
                $this->User->validateEmail($this->request->data);
                $this->Session->setFlash($this->Recaptcha->error, 'alert', array(
                     'plugin' => 'BoostCake',
                    'class' => 'alert-danger alert-dismissable'
                ));
            }
        }
    }
    
    /**
     * verify token before allowing user to reset password
     * @throws NotFoundException 
     * @param  string $token
     * @return void
     */
    public function verifyToResetPassword($token = null) {
        
        $result = $this->User->find('first', array(
            'conditions' => array('User.forgot_token' => $token)
        ));
        
       if ($result) {
           if ($result['User']['verify_forgot'] == 0) {
               $this->Session->write('forgot_token', $token);
               $this->redirect(array(
                   'controller' => 'users',
                   'action' => 'resetPassword'
               ));            
           } else {
               $this->Session->setFlash('This reset code has expired. Please request a new one.', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger alert-dismissable'
                ));
               $this->redirect(array(
                   'controller' => 'users',
                   'action' => 'forgotPassword'
               ));
           }
       } else {
           throw new NotFoundException(__('Page Not Found'));
       }
    }
    
    /**
     * resetPassword method
     * @return void
     */
    public function resetPassword() {
        $this->set('title_for_layout', 'Reset Password');        
        if (!$this->Session->check('forgot_token')) {
            throw new NotFoundException(__('Page Not Found'));
        }
        $this->layout = 'forgot_password';

        if ($this->request->is('post')) {
                $forgotToken = $this->Session->read('forgot_token');
                if ($this->User->resetPassword($this->request->data, $forgotToken)) {
                    $this->Session->delete('forgot_token');
                    $this->Session->setFlash('Your password has been reset successfully', 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-success alert-dismissable'
                    ));
                     $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'login'
                    ));
                } 
        }
         
    }
    
    /**
     * verify user account 
     * @throws NotFoundException
     * @param  string $token
     * @return void
     */
    public function verifyEmail($token) {     
        $result = $this->User->find('first', array(
            'conditions' => array('User.verify_token' => $token)
        ));
        
       if ($result) {
           if ($result['User']['verify'] == 0) { //if user account has not been verified
               $data = array(
                   'User' => array(
                       'id' => $result['User']['id'],
                       'verify' => true
                   )
               );
               if ($this->User->save($data, false)) {
                    $this->Session->setFlash('Your account has been verified successfully, Please log in to the system.', 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-success alert-dismissable'
                    )); 
               } else {
                   $this->Session->setFlash('There was a problem verifying your account, please try again later', 'alert', array(
                        'plugin' => 'BoostCake',
                       'class' => 'alert-danger alert-dismissable'
                     ));
               }
              
           } else {
               $this->Session->setFlash('This verify code has already been used.', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger alert-dismissable'
                ));
               
           }
            $this->redirect(array(
                       'controller' => 'users',
                       'action' => 'login'
               ));
       } else {
           throw new NotFoundException(__('Page Not Found'));
       }
    }
    
    /**
     * send email attached with a link to verify account
     * @param  string $email
     * @param  string $variables
     * @param  string $template
     * @param  string $from
     * @param  string $subject
     * @return boolean
     */
    protected function _sendVerifyEmail($email, $variables, $template, $from, $subject){
        if (empty($email) || empty($variables) || empty($template) || empty($from) || empty($subject)) {
            return false;
        }
        
        $Email = new CakeEmail('smtp');
        
        $Email->template($template)
                ->emailFormat('html')
                ->to($email)
                ->from($from)
                ->subject($subject) 
                ->viewVars($variables);

        if ($Email->send()) {
            return true;
        } else {
            return false;
        }     
    }    
    
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Security->unlockedActions = array('login', 'admin_index');
        $this->Auth->allow(array('login', 'logout', 'forgotPassword', 'verifyToResetPassword', 'resetPassword', 'verifyEmail'));
       
    }

    public function admin_dashboard() {

    }
 
}
