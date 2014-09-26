<?php
App::uses('Component', 'Controller');
/**
 * Acl Permission Component
 * create session that use to check access permission in AclLinkHelper
 */
class AclPermissionComponent extends Component
{
    public $components = array('Auth', 'Session', 'Acl');

    /**
     * assing permission from ACL component
     */
    public function setActionPermission()
    {
        $user = $this->Auth->user();
        $permission = $this->Acl->Aro->find('threaded', array(
            'conditions' => array(
                'Aro.model' => 'Group',
                'Aro.foreign_key' => $user['Group']['id']
                )
            )
        );
        $permission = Hash::extract($permission,'0.Aco.{n}');
        $allChild = array();

        foreach ($permission as $aco) {
            if ($aco['parent_id'] == 1
                || ($aco['parent_id'] == null
                    && $aco['Permission']['_create'] == 1
                    && $aco['Permission']['_read'] == 1
                    && $aco['Permission']['_update'] == 1
                    && $aco['Permission']['_delete'] == 1)) {
                $children = $this->Acl->Aco->children($aco['Permission']['aco_id']);
                $acoChild = Hash::extract($children,'{n}.Aco.id');
                $allChild = array_merge($allChild,$acoChild);
            } else {
                $allChild[] = $aco['Permission']['aco_id'];
            }
        }

        foreach ($allChild as $id) {
            $path = $this->Acl->Aco->getPath($id);
            $path = Hash::extract($path,'{n}.Aco.alias');
            array_shift($path);
            $admin = false;
            if (!empty($path) && count($path) > 1) {
                if (strpos($path[1], 'admin_') !== false) {
                    $admin = true;
                }
                $links[] = Router::url(array('controller' => $path[0], 'action' => $path[1], 'admin' => $admin));
            }
        }
        $this->Session->write('Auth.Permission', array_unique($links));
    }
}
