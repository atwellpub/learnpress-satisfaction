<?php
/**
 * Plugin load class.
 *
 * @author   ThimPress
 * @package  LearnPress/Fill-In-Blank/Classes
 * @version  3.0.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'LP_Addon_Satisfaction' ) ) {

	/**
	 * Class LP_Addon_Satisfaction
	 */
	class LP_Addon_Satisfaction extends LP_Addon {
		/**
		 * LP_Addon_Satisfaction constructor.
		 */
		public function __construct() {
			parent::__construct();

			/* update question answer meta */
			add_action( 'learn-press/question/updated-answer-data', array(
				$this,
				'update_question_answer_meta'
			), 10, 3 );

		}


		/**
		 * Update needed answer meta.
		 *
		 * @param int $question_id
		 * @param int $answer_id
		 * @param mixed $answer_data
		 */
		public function update_question_answer_meta( $question_id, $answer_id, $answer_data ) {

			if (!isset($answer_data['extra_settings']) || !$answer_data['extra_settings']) {
				return;
			}

			$question = LP_Question::get_question( $question_id );

			foreach ( $answer_data['extra_settings'] as $key => $value ) {
				$question->_extra_settings[ $key ] = $value;
			}

			learn_press_update_question_answer_meta( $answer_id, '_extra_settings', $answer_data['extra_settings'] );

		}

		/**
		 * Define Learnpress Satisfaction constants.
		 *
		 * @since 3.0.0
		 */
		protected function _define_constants() {
			if ( ! defined( 'LP_ADDON_SATISFACTION_PATH' ) ) {
				define( 'LP_ADDON_SATISFACTION_PATH', dirname( LP_ADDON_SATISFACTION_FILE ) );
				define( 'LP_ADDON_SATISFACTION_ASSETS', LP_ADDON_SATISFACTION_PATH . '/assets/' );
				define( 'LP_ADDON_SATISFACTION_INC', LP_ADDON_SATISFACTION_PATH . '/inc/' );
				define( 'LP_ADDON_SATISFACTION_TEMPLATE', LP_ADDON_SATISFACTION_PATH . '/templates/' );
			}
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 */
		protected function _includes() {
			include_once LP_ADDON_SATISFACTION_INC . 'class-lp-question-satisfaction.php';
			include_once LP_ADDON_SATISFACTION_INC . 'functions.php';
		}

		/**
		 * Hook into actions and filters.
		 *
		 * @since 3.0.0
		 */
		protected function _init_hooks() {
			add_filter( 'learn_press_question_types', array( __CLASS__, 'register_question' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			add_filter( 'learn-press/admin/external-js-component', array( $this, 'add_external_component_type' ) );

			// js template for admin editor
			add_action( 'edit_form_after_editor', array( $this, 'js_template' ) );

			// add vue component tag to quiz editor
			add_action( 'learn-press/quiz-editor/question-js-component', array( $this, 'quiz_question_component' ) );
		}

		/**
		 * Enqueue assets.
		 *
		 * @since 3.0.0
		 */
		public function enqueue_scripts() {
			if ( is_admin() ) {
				$assets = learn_press_admin_assets();
				$assets->enqueue_script( 'satisfaction-js', $this->get_plugin_url( 'assets/js/admin.satisfaction.js' ), array( 'jquery' ) );
			} else {
				$assets = learn_press_assets();
				$assets->enqueue_style( 'lp-satisfaction-question-css', $this->get_plugin_url( 'assets/css/satisfaction.css' ) );
			}
		}

		/**
		 * Register question to Learnpress list question types.
		 *
		 * @since 3.0.0
		 *
		 * @param $types
		 *
		 * @return mixed
		 */
		public static function register_question( $types ) {
			$types['satisfaction'] = __( 'Satisfaction', 'learnpress-satisfaction' );

			return $types;
		}

		/**
		 * Fill in blank question JS Template for admin quiz and question.
		 */
		public function js_template() {
			learn_press_satisfaction_admin_view( 'answer-quiz-editor' );
		}

		/**
		 * Add questions type has js external component.
		 *
		 * @param $types
		 *
		 * @return array
		 */
		public function add_external_component_type( $types ) {
			$types[] = 'satisfaction';

			return $types;
		}


		/**
		 * Add Vue component to admin quiz editor.
		 */
		public function quiz_question_component() { ?>
            <lp-quiz-satisfaction-question-answer v-if="question.type.key == 'satisfaction'"
                                         :question="question"></lp-quiz-satisfaction-question-answer>
		<?php }
	}
}

add_action( 'plugins_loaded', array( 'LP_Addon_Satisfaction', 'instance' ) );