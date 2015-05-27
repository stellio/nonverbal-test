<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

/**
 * Frontend controller. Present test, view result
 */
class Controller_nvFront extends Controller_FrontendTemplate {


	public $url = NV_URL;
	public $view = 0;

	/**
	 * Load js scripts. Registered plugin shortcode
	 */
	function __construct() {
		parent::__construct();
		// add_action('wp_enqueue_scripts', array($this, 'enqueueJsCss'));
		add_shortcode('nonverbal', array($this, 'shortcode'));
	}

	private function showMsg($text) {
		echo '<div class="alert alert-danger" role="alert">' . $text . '</div>';	
	}

	private function array_cmp($first, $second) {

		$result = true;

		if (count($first) != 0 and count($second) !=0) {
			if ($first[0] != $second[0]) {
				$result = false;
			}
			else {
				$result = true;
				array_shift($first); array_shift($second);
				$result = $this->array_cmp($first, $second);
			}
		}
		return $result;
	}


	/**
	 * Send json test structure, by id get from ajax request
	 */
	public function ajaxGenerateTestStructure() {

		$debugMode = 0;
		$result = array();
		$tpe = nvModel::factory('nvTpe');
		$test = nvModel::factory('nvTest');
		$sign = nvModel::factory('nvSign');
		$answer = nvModel::factory('nvAnswer');
		$profile = nvModel::factory('nvProfile');
		$relation = nvModel::factory('nvRelation');
		$question = nvModel::factory('nvQuestion');
		$signsGroup = nvModel::factory('nvSignsGroup');

		$json = array();
		$testId = $this->req('id');

		if ($testId) {

			
			$tpeQuadrasList = array();

			// check is set debug mode
			$test->loadById($testId);

			if ($test->isDebug()) {
				$debugMode = 1;
			}
			$json['debugMode'] = $debugMode;


			/*
				 loading sings
			*/

			// tpe
			$signsGroupList = array();

			if ($signsGroup->getGroupsId($testId, nvModel::TYPE_TPE)) {

				foreach ($signsGroup->getGroupsId($testId, nvModel::TYPE_TPE) as $gid) {
					
					$signsGroup->loadGroup($testId, $gid);
					$singGroup =  array(
						"shortName" => $signsGroup->getShortName(),
						"gType" => $signsGroup->getType(),
						"firstSign" => array(
							'points' => 0,
							'code' => $signsGroup->firstPart->getCode(),
							'name' => $signsGroup->firstPart->getName()
						),
						"secondSign" => array(
							'points' => 0,
							'code' => $signsGroup->secondPart->getCode(),
							'name' => $signsGroup->secondPart->getName()
						)
					);
					$signsGroupList[] = $singGroup;
				}
			}

			// functionality
			foreach ($signsGroup->getGroupsId($testId, $sign::TYPE_FUNCTIONAL) as $gid) {
				
				$signsGroup->loadGroup($testId, $gid);
				$singGroup =  array(
					"shortName" => $signsGroup->getShortName(),
					"gType" => $signsGroup->getType(),
					"firstSign" => array(
						'points' => 0,
						'code' => $signsGroup->firstPart->getCode(),
						'name' => $signsGroup->firstPart->getName()
					),
					"secondSign" => array(
						'points' => 0,
						'code' => $signsGroup->secondPart->getCode(),
						'name' => $signsGroup->secondPart->getName()
					)
				);
				$signsGroupList[] = $singGroup;
			}

			$json['signsGroups'] = $signsGroupList;

			/* Load Tpe quadras list */
			foreach ($tpe->loadByTest($testId) as $item) {

				$l = array(
					'sequenceSign' => $item->sequence_of_sign,
					'code' => $item->code,
					'name' => $item->name
				);

				$tpeList[] = $l;
			}
			$json['tpelist'] = $tpeList;

			/*
				loading profiles
			*/
			$profilesList = array();

			// tpe
			foreach ($profile->loadByTestAndTypeId($testId, $sign::TYPE_TPE) as $pObj) {
				
				$pfl = array(
					'sequenceSign' => $pObj->sequence_of_sign,
					'pType' => $pObj->type,
					'code' => $pObj->code,
					'name' => $pObj->name
				);

				$profilesList[] = $pfl;
			} 

			// functionality
			foreach ($profile->loadByTestAndTypeId($testId, $sign::TYPE_FUNCTIONAL) as $pObj) {
				
				$pfl = array(
					'sequenceSign' => $pObj->sequence_of_sign,
					'pType' => $pObj->type,
					'code' => $pObj->code,
					'name' => $pObj->name
				);

				$profilesList[] = $pfl;
			}

			// Questions by test id
			$questionsList = array();

			foreach ($question->getObjectListByTestId($testId) as $item) {

				$answers = $answer->getObjectListByQuestionIdAndTestId($item->id, $testId);

				$answers_code = array();
				foreach ($answers as $i) {
					$answers_code[] = $i->value;
				}
				
				$the_question = array(
					'id' => $item->id,
					'type' => $item->type,
					'cycle' => $item->cycle,
					'answers_code' => $answers_code
				);

				$questionsList[] = $the_question;
			}

			// randomize questions
			shuffle($questionsList);
			$json['questions'] = $questionsList;

			/*
				Relations
			 */
			$relationList = array();
			$relation_roots = $relation->getRoots($testId);
			$relation_rows 	= $relation->getByTestId($testId);

			foreach ($relation_roots as $root) {
				
				$subElements = 0;
				$structure = array();
				$structure = $root;

				Controller_nvRelation::relationWalk($root->id, $relation_rows, &$subElements);
				$structure->childs = $subElements;
				$relationList[] = $structure;
			}

			$json['relations'] = $relationList;
			


			
			
			$json['profiles'] = $profilesList;


			
			
		}

		wp_send_json($json);
		exit;	
	}

