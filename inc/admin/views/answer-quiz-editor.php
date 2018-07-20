<?php
/**
 * Admin quiz editor: satisfaction question answer template.
 *
 * @since 3.0.0
 */

?>

<script type="text/x-template" id="tmpl-lp-quiz-satisfaction-question-answer">
    <div class="admin-quiz-satisfaction-question-editor">
        <div style="text-align: left"><b>Quiz Labels:</b></div>
        <br>
        <ol class="satisfaction-settings" style="text-align:left">
            <li class="satisfaction-option">
                <input type="text" id="label_1" v-model="extra_settings.label_1" class="satisfaction-input">
            </li>
            <li class="satisfaction-option">
                <input type="text" id="label_2" v-model="extra_settings.label_2" class="satisfaction-input">
            </li>
            <li class="satisfaction-option">
                <input type="text" id="label_3" v-model="extra_settings.label_3" class="satisfaction-input">
            </li>
            <li class="satisfaction-option">
                <input type="text" id="label_4" v-model="extra_settings.label_4" class="satisfaction-input">
            </li>
            <li class="satisfaction-option">
                <input type="text" id="label_5" v-model="extra_settings.label_5" class="satisfaction-input">
            </li>
            <li class="satisfaction-option">
                <input type="text" id="label_6" v-model="extra_settings.label_6" class="satisfaction-input">
            </li>
        </ol>
        <div class="lp-list-questions">
            <table class="lp-list-options">
                <thead>
                <tr>
                    <th class="answer-text"><?php esc_html_e( 'Questions', 'learnpress' ); ?></th>
                    <th class="actions"><?php esc_html_e( 'Actions', 'learnpress' ); ?></th>
                </tr>
                </thead>
                <tbody class="ui-sortable answer_options" >
                <tr v-for='(question, index) in extra_settings.answer_options'>
                    <td class=''><input type="text" name="answer_options[]" v-model="question.value"></td>
                    <td class='actions'><button class="button remove-question-option-button" type="button"
                            @click="deleteOption"><?php esc_html_e( 'Delete', 'learnpress' ); ?></button></td>
                </tr>
                </tbody>
            </table>
        </div>
        <p class="question-button-actions">
            <button class="button add-question-option-button" type="button"
                @click="newOption"><?php esc_html_e( 'Add option', 'learnpress' ); ?></button>
            <button class="button save-question-option-button" type="button"
                @click="updateAnswer"><?php esc_html_e( 'Save Options', 'learnpress' ); ?></button>
        </p>
    </div>
</script>

<script type="text/javascript">


    function isJSON(str) {
        try {
            return (JSON.parse(str) && !!str);
        } catch (e) {
            return false;
        }
    }


    /**
     * The following jQuery code is used to handle deleting dynamically created elements. I coudln't discver the appropriate Vue way to handle this.
     */
    jQuery('body').on('click' , '.remove-question-option-button' , function() {
        jQuery(this).parent().parent().remove();
    });

    /**
     * Begin Vue
     */
    (function (Vue, $store, $) {
        var init = function() {

            console.log('init');
            console.log(this.question);

        }
        Vue.component('lp-quiz-satisfaction-question-answer', {
            template: '#tmpl-lp-quiz-satisfaction-question-answer',
            props: ['question'],
            data: function () {
                return {
                    extra_settings: [],
                    answer_options: []
                }
            },
            computed: {
                answer: function () {
                    return {
                        answer_order: 1,
                        is_true: '',
                        question_answer_id: String(this.question.answers[0].question_answer_id),
                        text: this.question.answers[0].text,
                        value: ''
                    };
                }
            },
            methods: {
                deleteOption: function() {
                },
                updateAnswer: function () {
                    var answer = JSON.parse(JSON.stringify(this.answer));
                    var options = this.getOptions();
                    answer.text = JSON.stringify(options);
                    answer.extra_settings = options;

                    $store.dispatch('lqs/updateQuestionAnswerTitle', {
                        question_id: this.question.id,
                        answer: answer
                    });
                },
                getOptions: function() {

                    /* create new variables and prepare them */
                    var extra_settings = {}
                    extra_settings.answer_options = [];

                    /* define question block to search inside */
                    var search = '[data-item-id="'+this.question.id+'"]';

                    /* get general settings */
                    jQuery( search + ' .satisfaction-option .satisfaction-input').each(function() {
                        var id = jQuery(this).attr('id');
                        var value = jQuery(this).val();
                        extra_settings[id] = value;
                    });

                    /* get answer options */
                    i = 0;
                    jQuery( search + ' .answer_options tr').each(function() {
                        var value = jQuery(this).find('input').val();
                        extra_settings.answer_options[i] = {};
                        extra_settings.answer_options[i].value = value;
                        i = i + 1;
                    });

                    console.log('extra_settings');
                    console.log(extra_settings);

                    return extra_settings;
                },
                defaultOptions: function() {

                    /* load extra_settings if exists */
                    var json = this.question.answers[0].text;
                    if (isJSON(json)) {
                        var extra_settings = JSON.parse(json);
                        this.extra_settings = extra_settings;
                    } else {
                        this.extra_settings = {};
                        this.extra_settings.label_1 = "1 - Very Satisfied"
                        this.extra_settings.label_2 = "1 - Somewhat Satisfied"
                        this.extra_settings.label_3 = "3 - Neither Satisfied or Dissatisfied"
                        this.extra_settings.label_4 = "4 - Somewhat Dissatisfied"
                        this.extra_settings.label_5 = "5 - Very Dissatisfied"
                        this.extra_settings.label_6 = "N/A"
                        this.extra_settings.answer_options = [];
                    }

                },
                // new answer option
                newOption: function () {

                    /* get table/tbody of appropriate question */
                    var answer_options_table = jQuery('[data-item-id="'+this.question.id+'"]').find('.answer_options');

                    /* get current order */
                    var order = 1;

                    /* create new empty elements */
                    var option_tr = jQuery('<tr></tr>');

                    /* col 1 */
                    var option_td_text = jQuery('<td></td>');
                    var option_td_text_input = jQuery('<input type="text" name="answer_options[]" >');
                    option_td_text_input.appendTo(option_td_text);

                    /* col 2 */
                    var option_td_actions = jQuery('<td></td>');
                    var option_td_delete = jQuery('<button class="button remove-question-option-button" type="button" >delete</button>')
                    option_td_delete.appendTo(option_td_actions);

                    /* build appendable element */
                    option_td_text.appendTo(option_tr);
                    option_td_actions.appendTo(option_tr);

                    /* append to answer_options table */
                    option_tr.appendTo(answer_options_table);

                }
            },
            created: function () {
                init.apply(this);
                this.defaultOptions();

                /* update on load in case this is the very first load */
                setTimeout(function( e ) {
                    e.updateAnswer();
                } , 1000, this )
            }

        })
    })(Vue, LP_Quiz_Store, jQuery);

</script>
