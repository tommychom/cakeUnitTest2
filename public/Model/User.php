<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * User Model
 *
 */
class User extends AppModel {
              
	public $belongsTo = array('Group');
    // public $virtualFields = array('full_name' => "CONCAT(first_name, ' ', last_name)");
              
	/**
	 * Set Acl Behavior
	 */
	public $actsAs = array('Acl' => array('type' => 'requester'));
	
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'username' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter username',
				'last' => true
			),
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'message' => 'Usernames must only contain letters and numbers.',
			),
			'usernameLength' => array(
                'rule'    => array('between', 8, 15),
                'message' => 'Usernames must be between 8 and 15 characters long.'
            ),
            'notDuplicate' => array(
                'rule' => array('isUnique'),
                'message' => 'This username has already been taken.'
            )
		),
		'password' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter password',
                'last' => true
            ),
            'usernameLength' => array(
		        'rule'    => array('between', 6, 15),
		        'message' => 'Password must be between 6 and 15 characters long.'
		    ),
            'passwordRules' => array(
                'rule' => array('passwordRules'),
                'message' => 'Password must contain at least 1 upper case letter, 1 lower case letter, 1 number and 1 special character. '
            )
		),
        'full_name' => array(
             'notempty' => array(
                 'rule' => array('notempty'),
                 'message' => 'Please enter name'
            )
        ),
        'email' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter an email address',
                'last' => true
            ),
            'email' => array(
                'rule' => array('email'),
                'message' => 'Please enter a valid email address'
            ),
            'notDuplicate' => array(
                 'rule' => array('isUnique'),
                 'message' => 'This email already exists in the system',
            )
        ),
        'old_password' => array(
            'notempty' => array(
                 'rule' => array('notempty'),
                 'message' => 'Please enter current password',
                 'last' => true
            ),
            'checkOldPassword' => array(
                 'rule' => array('checkOldPassword'),
                 'message' => 'Incorrect password'
            )
        ),
		'confirm_password' => array(
            'passwordIdentity' => array(
                 'rule' => array('compareInput', 'password'),
                 'message' => "Confirm password doesn't match"
            )
		),
        'group_id' => array(
        	'notempty' => array(
        		'rule' => array('notempty'),
        		'message' => 'Please select group',
        		'last' => true
        	)
        ),
        'countries_id' => array(
            'multiple' => array(
                'rule' => array('multiple'),
                'message' => 'Please select country'
            )
        ),       
	);
                   
    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['User']['group_id'])) {
            $groupId = $this->data['User']['group_id'];
        } else {
            $groupId = $this->field('group_id');
        }
        if (!$groupId) {
            return null;
        } else {
            return array('Group' => array('id' => $groupId));
        }
    }

/**
 * beforeFilter callback - Set dynamic validate rule
 * @param  array  $options 
 * @return boolean alway return true
 */
    public function beforeValidate($options = array()) {
            //dynamic checking user group
            $groupList = $this->Group->getGroupList();
            $groupIdList = array_keys($groupList);
            $this->validator()->add('group_id', 'inList', array(
                'rule'    => array('inList', $groupIdList, false),
                    'message' => 'Invalid Role.'
            ));

            //allow password can empty when update user profile
            /*if (!empty($this->id) && empty($this->data[$this->alias]['password'])) {
                    $this->validator()->remove('password');
            }
            */

            //allow empty country if select global user
            if (!empty($this->data[$this->alias]['group_id']) && $this->data[$this->alias]['group_id'] == 1) {
                $this->validator()->remove('countries_id');
            }
            return true;
    }

/**
 * beforeSave callback
 * @param  array  $options 
 * @return boolean
 */
    public function beforeSave($options = array()) {
            //use blowfish for hash password
            if (!empty($this->data['User']['password'])) {
                    $hashPassword = new BlowfishPasswordHasher();
                    $this->data['User']['password'] = $hashPassword->hash($this->data['User']['password']);
            } else { //update user with empty password field
                    unset($this->data['User']['password']); //exclude password field from updating
            }

            if(!empty($this->data['User']['active']) && $this->data['User']['active'] == 1) {
                $this->data['User']['login_count'] = 0;
            }
                        
            return true;
    }
