jQuery(document).ready(function ($) {
	/*
		Plugin Name: WP Tree Test
		Plugin URI: http://www.stellio.org.ua
		Description: A simple and powerfull plugin to make tree tests
		Author: Lisovoy Igor
		Author URI: http://www.stellio.org.ua
	*/
	var glob = localize;

	function log(val) { console.log(val)};
	

	/* helpful tools */
	var tools = {

		addRowNewTest : function(id, name) {

			var html = '<tr>\
	            <td>'+name+'</td>\
	            <td>[treetest '+id+']</td>\
	            <td>\
	                <a href="admin.php?page=TreeTest&action=edit&id='+id+'">Редактировать</a>\
	                <a title="Show Statistic" href="admin.php?page=TreeTest&module=Statistic&test_id='+id+'">Статистика</a>\
	                <a class="treetest-delete-test" href="admin.php?page=TreeTest&action=delete&id='+id+'">Удалить</a>\
	            </td>\
	            <td>Черновик</td>\
	        </tr>';



	        $('tbody#the-list').append(html);
		},

		highlight : function (element) {
			if (element.is('input')) 
			{
				$(element).addClass('highlight-input');
			} 
			else if (element.is("textarea")) 
			{
				$(element).addClass('highlight-textarea');		
			}
		},

		isEmpty : function (element) {

			if ($.trim(element.val()).length) {
				return false;
			}
			else {
				return true;
			}
		},

		stopWithMsg : function (event, msg, element) {

			tools.highlight(element);
			alert(msg);
			event.preventDefault();
		},

		rand : function () {
			return Math.floor(Math.random() * (1000 - 3 + 1)) + 3;
		},

		loadingMsg : function(type) {

			if (type == 'show') {
				$('div.wrap').prepend("<div style='z-index: 9999;' class='loading-ajax'></div>");
			} else if (type == 'hide') {
				$('div.wrap').find("div.loading-ajax").remove();
			}
		},

		optGroupFilterInit : function() {

		    $("#filterActivity").change(function () {

		    	alert("change");

		        $("#filterSubActivity").children("optgroup").children().prop("disabled", "disabled").prop("selected", false);
		        var arr = $(this).val();

		        // var text = $("#filterActivity option[value='" + arr + "']").text()

		        log(arr);

		        $('select#'+ arr).show().attr('name', 'code');
		        $('select#2').hide().attr('name', '');

		        //get options that are not selected
		        // var arr1 = $('#filterActivity option:not(:selected)');

		        // log(arr1[1].value);
		        // log(arr2[1].value);
		        //get the ones that are selected
		        // var arr2 = $('#filterActivity').find(":selected");

		        // for (var i = 0; i < arr.length; i++) {
		            // $("#filterSubActivity").children("optgroup[label='" + text + "']").children().prop("disabled", false).prop("selected", "selected").show();
		        // }

		        //hide optgroups in subactivity
		        // for (var j = 0; j < 3; j++) {
		            // $("#filterSubActivity").children("optgroup").hide();
		        // }

		        // show the ones that are selected
		        // for (var k = 0; k < arr2.length; k++) {
		            // $("#filterSubActivity").children("optgroup[label='" + text + "']").show();
		        // }

		        $("#filterSubActivity").focus();
		    });

		},

		/* Question part */
		questionTypeInit : function() {

			$('#type').change( function() {

				if ($(this).val() == 2)
					$('.cycle').hide();
				else 
					$('.cycle').show();
			});
		}

	};

	// initialization 
	function init() {

		$('input, textarea').change(function () {
			$(this).removeClass('highlight-input highlight-textarea');
		});
	}
	

	// FlatUI
	function FlatUI_init() {

		// select
		$("select").select2({dropdownCssClass: 'dropdown-inverse'});

		// tags input
		$(".tagsinput").tagsinput();

		
	}


	// 
	// Test Operation
	// 
	
	// Add new Test handler
	$('#nonverbal_add_test').click(function () {
		$(".nonverbal_new_test").toggle('medium');
	});

	// Create test button handler
	$('#nonverbal_create_test').click(function (e) {

		var testName = $('#nonverbal_test_name');

		if (tools.isEmpty(testName)) {
			tools.stopWithMsg(e, "Пожалуйста введите название теста", testName);
			return false;
		} else {
			tools.loadingMsg('show');
			$.post(glob.ajaxurl, { test_name: testName.val(), action: "nonverbal_test_create_test"}, function(result, status) {
				if (status == 'success') {
					tools.loadingMsg('hide');
					if (result.status == 'error') {
						alert(result.value);
					} else if (result.status == 'success') {
						location.reload();
					}
				} else {
					tools.loadingMsg('hide');
					alert("Ошибка! Не удалось создать тест.");
				}
			});
		}
	});

	
	// click handler for delete test button
	$('.treetest-delete-test').click(function (e) {

		var isDelete = confirm('Are You Sure?');

		if (!isDelete) {
			e.preventDefault();
			return false;
		}

		return true;

	});

	// check if input fields not empty before save
	$('#treetest-save-test').click(function (e) {

		var input = $('#treetest-test-name');
		/* var textarea = $('textarea[name="description"]'); */

		if (tools.isEmpty(input)) {
			
			tools.stopWithMsg(e, 'Field is Empty!', input);
			return false;
		}

		/*if (tools.isEmpty(textarea)) {

			tools.stopWithMsg(e, 'Field is Empty!', textarea);
			return false;
		} */

		return true;
	});


	// 
	// Question Operation
	// 
	
	// Add answer field - by copying cloneable hidden input
	$('#treetest-answer-add').live('click', function (e) {

		log('add click');

		var answer_rows = $('.answer_rows'); // answers div container
		var cloneable = $('#cloneable');
		var clone;
		var rand = tools.rand();

		clone = cloneable.clone();
		clone.find('#treetest-answer-value').attr('name', "answers[new][" + rand + "][value]");
		clone.find('#treetest-answer').attr('name', "answers[new][" + rand + "][text]");
		// put to container
		clone.find('#treetest-answer-value').select2({dropdownCssClass: 'dropdown-inverse'});
		clone.find('.col-md-4').children(":first").hide();
		clone.appendTo(answer_rows);
		clone.attr('id', '');
		clone.show();

		
	});

	// Remove, exists answer field
	$("#treetest-answer-remove").live('click', function(e) {

		e.preventDefault();

		if (confirm('Are You Sure?')) {
			
			var name = $(this).parent().parent().find('#first').find('select').attr('name');
			var input_name = $(this).parent().parent().find('#second').find('input').attr('name');

			log(name);
			
			// change name - answers[exists][some_id] to answers[remove][some_id]
			name = name.replace("exists", "remove");
			input_name = input_name.replace("exists", "remove");

			log(name);
			
			// set replaced name
			// change select
			$(this).parent().parent().find('#first').find('select').attr('name', name);
			$(this).parent().parent().find('#first').find('select').val('');

			// change input
			$(this).parent().parent().find('#second').find('input').attr('name', input_name);
			$(this).parent().parent().find('#second').find('input').val('');			
			
			$(this).parent().parent().hide();
			// return true;

		} else {
			return;
		}
	});


	//
	// Result
	//


	$("#func_profile").live('change', function(){

		var input = $("#func_input").val(),
			selectedValue = $(this).val(),
			value = null;

		if (input == "")
			input = [];
		else
			input = input.split(",");

		if (selectedValue != null) {
			for (var i = 0; i < selectedValue.length; i+=1) {
				if (input.indexOf(selectedValue[i]) == -1){
					input.push(selectedValue[i]);
				}
			}
		} else {
			input = [];
		}

		for (var j = 0; j < input.length; j+=1) {

			if (selectedValue != null){
				if (selectedValue.indexOf(input[j]) == -1){
					input.splice(i, 1);
				}
			}
		}
		$('#func_input').val(input.join(','));
	});

	//
	// Statistic
	//

	// Show more info
	$(".btn_non_more_info").live('click', function (){
		var id = $(this).attr("id");
		$('#'+id+'.non_more_info_block').toggle();
	});

	// Remove statistic item
	$(".btn_non_romove_statistic").click(function() {

		// get statistic item id
		var id = $(this).attr("id");


		if (confirm("Вы действительно хотите удалить результат?")){

			tools.loadingMsg('show');
			$.post(glob.ajaxurl, { id: id, action: "nonverbal_test_remove_result"}, function(result, status) {
				if (status == 'success') {
					tools.loadingMsg('hide');
					if (result.status == 'error') {
						alert(result.value);
					} else if (result.status == 'success') {

						$('tr#'+id).remove();
						$('#'+id+'.non_more_info_block').remove();
					}
				} else {
					tools.loadingMsg('hide');
					alert("Ошибка! Не удалось удалить результат.");
				}
			});
		}
	});

	/**
	 * Ajax Calls
	 */
	
	/* switch buttons */
	$('.ajax-checkbox').click(function() {

		var bool = $(this).is(':checked');
		var param = $(this).attr('param');
		var id = $(this).attr('testid');

		if (param != 'undefined' && id != 'undefined') {

			tools.loadingMsg('show');
			$.post(glob.ajaxurl, { id: id, param: param, state:bool, action: "nonverbal_test_settings"}, function(result, status) {

				if (status == 'success') {
					tools.loadingMsg('hide');
					if (result.status == 'error') {
						alert(result.value);
					} else if (result.status == 'success') {

					}
				} else {
					tools.loadingMsg('hide');
					alert("Ошибка! Не удалось изменить опцию.");
				}
			});
		}
				

	});
	
	function tinyMCE_init(){
		 // quicktags({id : 'text'});
		  tinyMCE.init({
	        selector: "textarea",
	        // toolbar1: 'bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,wp_fullscreen,wp_adv',
	        // toolbar2: 'formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help',
		  	// keep_styles: true,
		  	skin : 'wp_theme',
	        

    });
    		// other options here
  // });
            //init tinymce
         // tinymce.init(tinyMCEPreInit.mceInit['text']);
	};

	$('a.confirm').live('click', function(e) {

		if (!confirm("Вы действительно хотите удалить?"))
			e.preventDefault();
	}) ;

	// main test menu action
	$('a.ajax-call').live('click', function(e) {

		e.preventDefault();
		var cmd = $(this).attr("href");

		if (cmd.indexOf("delete") > -1) {
			if (confirm("Вы действительно хотите удалить?")) {

			} else {
				return;
			}
			
		}

		tools.loadingMsg('show');
		$.post(glob.ajaxurl+ "?" + cmd, { action : 'nonverbal_test_menu_action'}, function(result, status) {

			$('.nv-content').html(result);

			FlatUI_init();
			tools.optGroupFilterInit();
			tools.questionTypeInit();


			if ( $( "textarea#text" ).length ) {
 
 				tinyMCE_init();
 				log("tinyMCE_init");
 
			}

			if (status == 'success') {
				tools.loadingMsg('hide');

				if (result.status == 'error') {
					alert(result.value);
				} else if (result.status == 'success') {

					$('.nv-content').html(result.value);
				} else {
					tools.loadingMsg('hide');

				}
			}
		});
	});

	$('button.ajax-call').live('click', function(e) {

		e.preventDefault();
		var cmd = $(this).attr("href");

		if (cmd.indexOf("delete") > -1) {
			if (confirm("Вы действительно хотите удалить?")) {

			} else {
				return;
			}
			
		}

		tools.loadingMsg('show');
		$.post(glob.ajaxurl+ "?" + cmd, { action : 'nonverbal_test_menu_action'}, function(result, status) {

			$('.nv-content').html(result);

			FlatUI_init();
			tools.optGroupFilterInit();
			tools.questionTypeInit();


			if ( $( "textarea#text" ).length ) {
 
 				tinyMCE_init();
 				log("tinyMCE_init");
 
			}

			if (status == 'success') {
				tools.loadingMsg('hide');

				if (result.status == 'error') {
					alert(result.value);
				} else if (result.status == 'success') {

					$('.nv-content').html(result.value);
				} else {
					tools.loadingMsg('hide');

				}
			}
		});
	});

	// test forms action
	$('form.ajax-call').live('submit', function(e) {

		e.preventDefault();
		
		var cmd = $(this).attr('action');
		var params = $(this).serialize();
		// log(action+params);
		cmd = cmd + '&' + params;

		tools.loadingMsg('show');
		$.post(glob.ajaxurl + "?" + cmd, { action : 'nonverbal_test_menu_action'}, function(result, status) {

			$('.nv-content').html(result);

			FlatUI_init();
			tools.optGroupFilterInit();
			tools.questionTypeInit();

			if ( $( "textarea#text" ).length ) {
 
 				tinyMCE_init();
 				log("tinyMCE_init");
 
			}

			if (status == 'success') {
				tools.loadingMsg('hide');

				if (result.status == 'error') {
					alert(result.value);
				} else if (result.status == 'success') {

					$('.nv-content').html(result.value);
				} else {
					tools.loadingMsg('hide');

				}

			}

		});
	});

	// init some function
	init();
	tools.optGroupFilterInit();
	
});