<?php
App::uses('AppHelper', 'Helper');
App::uses('CustomFilter', 'Lib');
App::uses('AwPaginatorUtility', 'Lib');

class AclLinkHelper extends AppHelper {
	public $helpers = array('Html', 'Session','Form', 'AwPaginator');

	public function link($label, $link, $options = array(), $alert = null) {
		if ($this->__checkPermission($link)) {
			return $this->Html->link($label, $link, $options, $alert);
		}
	}

	public function postLink($label, $link, $options = array(), $alert = null) {
		if ($this->__checkPermission($link)) {
			return $this->Form->postLink($label, $link, $options, $alert);
		}
	}

	private function __prepareMenuList() {
		$bookList = $this->requestAction(array('controller' => 'nodes', 'action' => 'localAccessMenu', 'admin' => true));
		$countryList = Hash::extract($bookList, '{n}.Country.country_name');
		$countryList = array_unique($countryList);
		sort($countryList);
		return array($bookList, $countryList);
	}

	private function __createUrl($data, $url) {
		$data = Hash::flatten($data);
		$defaultUrl = array(
			'controller' => $url['controller'], 
			'action' => $url['action'],
			'admin' => (!empty($url['admin'])) ? true : false
		);
		if (isset($url['params'])) {
			foreach ($url['params'] as $index => $field) {
				if ($index === '?') {
					$query = array();
					foreach ($field as $q => $f) {
						$query[$q] = $data[$f];
					}
					$awUtil = new AwPaginatorUtility();
					$defaultUrl['?'] = $awUtil->flattenToQuery($query);
				} else {
					$defaultUrl[] = $data[$field];
				}

			}
		}
		return $defaultUrl;
	}

	public function createMenuList($url, $bookList, $countryList) {
		$menuList = array();
		foreach ($countryList as $i => $country) {
			$menuList[$i] = array(
				'title' => $country,
				'url' => '#',
				'allow' => true
			);
			$path = '{s}[country_name=' . $country . ']';
			$cf = new CustomFilter($path);
			$list = array_filter($bookList, array($cf, 'filter'));
			$params = array();
			foreach ($list as $value) {
				$menuList[$i]['children'][] = array(
					'title' => $value['Language']['language_name'],
					'url' => $this->__createUrl($value, $url),
					'allow' => false
				);
			}
		}
		return $menuList;
	}

	public function leftMenu() {
		list($bookList, $menuList) = $this->__prepareMenuList();
		$leftMenu = cf('leftMenu');
		foreach ($leftMenu as $index => $menu) {
			if (!empty($menu['callback'])) {
				$leftMenu[$index] = call_user_func_array(array($this, '__' . $menu['callback']), array($menu, $bookList, $menuList));
			}
		}
		return '<ul class="nav" id="side-menu">' . $this->treeMenu($leftMenu) . '</ul>';
	}

	private function __createLocalMenu($menu, $bookList, $menuList) {
		if (empty($bookList)) {
			return array();
		}

		$url = array(
			'controller' => 'nodes', 
			'action' => 'index',
			'admin' => true
		);

		if (count($bookList) > 1) {
			$url['params'] = array('Book.id');
			$menu['url'] = '#';
			$menu['children'] = $this->createMenuList($url, $bookList, $menuList);
		} else {
			$menu['url'] = $url + array($bookList[0]['Book']['id']);
		}
		return $menu;
	}

	private function __createVersionMenu($menu, $bookList, $menuList) {
		if (empty($bookList)) {
			return array();
		}

		$url = array(
			'controller' => 'versions', 
			'action' => 'index',
			'admin' => true
		);

		if (count($bookList) > 1) {
			$url['params'] = array('?' => array('Version.country_id' => 'Country.id', 'Version.language_id' => 'Language.id'));
			$menu ['url'] = '#';
			$menu ['children'] = $this->createMenuList($url, $bookList, $menuList);
		} else {
			$awUtil = new AwPaginatorUtility();
			$menu ['url'] = array_merge($url, array(
				'?' => $awUtil->flattenToQuery(array(
					'Version.country_id' => $bookList[0]['Country']['id'],
					'Version.language_id' => $bookList[0]['Language']['id']
				))
			));
		}
		return $menu ;
	}

	public function treeMenu($array) {
		$str = '';
		static $i = 0;
		$naturalNumber = array('first','second', 'third');
		foreach ($array as $menu) {
			if (empty($menu) || empty($menu['url'])) {
				continue;
			}

			if (!empty($menu['icon'])) {
				$menu['title'] = $this->Html->tag('i', '', array('class' => array('fa', $menu['icon'], 'fa-fw'))) . ' ' . $menu['title'];
			}

			if (isset($menu['allow']) && $menu['allow'] == true) {
				$link = $this->Html->link($menu['title'], $menu['url'], array('escape' => false));
			}elseif ($this->__checkPermission($menu['url'])) {
				$link = $this->link($menu['title'], $menu['url'], array('escape' => false));
			} else {
				continue;
			}

			if (empty($menu['children'])) {
				$str .= $this->Html->tag('li', $link);
			} else {
				$i += 1;
				$link = str_replace('</a>', '<span class="fa arrow"></span></a>', $link);
				$str .= '<li>' . $link . '<ul class="nav nav-' . $naturalNumber[$i] . '-level">';
				$str .= $this->treeMenu($menu['children']);
				$str .= '</ul></li>';
				$i -= 1;
			}
		}
		return $str;
	}
        
	private function __checkPermission($link) {
		if (!isset($link['controller']) && !isset($link['action'])) {
			return false;
		}

		if (!isset($link['controller'])) {
			$link['controller'] = $this->params['controller'];
		}

		if (!isset($link['action'])) {
			$link['action'] = '';
		}
		$permission = $this->Session->read('Auth.Permission');
		$link = Hash::remove($link, '{n}');
		$link = Hash::remove($link, '?');
		$currentUrl = Router::url($link);
		$currentUrl = strtolower($currentUrl);
		$permission = array_map('strtolower', $permission);

		if (in_array($currentUrl, $permission)) {
			return true;
		}

		return false;
	}
}