/**
 * beforeDelete callback
 * @param  boolean $cascade
 * @return boolean
 */
    public function beforeDelete($cascade = true) {
        
        $id = $this->id;
        
        $book = ClassRegistry::init('Book');
        $bookRef = $book->find('first', array(
            'conditions' => array(
                'OR' => array(
                    'Book.modified_by_user_id' => $id,
                    'Book.created_by_user_id' => $id,
                )              
            )  
        ));
        
       $node = ClassRegistry::init('Node');
       $nodeRef =  $node->find('first', array(
            'conditions' => array(
                'OR' => array(
                    'Node.modified_by_user_id' => $id,
                    'Node.created_by_user_id' => $id,
                )              
            )  
        ));
       
       if ($bookRef || $nodeRef) {
         return false;
       } else {
           return true;
       }       
    }
    
//===== Custom Validation Rules =====//       
       
    /*
     * Validate password rules
     * @param array $input
     * @return boolen
     */
    public function passwordRules($input) {
        $password = $input['password'];
        if (preg_match('`^(?=.*[^a-zA-Z0-9])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$`', $password)) {
            return true;
        } else {
            return false;
        }

    }

    /*
     * Validate email's existence
     * @param array $input
     * @return boolean
     */
    public function isExisted($input) {
        $email = $input['email'];
        $result = $this->find('count', array(
            'conditions' => array('User.email' => $email)
        ));

        return $result >= 1;
    }

    /**
     * check if old password is a correct one
     * @param  array $input
     * @return boolean
     */
    public function checkOldPassword($input) {
        $inputPassword = $input['old_password'];
        $checkPass = $this->find('first', array(
            'conditions' => array(
                'User.id' => $this->data['User']['id']
                )
        ));
        //compare plain text value to hash value
        $newHash = Security::hash($inputPassword, 'blowfish', $checkPass['User']['password']); 
        if($newHash == $checkPass['User']['password']) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * check if new Password matches the previous one
     * @param  array $input
     * @return boolean
     */
    public function checkDuplicate($input) {
        $inputPassword = $input['password'];
        $oldPassword = $this->data['User']['old_password'];
        if ($inputPassword != $oldPassword) {
            return true;
        } 
        return false;
    }

//===== Custom functions =====//
    /**
     * count number of login time
     * @param  integer $count
     * @return integer
     */
    public function countLogin($count) {
         if (empty($count) && !is_int($count)) {
            $count = 1;
        } else {
            $count = $count + 1;
        }
        return $count;
    }
    
    /**
     * change countries array format for User object
     * @param  array $countries
     * @return array
     */
    public function formatCountryArray($countries) {
        $userCountry = array();
        
        if (!empty($countries)) {          
            foreach($countries as $country){
                array_push($userCountry, array('country_id' => $country));
            }         
        }
        
        return $userCountry;
    }
    
    /**
     * change countries array format for User View
     * @param  array $countries
     * @return array
     */
    public function  formatCountryArrayForView($countries) {
        $countriesId = array();
        foreach($countries  as $country) {
             array_push($countriesId, $country['country_id']);
        }
        return $countriesId;
    }

    /**
     * custom save method for User
     * @param  array $data
     * @return boolean
     */
    public function saveUser($data) {
        if ($data['User']['group_id'] != 1) {    //if user's role is local           
                $data['UserCountry'] = $this->formatCountryArray($data['User']['countries_id']);
       }
        $this->validator()->remove('password');
        $this->validator()->remove('confirm_password');
       
       return $this->saveAll($data);
    }
    
    /**
     * custom update method for User
     * @param  array $data
     * @return boolean
     */
    public function updateUser($data) {
        if ($data['User']['group_id'] != 1) {    //if user's role is local           
                $data['UserCountry'] = $this->formatCountryArray($data['User']['countries_id']);
        }
        if (empty($data['User']['password'])) {
            $this->validator()->remove('password');
        }
        
        $userId = AuthComponent::user('id');
        if ($userId == $data['User']['id']) {
            $this->validator()->remove('group_id');
            $this->validator()->remove('countries_id');
        }
        
        $this->validator()->remove('username');
        
        $this->set($data);
        if ($this->validates()) {
            $this->UserCountry->deleteAll(array('user_id' => $data['User']['id']), false);
            unset($data['User']['username']);
            
             if ($userId == $data['User']['id']) {
                unset($data['User']['group_id']);
                unset($data['User']['active']);
            }
        }
        return $this->saveAll($data);
    }
    
    /**
     * update User's forgot_token field
     * @param  array $data
     * @return array, boolean
     */
    public function saveForgotToken($data) {      
        if ($this->validateEmail($data)){
             $result = $this->find('first', array(
                 'conditions' => array('email' => $data['User']['email'])
            ));
            $newData = array(
                'User' => array(
                    'id' => $result['User']['id'],
                    'forgot_token' => $data['User']['forgot_token'],
                    'verify_forgot' => false
                )
            ); 
            if($this->save($newData, false)){
                return $result;
            } else {
                return false;
            }
        }
        return false;
    }
    
    /**
     * check Email's existense in the system
     * @param  array $data
     * @return array
     */
    public function validateEmail($data) {
        $this->validator()->remove('email', 'notDuplicate');
        $this->validator()->add('email', 'isExisted', array(
            'rule' => array('isExisted'),
            'message' => 'This email address is not existed in the system.'
        ));
        $this->set($data);
        if ($this->validates(array('fieldList' => array('email')))) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * custom update method for User's password field
     * @param  array $data
     * @return array, boolean
     */
    public function updatePassword($data) {      
        $this->set($data);
        $this->validator()->add('password', 'checkDuplicate', array(
                'rule' => array('checkDuplicate'),
                'message' => 'New password cannot be same as old password'
            ));
         if ($this->validates()) { 
            $newData = array(
                'User' => array(
                    'id' => $data['User']['id'],
                    'password' => $data['User']['password'], 
                    'last_login_date' => date("Y-m-d H:i:s") 
                )       
            );
            return $this->save($newData);
         } else {
             return false;
         }
    }
    
    /**
     * update User's password
     * @param  array $data
     * @param  string $forgotToken
     * @return array, boolean
     */
    public function resetPassword($data, $forgotToken) {
        $this->set($data);     
        if ($this->validates(array('fieldList' => array('password', 'confirm_password')))) {
                $result = $this->find('first', array(
                    'conditions' => array('User.forgot_token' => $forgotToken),
                    'fields' => array('User.id')
                ));
                $newData = array(
                    'User' => array(
                        'id' => $result['User']['id'],
                        'password' => $data['User']['password'],
                        'verify_forgot' => true
                    )       
                );
                return $this->save($newData);
        } else {
            return false;
        }
    }

    /**
     * get a list of UserCountry
     * @param  integer $userId
     * @return array, boolean
     */
    public function getUserCountry($userId) {
        if (!is_numeric($userId)) {
            return false;
        }
        
        $this->id = $userId;
        if ($this->field('group_id') == 1) {
            $countries = $this->UserCountry->Country->getCountryList('list');
            return array_keys($countries);
        }

        $userCountry = Cache::read('Auth.UserCountry.' . $userId, 'short');
        if (!$userCountry) {
            $userCountry = $this->find('first', array(
                'fields' => array('id'),
                'conditions' => array(
                    'User.id' => $userId
                ),
                'contain' => array('UserCountry' => array('fields' => array('UserCountry.country_id')))
            ));
            $userCountry = Hash::extract($userCountry, 'UserCountry.{n}.country_id');
            Cache::write('Auth.UserCountry.' . $userId, $userCountry, 'short');
        }
        return $userCountry;
    }
    
}

