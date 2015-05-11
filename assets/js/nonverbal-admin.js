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
		}
	};

	// initialization 
	function init() {

		$('input, textarea').change(function () {
			$(this).removeClass('highlight-input highlight-textarea');
		});
	}
	
	// 
	// Test Operation
	// 
	
	// Add new Test handler
	$('#but_add_test').click(function () {
		$(".new_test_block").toggle('medium');
	});

	// Create test button handler
	$('#but_create_test').click(function (e) {

		var testName = $('#text_new_test_name');

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
						tools.addRowNewTest(result.value, testName.val());
					}
				} else {
					tools.loadingMsg('hide');
					alert("Ошибка! Не удалось создать тест.");
				}
			});
			// 
			// jQuery.ajax({
			// 	url : glob.ajaxurl,
			// 	method: 'GET',
			// 	data : 'action=wp_treetest_create_tes&test_name="' + testName.val() + '"',
			// 	success: function(html) {
			// 		console.log(html);
			// 	},
			// 	error : function() {
			// 		console.log("error with ajax");
			// 	}
			// });

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
	$('#treetest-answer-add').click(function (e) {

		var answer_rows = $('.answer_rows'); // answers div container
		var cloneable = $('#cloneable');
		var clone;
		var rand = tools.rand();

		clone = cloneable.clone();
		clone.find('#treetest-answer-value').attr('name', "answers[new][" + rand + "][value]");
		clone.find('#treetest-answer').attr('name', "answers[new][" + rand + "][text]");
		// put to container
		clone.appendTo(answer_rows);
		clone.attr('id', '');
		clone.show();
		
	});

	// Remove, added answer field
	$("#treetest-answer-remove").live('click', function() {

		var isDelete = confirm('Are You Sure?');
		var name = $(this).parent().find('input').attr('name');

		if (!isDelete) {
			e.preventDefault();
			return false;
		} else {
			// change name - answers[exists][some_id] to answers[remove][some_id]
			name = name.replace("exists", "remove");
			// set replaced name
			$(this).parent().find('input').attr('name', name);
			// clean value
			$(this).parent().find('input').val('');
			$(this).parent().hide();
		}

		return true;

	});

	//
	// Statistic
	//

	// Show more info
	$(".btn_more_info").click(function (){
		var id = $(this).attr("id");
		$('#'+id+'.more_info_block').toggle();

	});

	// Remove statistic item
	$(".btn_romove_statistic").click(function() {

		// get statistic item id
		var id = $(this).attr("id");


		if (confirm("Вы действительно хотите удалить результат?")){

			tools.loadingMsg('show');
			$.post(glob.ajaxurl, { id: id, action: "wp_treetest_remove_result"}, function(result, status) {
				if (status == 'success') {
					tools.loadingMsg('hide');
					if (result.status == 'error') {
						alert(result.value);
					} else if (result.status == 'success') {

						$('tr#'+id).remove();
						$('#'+id+'.more_info_block').remove();
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
	
	function tinyMCE_init(){
		 // quicktags({id : 'text'});
		  tinyMCE.init({
    		skin : "simple",
	        mode:"textareas"
    });
    		// other options here
  // });
            //init tinymce
         // tinymce.init(tinyMCEPreInit.mceInit['text']);
	};

	// main test menu action
	$('a.ajax-call').live('click', function(e) {

		e.preventDefault();
		var action = $(this).attr("href");

		if (action.indexOf("delete") > -1) {
			if (confirm("Вы действительно хотите удалить?")) {

			} else {
				return;
			}
			
		}

		tools.loadingMsg('show');
		$.post(glob.ajaxurl, { action : 'nonverbal_test_menu_action', request: action}, function(result, status) {

			$('.nv-content').html(result);

			if ( $( "textarea#text" ).length ) {
 
 				tinyMCE_init();
    			alert("textarea exists");
 
			}




			// tinymce.init(tinyMCEPreInit.mceInit['text']);

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
		
		var action = $(this).attr('action');
		var params = $(this).serialize();
		// log(action+params);
		action = action + '&' + params;

		tools.loadingMsg('show');
		$.post(glob.ajaxurl, { action : 'nonverbal_test_menu_action', request: action}, function(result, status) {

			$('.nv-content').html(result);

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
	
});