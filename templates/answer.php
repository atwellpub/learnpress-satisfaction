<?php
/**
 * Template for displaying answer of satisfaction question.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/satisfaction/content-question/answer.php.
 *
 * @author   ThimPress
 * @package  LearnPress/Fill-In-Blank/Templates
 * @version  3.0.1
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

isset( $question ) or die( __( 'Invalid question!', 'learnpress-satisfaction' ) );

$quiz = LP_Global::course_item_quiz();

if ( ! $answers = $question->get_answers() ) {
	return;
}

$question->setup_data( $quiz->get_id() );

//error_log(print_r($quiz,true));
foreach ( $answers as $k => $answer ) {
	//error_log(print_r($answer,true));
	$json =  $answer->get_title('display');
	$answer_settings = json_decode($json , true);
	break;
}


$user = LP_Global::user();
$quiz = LP_Global::course_item_quiz();
$answer = $question->get_answered();
$answer = str_replace('__SKIPPED__' , '' , $answer);
$answer = json_decode($answer,true);
if (!$answer) {
	$answer = array();
}

?>
<div class="question-type-satisfaction">
    <div class="question-options-<?php echo $question->get_id(); ?> question-passage">

		<?php if ( $user->has_completed_quiz( $quiz->get_id() ) || $user->has_checked_question($question->get_id(), $quiz->get_id()) ) {  ?>

			<table>
				<thead>
				<th></th>
				<th><?php echo $answer_settings['label_1']; ?></th>
				<th><?php echo $answer_settings['label_2']; ?></th>
				<th><?php echo $answer_settings['label_3']; ?></th>
				<th><?php echo $answer_settings['label_4']; ?></th>
				<th><?php echo $answer_settings['label_5']; ?></th>
				<th><?php echo $answer_settings['label_6']; ?></th>
				</thead>
				<tbody id="answer-tbody">
				<?php

				foreach ($answer_settings['answer_options'] as $key=>$option) {
					?>
					<tr>
						<td class="lp-satisfaction-question" ><?php echo $option['value']; ?></td>
						<td class="lp-satisfaction-option">
							<input disabled class="answer-option" data-tr-id="<?php echo $key; ?>" value="1" type="radio" name="answer_options[<?php echo $key; ?>]['selected']" <?php echo ( (isset($answer[$key]['selected']) && $answer[$key]['selected'] == 1) ||  !isset($answer[$key]['selected'])) ? "checked='checked'" : "" ; ?>
						</td>
						<td class="lp-satisfaction-option">
							<input disabled class="answer-option" value="2"  type="radio" name="answer_options[<?php echo $key; ?>]['selected']" <?php echo (isset($answer[$key]['selected']) && $answer[$key]['selected'] == 2 ) ? "checked='checked'" : "" ; ?>
						</td>
						<td class="lp-satisfaction-option">
							<input disabled class="answer-option" value="3"  type="radio" name="answer_options[<?php echo $key; ?>]['selected']" <?php echo (isset($answer[$key]['selected']) && $answer[$key]['selected'] == 3 ) ? "checked='checked'" : "" ; ?>
						</td>
						<td class="lp-satisfaction-option">
							<input disabled class="answer-option" value="4"  type="radio" name="answer_options[<?php echo $key; ?>]['selected']" <?php echo (isset($answer[$key]['selected']) && $answer[$key]['selected'] == 4 ) ? "checked='checked'" : "" ; ?>
						</td>
						<td class="lp-satisfaction-option">
							<input disabled class="answer-option" value="5"  type="radio" name="answer_options[<?php echo $key; ?>]['selected']" <?php echo (isset($answer[$key]['selected']) && $answer[$key]['selected'] == 5 ) ? "checked='checked'" : "" ; ?>
						</td>
						<td class="lp-satisfaction-option">
							<input disabled class="answer-option" value="6"  type="radio" name="answer_options[<?php echo $key; ?>]['selected']" <?php echo (isset($answer[$key]['selected']) && $answer[$key]['selected'] == 6 ) ? "checked='checked'" : "" ; ?>
						</td>
					</tr>
					<?php
				}
				?>
				</tbody>
			</table>
		<?php } else { ?>

			<input type="hidden" id="answer_options" name="learn-press-question-<?php echo $question->get_id(); ?>"
				class="answer-options satisfaction <?php echo (!empty($class)?' '.join(' ', $class):'')?>"/>
			<table>
				<thead>
					<th></th>
					<th><?php echo $answer_settings['label_1']; ?></th>
					<th><?php echo $answer_settings['label_2']; ?></th>
					<th><?php echo $answer_settings['label_3']; ?></th>
					<th><?php echo $answer_settings['label_4']; ?></th>
					<th><?php echo $answer_settings['label_5']; ?></th>
					<th><?php echo $answer_settings['label_6']; ?></th>
				</thead>
				<tbody id="answer-tbody">
				<?php

				foreach ($answer_settings['answer_options'] as $key=>$option) {
					?>
					<tr>
						<td class="lp-satisfaction-question" ><?php echo $option['value']; ?></td>
						<td class="lp-satisfaction-option">
							<input class="answer-option" data-tr-id="<?php echo $key; ?>" value="1" type="radio" name="answer_options[<?php echo $key; ?>]['selected']" <?php echo ( (isset($answer[$key]['selected']) && $answer[$key]['selected'] == 1) ||  !isset($answer[$key]['selected'])) ? "checked='checked'" : "" ; ?>
						</td>
						<td class="lp-satisfaction-option">
							<input class="answer-option" value="2"  type="radio" name="answer_options[<?php echo $key; ?>]['selected']" <?php echo (isset($answer[$key]['selected']) && $answer[$key]['selected'] == 2 ) ? "checked='checked'" : "" ; ?>
						</td>
						<td class="lp-satisfaction-option">
							<input class="answer-option" value="3"  type="radio" name="answer_options[<?php echo $key; ?>]['selected']" <?php echo (isset($answer[$key]['selected']) && $answer[$key]['selected'] == 3 ) ? "checked='checked'" : "" ; ?>
						</td>
						<td class="lp-satisfaction-option">
							<input class="answer-option" value="4"  type="radio" name="answer_options[<?php echo $key; ?>]['selected']" <?php echo (isset($answer[$key]['selected']) && $answer[$key]['selected'] == 4 ) ? "checked='checked'" : "" ; ?>
						</td>
						<td class="lp-satisfaction-option">
							<input class="answer-option" value="5"  type="radio" name="answer_options[<?php echo $key; ?>]['selected']" <?php echo (isset($answer[$key]['selected']) && $answer[$key]['selected'] == 5 ) ? "checked='checked'" : "" ; ?>
						</td>
						<td class="lp-satisfaction-option">
							<input class="answer-option" value="6"  type="radio" name="answer_options[<?php echo $key; ?>]['selected']" <?php echo (isset($answer[$key]['selected']) && $answer[$key]['selected'] == 6 ) ? "checked='checked'" : "" ; ?>
						</td>
					</tr>
					<?php
				}
				?>
				</tbody>
			</table>
		<?php } ?>

		<?php if ( 'yes' === $question->show_correct_answers() ) { ?>
			<b>Your results:</b>
			<table>
				<thead>
				<th></th>
				<th><?php echo $answer_settings['label_1']; ?></th>
				<th><?php echo $answer_settings['label_2']; ?></th>
				<th><?php echo $answer_settings['label_3']; ?></th>
				<th><?php echo $answer_settings['label_4']; ?></th>
				<th><?php echo $answer_settings['label_5']; ?></th>
				<th><?php echo $answer_settings['label_6']; ?></th>
				</thead>
				<tbody id="answer-tbody">
				<?php

				foreach ($answer_settings['answer_options'] as $key=>$option) {
					?>
					<tr>
						<td class="lp-satisfaction-question" ><?php echo $option['value']; ?></td>
						<td class="lp-satisfaction-option">
							<input disabled class="answer-option" data-tr-id="<?php echo $key; ?>" value="1" type="radio" name="answer_options[<?php echo $key; ?>]['selected']" <?php echo ( (isset($answer[$key]['selected']) && $answer[$key]['selected'] == 1) ||  !isset($answer[$key]['selected'])) ? "checked='checked'" : "" ; ?>
						</td>
						<td class="lp-satisfaction-option">
							<input disabled class="answer-option" value="2"  type="radio" name="answer_options[<?php echo $key; ?>]['selected']" <?php echo (isset($answer[$key]['selected']) && $answer[$key]['selected'] == 2 ) ? "checked='checked'" : "" ; ?>
						</td>
						<td class="lp-satisfaction-option">
							<input disabled class="answer-option" value="3"  type="radio" name="answer_options[<?php echo $key; ?>]['selected']" <?php echo (isset($answer[$key]['selected']) && $answer[$key]['selected'] == 3 ) ? "checked='checked'" : "" ; ?>
						</td>
						<td class="lp-satisfaction-option">
							<input disabled class="answer-option" value="4"  type="radio" name="answer_options[<?php echo $key; ?>]['selected']" <?php echo (isset($answer[$key]['selected']) && $answer[$key]['selected'] == 4 ) ? "checked='checked'" : "" ; ?>
						</td>
						<td class="lp-satisfaction-option">
							<input disabled class="answer-option" value="5"  type="radio" name="answer_options[<?php echo $key; ?>]['selected']" <?php echo (isset($answer[$key]['selected']) && $answer[$key]['selected'] == 5 ) ? "checked='checked'" : "" ; ?>
						</td>
						<td class="lp-satisfaction-option">
							<input disabled class="answer-option" value="6"  type="radio" name="answer_options[<?php echo $key; ?>]['selected']" <?php echo (isset($answer[$key]['selected']) && $answer[$key]['selected'] == 6 ) ? "checked='checked'" : "" ; ?>
						</td>
					</tr>
					<?php
				}
				?>
				</tbody>
			</table>
			<span class="blank-status">(<?php echo __('This question accepts any answer'); ?>)</span>
		<?php } ?>
    </div>
</div>
<script>
	;(function ($) {
		"use strict";

		function _ready() {

			/**
			 * Whenever a user selects an option update the hidden text answer field with a json string
			 */
			jQuery('.answer-option').on('change' , function() {
				/* loop through elements and build object */
				var new_answer_options = [];
				var i = 0
				jQuery( '#answer-tbody tr').each(function() {

					new_answer_options[i] = {};
					var selected = jQuery(this).find(":checked");

					new_answer_options[i].value = jQuery(this).find('.lp-satisfaction-question').text();
					new_answer_options[i].selected = selected.val();
					i = i + 1;
				});

				var new_answer_options_json = JSON.stringify(new_answer_options)
				jQuery('#answer_options').val(new_answer_options_json)
				console.log("answer_options");
				console.log(new_answer_options);
			});

			/* trigger initial json build */
			jQuery('.answer-option[data-tr-id="0"]').trigger('change');


			jQuery('.lp-form button[type="submit"]').click(function(e) {

				if (jQuery(this).text()=='Prev') {
					return true;
				}

			})
		}

		$(document).ready(_ready);
	})(jQuery);
</script>