	public function showTest() {

		$frontView = new View_nvFront();
		$frontView->show();
	}

	

	/**
	 * Return test result, and save result
	 */
	public function ajaxGetResult() {

		// $resultId = 0;
		$results = array(
			'lead' => array(
				'tpeName' => "",
				'typeName' => ""
			),
			'sub' => array(
				'tpeName' => "",
				'typeName' => ""
			),
			'profile' => "",
			'moreTypeInfo' => array()
		);

		$view = nvView::factory('front/result');

		$tpe = nvModel::factory('nvTpe');
		$profile = nvModel::factory('nvProfile');
		$resultModel = nvModel::factory('nvResult');
		$statistic = nvModel::factory('nvStatistic');

		// response
		$lang = $this->req('lang');
		$testId = $this->req("test_id");

		$tpeList = $this->req("tpe");
		$profileList = array_reverse($this->req('profile'));

		$profileList = array_chunk($profileList, (count($profileList) / 2));


		// survey from data
		$svy_type = $this->req("type");
		$svy_typeAnother = $this->req("typeanother");
		$svy_typeBasis = $this->req("typebasis");
		$svy_age = $this->req("age");
		$svy_gender = $this->req("gender");
		$svy_nickname = $this->req("nickname");

		if (empty($testId)) {
			$this->showMsg("Ошибка! Не найден индификтор теста");
			return;
		}

		if (empty($tpeList)) {
			$this->showMsg("Ошибка! Не найден ТПЭ параметр");
			return;
		}

		if (empty($profileList)) {
			$this->showMsg("Ошибка! Не найден профиль");
			return;
		}

		// get tpe name by code
		// lead tpe load
		$tpe->loadByCodeAndTestId($tpeList[0], $testId);
		$results['lead']['tpeName'] = $tpe->getName();

		// sub tpe load
		$tpe->loadByCodeAndTestId($tpeList[1], $testId);
		$results['sub']['tpeName'] = $tpe->getName();


		// $functionalitySings = explode(',', $func);

		// find lead type
		foreach ($resultModel->getListByTestIdAndTpe($testId, $tpeList[0]) as $result) {
			$resultProfiles = explode(',', str_replace(' ', '', $result->func));
			
			$match = $this->array_cmp($resultProfiles, $profileList[0]);

			if ($match) {
				$results['lead']['typeName'] = $result->title;
				$results['moreTypeInfo'][] = $result;
			}
		}

		// find sub type
		foreach ($resultModel->getListByTestIdAndTpe($testId, $tpeList[1]) as $result) {
			$resultProfiles = explode(',', str_replace(' ', '', $result->func));
			
			$match = $this->array_cmp($resultProfiles, $profileList[1]);

			if ($match) {
				$results['sub']['typeName'] = $result->title;
				$results['moreTypeInfo'][] = $result;
			}
		}

		// $tpeQuadras = $tpelist;
		// find profilye
		// foreach($profile->loadByTestAndTypeId($testId, $profile::TYPE_TPE) as $item) {
			// $marchList = explode(',', str_replace(' ', '', $item->sequence_of_sign));

			// $numberOfMatch = array_intersect($tpeQuadras, $marchList);
			// if (count($numberOfMatch) == count($tpeQuadras))
				// $results['profile'] = $item->name;
		// }
		// 
		$tpeProfile = array();
		foreach ($tpeList as $code) {
			$tpe->loadByCodeAndTestId($code, $testId);
			$tpeProfile[] = $tpe->getName();
		}

		$results['profile'] = implode(" - ", $tpeProfile);

		if (!empty($results['moreTypeInfo'])) {
			$statistic->setTestId($testId);
			$statistic->setResultText($results['lead']['typeName']. " " . $results['sub']['typeName']);

			// survey form data
			$statistic->setType($svy_type);
			$statistic->setTypeAnother($svy_typeAnother);
			$statistic->setTypeBasis($svy_typeBasis);
			$statistic->setAge($svy_age);
			$statistic->setGender($svy_gender);
			$statistic->setNickname($svy_nickname);
			$statistic->save();

		} else {
			$this->showMsg("Ошибка! Не удалось найти результат теста");
			
			// return;
		}

		$this->before();
		$this->template->content = $view->bind('lang', $lang)
										->bind('results', $results);

		$this->after();

		exit;
	}

	/**
	 * Shortcode handler
	 * @param  str $attr test id
	 * @return str 	     html block with results
	 */
	public function shortcode($attr) {

		$this->loadStaticFiles();
		$this->loadJsCssLibs();

		$id = 0;
		$content = '';
		
		if ($attr[0]) {
			$id = $attr[0];
			ob_start();

			$this->shortcodeProcessor($id);
			
			$content = ob_get_contents();

			ob_end_clean();
		} else {
			$content = 'Cant Load Test';
		}
		return $content;
	}


	private function getJson() {

		$test = new Model_nvTest();
		$answer = new Model_nvAnswer();
		$question = new Model_nvQuestion();

		$result = array('1' => '2', '2' => '3', 'id' => $this->id);
		// $id = $this->req('id');
		if (false) {
			// $result = $question->getListByTestId($this->id);
		}		
		return json_encode($result);
	}

	/**
	 * Echo html block with results
	 * @param  int $id	test id
	 * @return str 		html block with results
	 */
	public function shortcodeProcessor($id) {

		$view = nvView::factory("front/test");
		$test = nvModel::factory('nvTest');
		$answer = nvModel::factory('nvAnswer');
		$question = nvModel::factory('nvQuestion');

		$questions = array();
		$tpeQuestions = array();
		$funcQuestions = array();


//		$relation = new Model_Relation();
//		$test->questions = array();

		if ($id) {
			$test->loadById($id);

			if ($test->isRegOnly())
				if (!is_user_logged_in()) {
					$view->showMsg("Тест доступен только для зарегистрированых пользователей");
					return;
				}

			// load questions with tpe type
			foreach($question->getObjectListByTestIdAndType($id, nvModel::TYPE_TPE) as $ques) {
				$answers = $answer->getObjectListByQuestionIdAndTestId($ques->id, $id);
				$ques->answers = $answers;
				$tpeQuestions[] = $ques;
			}

			// load questions with functionality type
			foreach($question->getObjectListByTestIdAndType($id, nvModel::TYPE_FUNCTIONAL) as $ques) {
				$answers = $answer->getObjectListByQuestionIdAndTestId($ques->id, $id);
				$ques->answers = $answers;
				$funcQuestions[] = $ques;
			}
		}

		// randomize question
		shuffle($tpeQuestions);
		shuffle($funcQuestions);

		// $view->test = $test;
		// $view->questions = array_merge($tpeQuestions, $funcQuestions);
		// $view->questions = $tpeQuestions;
		$this->before();
		$this->template->content = $view->bind('test', $test)
										->bind('questions', array_merge($tpeQuestions, $funcQuestions));
		// $this->template->content = $view->bind('id', $id);
											
		$this->after();
	} 

	/**
	 * Using to invoke frontend js and css including
	 */
	public function enqueueJsCss() {

		$this->loadStaticFiles();
	}

	public function loadJsCssLibs() {

		$url  = $this->url;
		// load additional libs
		// bootstrap
		wp_enqueue_style('nv_bootstrap', $url . 'includes/libs/bootstrap/css/bootstrap.min.css');
		wp_enqueue_script(
			'nv_bootstrap',
			$url . 'includes/libs/bootstrap/js/bootstrap.min.js',
			array('jquery') // dependens
		);


		// fancybox
		wp_enqueue_style('nv_fancybox', $url . 'includes/libs/fancybox/jquery.fancybox.css');
		wp_enqueue_script(
			'nv_fancybox',
			$url . 'includes/libs/fancybox/jquery.fancybox.js',
			array('jquery') // dependens
		);

		// init the libs
		wp_enqueue_script(
			'nv_initlibs',
			$url . 'assets/js/nonverbal-init-libs.js',
			array('jquery')
		);
	}

	/**
	 * Load frontend js and css files
	 */
	public function loadStaticFiles() {

		$url = $this->url;

		// load basic css for front view
		wp_enqueue_style(
			'nonverbal-front-style',
			$url . 'assets/css/nonverbal-front.css'
		);

		// load js engine - for passing the test
		wp_enqueue_script(
			'nonverbal-front',
			$url . 'assets/js/nonverbal-front.js',
			array('jquery')
		);

		// setup translation for js
		wp_localize_script(
			'nonverbal-front', 
			'localize', 
			array(
				'ajaxurl' => admin_url('admin-ajax.php?lang='.get_locale()),
				'__TPE' => __('TPE', 'nonverbal-test'),
				'__Functional' => __('Functional', 'nonverbal-test'),
				'__repeatTestTitle' => __('Repeat testing', 'nonverbal-test'),
				'__cant_find_tpe_subtype' => __('Subtype TPE is not found. It is recommended to repeat the test again.', 'nonverbal-test'),
				'__cant_find_leading_tpe' => __('The leading type TPE is not defined. It is recommended to repeat the test again.', 'nonverbal-test'),
				'__cant_load_tpe_quadras' => __('Can\'t Load Tpe Quadras', 'nonverbal-test'),
				'__failed_load_result' => __('Error! Failed to load the result', 'nonverbal-test')

			)
		);
	}
}

?>