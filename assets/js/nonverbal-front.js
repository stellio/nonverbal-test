jQuery(document).ready(function ($) {
	/*
	 Plugin Name: WP Tree Test
	 Plugin URI: http://www.stellio.org.ua
	 Description: A simple and powerfull plugin to make tree tests
	 Author: Lisovoy Igor
	 Author URI: http://www.stellio.org.ua
	 */

	/**
	 * JS Engine for "Socionics Test"
	 *
	 * Structure
	 *
	 * Models:
	 * - MSignGroup
	 * - enums and global var
	 * - models
	 * - view
	 * - controllers
	 * - main facade classs "SocionicsTest"
	 *
	 * View
	 */


	/**
	 * Basic Class
	 *
	 * Syntax:
	 * Class.extend(props)
	 * Class.extend(props, staticProps)
	 * Class.extend([mixins], props)
	 * Class.extend([mixins], props, staticProps)
	 */
	!function() {

		window.Class = function() { /* вся магия - в Class.extend */  };

		Class.extend = function(props, staticProps) {
			var mixins = [];

			// если первый аргумент -- массив, то переназначить аргументы
			if ({}.toString.apply(arguments[0]) == "[object Array]") {
				mixins = arguments[0];
				props = arguments[1];
				staticProps = arguments[2];
			}

			// эта функция будет возвращена как результат работы extend
			function Constructor() {
				this.init && this.init.apply(this, arguments);
			}

			// this -- это класс "перед точкой", для которого вызван extend (Animal.extend)
			// наследуем от него:
			Constructor.prototype = Class.inherit(this.prototype);
			// constructor был затёрт вызовом inherit
			Constructor.prototype.constructor = Constructor;
			// добавим возможность наследовать дальше
			Constructor.extend = Class.extend;
			// скопировать в Constructor статические свойства
			copyWrappedProps(staticProps, Constructor, this);
			// скопировать в Constructor.prototype свойства из примесей и props
			for (var i = 0; i < mixins.length; i++) {
				copyWrappedProps(mixins[i], Constructor.prototype, this.prototype);
			}
			copyWrappedProps(props, Constructor.prototype, this.prototype);

			return Constructor;
		};
		//---------- вспомогательные методы ----------
		// fnTest -- регулярное выражение,
		// которое проверяет функцию на то, есть ли в её коде вызов _super
		//
		// для его объявления мы проверяем, поддерживает ли функция преобразование
		// в код вызовом toString: /xyz/.test(function() {xyz})
		// в редких мобильных браузерах -- не поддерживает, поэтому регэксп будет /./
		var fnTest = /xyz/.test(function() {xyz}) ? /\b_super\b/ : /./;
		// копирует свойства из props в targetPropsObj
		// третий аргумент -- это свойства родителя
		//
		// при копировании, если выясняется что свойство есть и в родителе тоже,
		// и является функцией -- его вызов оборачивается в обёртку,
		// которая ставит this._super на метод родителя,
		// затем вызывает его, затем возвращает this._super
		function copyWrappedProps(props, targetPropsObj, parentPropsObj) {
			if (!props) return;

			for (var name in props) {
				if (typeof props[name] == "function"
					&& typeof parentPropsObj[name] == "function"
					&& fnTest.test(props[name])) {
					// скопировать, завернув в обёртку
					targetPropsObj[name] = wrap(props[name], parentPropsObj[name]);
				} else {
					targetPropsObj[name] = props[name];
				}
			}
		}

		// возвращает обёртку вокруг method, которая ставит this._super на родителя
		// и возвращает его потом
		function wrap(method, parentMethod) {
			return function() {
				var backup = this._super;

				this._super = parentMethod;

				try {
					return method.apply(this, arguments);
				} finally {
					this._super = backup;
				}
			}
		}

		// эмуляция Object.create для старых IE
		Class.inherit = Object.create || function(proto) {
			function F() {}
			F.prototype = proto;
			return new F;
		};
	}();


	// Enums
	var TYPES = { tpe: "1", func: "2"};

	// Objects
	var leadTpe = { first: "", second: ""};

	// Globals
	var glob = localize;
	var tr = localize;

	// Debug
	var log = function(msg) {
		console.log(msg);
	};

	var msg = function(text, info) {
		console.log(text + " " + info);
	};

	// tools
	function getTestId() {
		return $('.treetest').attr('id');
	};

	/**
	 *	Basic MVC classes
	 */
	
	/* Model */
	var Model = Class.extend({

		init: function() {
			this._observers = [];
		},

		addObserver : function(observer) {
			this._observers.push(observer);
		},

		notify : function() {
			for(var i = 0; i < this._observers.length; i += 1)
				this._observers[i].update();
		}	

	});

	/* View  */
	var View = Class.extend({

		init: function(model, view) {

			this._model = model;
			this._view = view;
		},

		update: function() {}
	});

	/* Controller */
	var Controller = Class.extend({

		init: function() {}
	})

	var Stack = Class.extend({

		init: function() {

			this._stack = [];
		},

		push: function(item) {

			var exists = false;
			// check if exists
			for(var i=0; i < this._stack.length; i+=1)
				if (item == this._stack[i])
					exists = true;

			if (!exists)
				this._stack.push(item);
		},

		pop: function() {
			return this._stack.pop();
		},

		peekLast: function() {

			var item = false;
			if (this._stack.length != 0)
				item = this._stack[this._stack.length-1];

			return item;

		},

		peekFirst: function() {
			var item = false;

			if (this._stack.length != 0)
				item = this._stack[0];
			return item;
		},

		size: function() {
			return this._stack.length;
		}
	});
	
	/**
	 * Apps Classes
	 */
	
	/* Models */
	var mTpe = Model.extend({

		init: function(code, name, signs) {
			this._super();

			this._signList = [];
			this._signsSequence = signs;
			this._code = code;
			this._name = name;
			this._points = 0;

		},

		pushSign: function(sign) {
			this._signList.push(sign);
		},

		addPoint: function() {

			this._points += 1;
			this.notify();
		}
	});

	var mTpeList = Model.extend({

		init: function() {
			this._super();

			this._tpeList = [];
			this._isLeadTpeFind = true;
			this._isSubTpeFind = true;

		},

		addTpe: function(tpe) {
			this._tpeList.push(tpe);
			this.notify();
		},

		removeTpe: function(code) {

			for(var i = 0; i < this._tpeList.length; i+=1) {
				if (this._tpeList[i]._code == code)
					this._tpeList.splice(i, 1);
			}
			this.notify();
		},

		addPoint: function(code) {

			for(var i = 0; i < this._tpeList.length; i+=1) {
				if (this._tpeList[i]._code == code) {
					this._tpeList[i].addPoint();
				}
			}
			this.notify();
		},

		countPoint: function() {
			for (var i=0; i < this.tpeList.length; i+=1) {
				this._tpeList[i].countPoint();
			}
		},

		findLastTpe: function() {

			var	list = this._tpeList,
				result = false;

			/* sor list by ascending */
			for (var i=0; i < list.length; i+=1)
				for (var j=0; j < list.length - 1; j+=1)
					if (list[j]._points > list[j+1]._points){
						var temp = list[j];
						list[j] = list[j+1];
						list[j+1] = temp;
					}

			if (list.length > 1){
				if (list[0]._points == list[1]._points)
					result = false;
				else
					result = list[0]._code;
			}

			return result;
		},

		findLeadTpe: function() {
		/* clean */

			var bigestPoint = 0,
				list = this._tpeList,
				leadTpe = '',
				subTpe = '';

			/* sor list by descensing */
			for (var i=0; i < list.length; i+=1)
				for (var j=0; j < list.length - 1; j+=1)
					if (list[j].points < list[j+1].points){
						var temp = list[j];
						list[j] = list[j+1];
						list[j+1] = temp;
					}


			// check if lead exists, but not present lead tpe with same points
			if (list.length > 1)
				if (list[0].points == list[1].points)
					this.isLeadTpeFind = false;
				else
					this.isLeadTpeFind = true;

			if (list.length > 2)
				if (list[1].points == list[2].points)
					this.isSubTpeFind = false;
				else
					this.isSubTpeFind = true;

			if (list.length > 1) {
				leadTpe = list[0].code;
				subTpe = list[1].code;
			}

			return [leadTpe, subTpe];
		},

		getAllTpe: function() { return this._tpeList },

		update:	function() {
			this.countPoint();
			this.findLeadTpe();
		}
	});

	var mSign = Model.extend({

		init: function() {

		}
	});

	var mSignGroup = Model.extend({

		init: function(shortName, type) {
			this._super();

			this._shortName = shortName;
			this._type = type;
			this._firstSign = null;
			this._secondSign = null;
			this._isEqual = false;
			this._leadSign = [];
		},

		addPoint: function(code) {
			if (this._shortName.indexOf(code) != -1) {
				if (this._firstSign.code == code) {
					this._firstSign.points += 1;

				} else if (this._secondSign.code == code) {
					this._secondSign.points += 1;
				}

				/* check is point equal */
				if (this._firstSign.points == this._secondSign.points)
					this._isEqual = true;
				else
					this._isEqual = false;

				/* find lead sign */
				this._leadSign = []; // clear

				if (this._firstSign.points < this._secondSign.points) {
					this._leadSign.push(this._secondSign);
				} else if (this._firstSign.points > this._secondSign.points) {
					this._leadSign.push(this_firstSign);
				} else {
					this._leadSign.push(this_firstSign);
					this._leadSign.push(this_secondSign);
				}

				this.notify();
			}
		}
	});

	var mProfile = Model.extend({

		init: function(code, name, type, signs) {
			this._super();

			this._signList = [];
			this._signsSequence = signs;
			this._code = code;
			this._name = name;
			this._type = type;
			this._points = 0;
		},

		connectSign: function(item) {
			this._signList.push(item);
		},

		connectProfile: function(item) {
			this._signList.push(item);
		},

		connectTpe: function(item) {
			this._signList.push(item);
		},

		countPoint: function() {
			this._points = 0;
			for (var i =0; i < this._signList.length; i+=1) {
				this._points += this._signList[i].points;
			}
			return this._points;
		}
	});

	var mProfilePair = Model.extend({

		init: function(){
			this._super();

			this._id = Math.floor((Math.random() * 10000) + 1);
			this._type = null;
			this._first = null;
			this._second = null;
			this._isEqual = false;
			this._lead = null;
		},

		addPoint: function(code) {

			if (this._first._code == code) {
				this._first._points += 1;

			} else if (this._second._code == code){
				this._second._points += 1;
			}

			/* check is first and second part has equal points */
			if (this._first._points == this._second._points)
				this._isEqual = true;
			else
				this._isEqual = false;

			/* find lead */
			this._lead = null;

			if (this._first._points < this._second._points) {
				this._lead = this._second._code;
			} else if (this._first._points > this._second._points)
				this._lead = this._first._code;

			this.notify();
		}
	})

	var mProfileList = Model.extend({

		init: function() {
			this._super();

			this._profiles = [];
			this._leadTpeProfile = [];
			this._leadFuncProfile = [];
		},

		addProfile: function(profile) {
			this._profiles.push(profile);
		},

		countPoint: function() {
			for (var i=0; i < this._profiles.length; i+=1) {
				this._profiles[i].countPoint();
			}
			this.findLeadTpeProfile();
			this.findLeadFuncProfile();
		},

		findLeadTpeProfile: function() {
			/* clean */
			this._leadTpeProfile = [];

			var bigestPoint = 0, 
				profile = null;

			/* find bigest tpe profile */
			for (var i=0; i < this._profiles.length; i+=1){
				if (this._profiles[i]._type == TYPES.tpe) {
					if (this._profiles[i].points > bigestPoint){
						profile = this._profiles[i];
						bigestPoint = profile.points;
					}
				}
			}

			/* wind other equal profiles to bigest profile */
			for (var i=0; i < this._profiles.length; i+=1) {
				if (this._profiles[i]._type == TYPES.tpe) {
					if (this._profiles[i]._points == bigestPoint) {
						this._leadTpeProfile.push(this._profiles[i]);
					}
				}
			}

			return this._leadTpeProfile;
		},

		findLeadFuncProfile: function() {

			/* clean */
			this._leadFuncProfile = [];

			var bigestPoint = 0,
				profile = null;

			/*  find bigest func profile */
			for (var i=0; i < this._profiles.length; i+=1) {
				if (this._profiles[i]._type == TYPES.func) {
					if (this._profiles[i]._points > bigestPoint){
						profile = this._profiles[i];
						bigestPoint = profile.points;
					}
				}
			}
			/* find other equal profiles to bigest profile */
			for (var i=0; i < this._profiles.length; i+=1) {
				if (this._profiles[i]._type == TYPES.func) {
					if (this._profiles[i]._points == bigestPoint) {
						this._leadFuncProfile.push(this._profiles[i]);
					}
				}
			}
			return this._leadFuncProfile;
		},

		update: function() {
			this.countPoint();
			this.notify();
		}
	});

	var mRelationNode = Model.extend({

		init: function(code, childs) {
			this._super();

			this._code = ''
			this._childs = childs;
		},

		setChilds: function(val) {
			this._childs = val;
		},

		getChilds: function() {
			return this._childs;
		}


	});

	var mRelation = Model.extend({

		init: function(code, childs) {
			this._super();

			this._code = code;
			this._childs = typeof childs !== 'undefined' ? childs : [];
			this._points;
		},

		getCode: function() {
			return this._code;
		},

		getChildByCode: function (code) {

			for(var i=0; i < this._childs.length; i+=1)
				if (this._childs[i]._code = code)
					return this._childs[i];
		},

		getChilds: function() {
			return this._childs;
		}

	});

	var mRelations = Model.extend({

		init: function() {
			this._super();

			this._relations = [];
		},

		loadRelations: function(list) {
			for(var i=0; i < list.length; i+=1){
				var relation = new mRelation(
					list[i].code,
					list[i].childs
				);
				this._relations.push(relation);
			}
			this.notify();
		},

		getChildsByCode: function(code) {

			var result = false;
			for(var i=0; i < this._relations.length; i+=1) {
				if (this._relations[i]._code == code){
					if (this._relations[i]._childs.length != 0)
						result = this._relations[i]._childs;
				}
			}

			return result;
		},

		getCodes: function() {
			var result = [];

			for (var i = 0; i < this._relations.length; i+=1){
				result.push(this._relations[i]._code);
			}
			return result;
		}
	});

	var mQuestion = Model.extend({

		init: function() {
			this._super();

			this._id = 0;
			this._type = 0;
			this._cycle = 0;
			this._answers_codes = "";

		}
	});

	var mResult = Model.extend({

		init: function() {
			this._super();

			this._tpe = new Stack();
			this._profile = new Stack();
		}
	});

	/* Views */
	var vTpes = View.extend({

		init: function(model, view) {
			this._super(model, view);
		},

		update: function() {
			this.renderAsColorBar()
		},

		renderAsColorBar: function() {

			var ration = 0,
				totalPoints = 0,
				charts = '',
				list = this._model.getAllTpe(),
				color = "#3f5d88",
				tpeColors = {};

			/* count summ of points */
			for (var i = 0; i < list.length; i++) {
				totalPoints += list[i]._points;
			}
			ration = totalPoints / 100;

			charts += "<div class='progress'>";
			for (var i = 0; i < list.length; i++) {
				var percent = list[i]._points / ration;

				if (list[i]._code.indexOf("EG") != -1) {
					color = "#e74c3c";
				}
				if (list[i]._code.indexOf("ID") != -1) {
					color = "#2ecc71";
				}
				if (list[i]._code.indexOf("SG") != -1) {
					color = "#9b59b6";
				}
				if (list[i]._code.indexOf("SID") != -1) {
					color = "#2980b9";
				}

				charts += "<div class='progress-bar progress-bar-info' role='progressbar' style='width: " + (percent) + "%; background-color:" + color + "'>" +
				percent.toFixed(0) + "% - " + list[i]._name +
				"</div>";

			}
			charts += "</div>";
			this._view.html(charts);
		}


	});

	/* ProfilePair view */
	var vProfilePair = View.extend({

		init: function(model, view) {
			this._super(model, view);

			this._firstSize = 0;
			this._secondSize = 0;
		},

		countSize: function() {
			var sizeRation = (this._model._first._points + this._model._second._points) / 100;
			this._firstSize = (this._model._first._points != 0) ? this._model._first._points / sizeRation: 0;
			this._secondSize = (this._model._second._points != 0) ? this._model._second._points / sizeRation : 0;
		},

		render: function() {
			var pair = "<div class='progress-bar progress-bar-info' style='float: left; width: "+this._firstSize+"%; color: rgb(72, 85, 86); background-color: #ecf0f1;'>" +
				this._firstSize.toFixed(0) + "% - " + this._model._first._name +"</div>" +
				"<div class='progress-bar progress-bar-danger' style='float: right;width: "+this._secondSize+"%; color: white;background-color: #7f8c8d;'>" +
				this._secondSize.toFixed(0) + "% - " + this._model._second._name +"</div>" +
				"<div style='clear: both;'></div>";
			this._view.html(pair)
		},

		update: function() {
			this.countSize();
			this.render();
		}
	});

	/* Controller */
	var cQuestionIter = Controller.extend({

		init: function(questionList, block, prefix){

			this._block = block;
			this._msgBlock = $('.treetest-msg-block');
			this._questionsList = questionList;
			this._questionClassPrefix = prefix;
			this._currentQuestionNumber = 0;
			this._questionIdSequence = [];

			//this.collectIds();
		},

		collectIds: function() {
			var self = this;
			this._block.children('div').each(function() {
				self._questionIdSequence.push($(this).attr('id'));
			})
		},

		first: function() {

			log('start first');

			if (this._questionsList.length > this._currentQuestionNumber)
				this._block.find('.'+this._questionClassPrefix+this._questionsList[this._currentQuestionNumber].id).show('slow');
			else
			    this.msg("No more questions!");

		},

		next: function() {
			var status = false;

			this._block.find('.'+this._questionClassPrefix+this._questionsList[this._currentQuestionNumber].id).hide('slow');
			this._currentQuestionNumber +=1;

			/* check is end of questions */
			if (this._questionsList.length > this._currentQuestionNumber) {
				status = true;
				this._block.find('.'+this._questionClassPrefix+this._questionsList[this._currentQuestionNumber].id).show('slow');
			}

			return status;
		},

		isAnswerSet: function() {
			var questId = this._questionClassPrefix + this._questionsList[this._currentQuestionNumber].id;
			// check if radio button checked
			if ($("input:radio[name='" + questId + "']").is(':checked')) {
				return true;
			} else {
				return false;
			}
		},

		msg: function(text) {
			this._msgBlock.html("<div class='alert alert-danger' role='alert'>"+text+"</div>");
		}

	});

	// Stacks
	var sResults = Stack.extend({

		init: function() {
			this._super();
		}
	})


	/* Test Class */
	var TestStages = { tpe: 1, func: 2 };

	var NonverbalTest = Class.extend( {

		init: function(id) {

			this._id = id;
			this._stage = null;

			/* State variables */
			this._answer = { id: "", profiletype: ""};
			this._questionCycleNumber = 0;
			this._currentProfilePair = null;
			this._currentRelations = null;
			this._currentQuestion = null;
			this._questionIter = null;

			this._isAnswerSet = false;


			/* Lists */
			this._signsList = [];
			this._relationList = [];
			this._profileList = [];
			this._signsGroups = [];
			this._profileViewList = [];
			this._profilePairList = [];

			this._questionList = [];
			this._currentQuestionList = [];
			this._ignoredTpeList = [];


			// result
			this._result = new mResult();
			this._twoLeadTpe = new Stack();

			/* Binds */

			// objects
			this._leadTpe = leadTpe;

			// models classes
			this._tpeList = new mTpeList();
			this._tpeListData = new mTpeList();
			this._mRelations = new mRelations();

				// views classes
			this._viewTpes = new vTpes(this._tpeList, $('.treetest-tpe-block'));
			this._tpeList.addObserver(this._viewTpes);

			// Msg
			this._msgBlock = $('.treetest-msg-block');

			// Functionality profiles div
			this._profilesDiv = $('.treetest-profiles-block');

			// Description
			this._descriptionBlock = $('.treetest-description');

			// Question
			this._questionsDiv = $('.treetest-question-block');
			this._questionsIdPrefix = 'question_id_';

			// Result
			this._resultsBlock = $('.treetest-result-block');
			this._resultSpace = $('.treetest-result-space');

			// Repeat
			this._repeatTestBlock = $('.treetest-repeat-test');

			// Debug
			this._debugMode = false;
			this._debugBlock = $('.treetest-debug-block');
		},

		start: function() {

			this._stage = TestStages.tpe;

			this.hideTestDescription();

			if (this._debugMode) {
				this._debugBlock.show();
			}

			log(this._questionList);

			this._questionCycleNumber = 1;
			this.findQuestion(TYPES.tpe, this._questionCycleNumber);
            //
			this._questionIter = new cQuestionIter(
				this._currentQuestionList,
				this._questionsDiv,
				this._questionsIdPrefix
			);

			this._questionIter.first();
		},

		stop: function() {


		},

		finnished: function() {
			//alert('finnished');
			this._resultsBlock.show();
		},

		terminate: function(text) {

			log(text);
			this._questionsDiv.hide();
			this._repeatTestBlock.show();

		},

		nextCycle: function() {

			this._questionCycleNumber +=1;
			this.findQuestion(TYPES.tpe, this._questionCycleNumber);

			if (this._currentQuestionList.length == 0) {
				this.terminate("cant find lead tpe");
				return;
			}

			this._questionIter = new cQuestionIter(
				this._currentQuestionList,
				this._questionsDiv,
				this._questionsIdPrefix
			);

			this._questionIter.first();
		},

		addProfilePairView: function(pair) {

			log('add');
			var className = pair._id;
			var progressBar = "<div style='width: 100%;' id='" + className + "' class='progress treetest-sign-group-percentline'></div>";

			this._profilesDiv.append(progressBar);

			var view = new vProfilePair(pair, $('#' + className));
			view.render();
			pair.addObserver(view);
			this._profileViewList.push(view);

		},

		/* Points */
		addPoint: function() {

			if (this._isAnswerSet) {
				var code = this._answer.id;
				var type = this._answer.profiletype;

				if (type == TYPES.tpe) {
					this._tpeList.addPoint(code);
					this._tpeListData.addPoint(code);

				} else if (type == TYPES.func) {

					for (var i = 0; i < this._profilePairList.length; i+=1 ){

						this._profilePairList[i].addPoint(code);
					}
				}
			}
		},

		countPoints: function() {

			//log('countPoints Func');

			if (this._stage == TestStages.tpe) {

				if (this._tpeListData.findLastTpe()){

					var code = this._tpeListData.findLastTpe();

					// add tpe code to result, as profile sequences
					this._result._tpe.push(code);

					this._tpeListData.removeTpe(code);
					this._ignoredTpeList.push(code);

					if (this._tpeListData._tpeList.length == 1){

						this.tpeFinded({
							first: this._tpeListData._tpeList[0]._code,
							second: code
						});



					} else {
						this.nextCycle();
					}

				} else {
					this.nextCycle();
				}

			} else if(this._stage == TestStages.func) {

				if (this._currentProfilePair._lead != null){
					this._result._profile.push(this._currentProfilePair._lead);
					log(this._currentProfilePair._lead);
					this.continueFunctionalityPart();

				} else {
					this.terminate("Неудалось определить функциональный профиль");
					return;
				}
			}
		},

		/* Description */
		hideTestDescription: function() {
			this._descriptionBlock.hide();
		},

		/* Questions and Answers methods */
		tpeFinded: function(leadTpe) {

			this._leadTpe = leadTpe;
			log(leadTpe);

			this._twoLeadTpe.push(leadTpe.second);
			this._twoLeadTpe.push(leadTpe.first);;

			this._result._tpe.push(leadTpe.second);
			this._result._tpe.push(leadTpe.first);

			// add

			// switch stage
			this.continueFunctionalityPart();
		},

		buildFunctionalityPair: function(codes) {
			var finded = [];

			// find functionality profiles by codes
			for (var i = 0; i < this._profileList.length; i+=1){
				var isMatch = false;

				for (var j = 0; j < codes.length; j+=1) {
					if (this._profileList[i]._code == codes[j])
						isMatch = true;
				}

				// make model and put to list
				if (isMatch)
					finded.push(this._profileList[i]);
			}

			// check if find two profile
			if (finded.length > 1) {

				var pair = new mProfilePair();

				pair._first = finded[0];
				pair._second = finded[1];

				this._currentProfilePair = pair;

				this._profilePairList.push(pair);
				this.addProfilePairView(pair);

			}
		},

		continueFunctionalityPart: function(){

			var relationArray = null;

			if (this._stage == TestStages.tpe) {
				relationArray = this._mRelations.getChildsByCode(this._twoLeadTpe.pop());

			} else {
				msg("peek last profile: ", this._result._profile.peekLast());
				relationArray = this._currentRelations.getChildsByCode(this._result._profile.peekLast());

				if (!relationArray) {
					relationArray = this._mRelations.getChildsByCode(this._twoLeadTpe.pop());

				}
			}


			if (relationArray){
				this._stage = TestStages.func;
				this._currentRelations = new mRelations();
				this._currentRelations.loadRelations(relationArray);


			} else {
				log("Тест закончился");
				this.finnished();
				return;
			}


			log(this._currentRelations);

			var relationCodes = this._currentRelations.getCodes();
			//log('relations codes:');
			//log(relationCodes);
			this.findFunctionalityQuestions(TYPES.func, relationCodes);

			this._questionIter = new cQuestionIter(
				this._currentQuestionList,
				this._questionsDiv,
				this._questionsIdPrefix
			);

			this.buildFunctionalityPair(relationCodes);
			this._questionIter.first();
		},

		setAnswer: function(answer) {
			if (answer.id && answer.profiletype) {
				this._answer = answer;
				this._isAnswerSet = true;

			}
		},

		nextQuestion: function() {

			if (this._isAnswerSet) {
				if (this._questionIter.next()) {
				} else {
					//this.finnished();
					log('questions end. countPoint. Find lead');
					this.countPoints();
				}

				this._isAnswerSet = false;
			} else {
				alert("Выберите ответ!");
			}
		},

		/* Tools */
		ignored: function(code) {

			var ignored = false;

			for(var i = 0; i < this._ignoredTpeList.length; i+=1){
				if (this._ignoredTpeList[i] == code)
					ignored = true;
			}

			return ignored;
		},

		findQuestion: function(type, cycle) {

			log("before");
			this._currentQuestionList = [];

			log(this._currentQuestionList);

			for(var i = 0; i < this._questionList.length; i+=1) {
				if (type == this._questionList[i].type) {
					if (cycle == this._questionList[i].cycle) {

						var answers = this._questionList[i].answers_code;
						if (Object.prototype.toString.call(answers) === '[object Array]') {
							if (answers.length > 0) {

								var isMatch = false;

								for (var j = 0; j < answers.length; j += 1) {
									if (this.ignored(answers[j]))
										isMatch = true;
								}

								if (!isMatch) this._currentQuestionList.push(this._questionList[i]);
							}
						}
					}
				}
			}

			log("after");
			log(this._currentQuestionList );
		},

		findFunctionalityQuestions: function(type, codes){

			this._currentQuestionList = [];

			for(var i = 0; i < this._questionList.length; i+=1){
				if (type == this._questionList[i].type){

					var answers = this._questionList[i].answers_code;
					if (Object.prototype.toString.call(answers) == '[object Array]') {
						if (answers.length > 0){

							var isMatch = false;

							for(var j = 0; j < answers.length; j += 1){
								for (var k = 0; k < codes.length; k +=1){
									if (answers[j] == codes[k])
										isMatch = true;
								}
							}
							if (isMatch)
								this._currentQuestionList.push(this._questionList[i]);
						}
					}
				}
			}
			log(this._currentQuestionList);
		},

		showMsg: function(text) {
			this._msgBlock.html("<div class='alert alert-danger' role='alert'>"+text+"</div>");
		},

		loadTestData: function() {

			var self = this;
			$.post(glob.ajaxurl, { id: this._id, action: "nonverbal_test_get_test_structure"}, function(result, status) {

				log(result);

				// return;
				/* load sigs groups */
				if (result['signsGroups']) {
					self.buildSingsGroups(result['signsGroups']);
				} else {
					log('cant load groups');
				}

				/* load tpe */
				if (result['tpelist']) {
					self.buildTpeList(result['tpelist']);
					//log(result['tpelist']);
				} else {
					self.showMsg(tr.__cant_load_tpe_quadras);
					//self.terminate();
				}

				/* load profiles */
				if (result['profiles']) {
					self.buildProfiles(result['profiles']);
				} else {
					log('cant load profiles');
				}

				// is debug set
				if (result['debugMode'] == 1) {
					self._debugMode = true;
				}

				// questions
				if (result['questions']) {
					self._questionList = result['questions'];
				} else {
					self.showMsg("Can't load questions");
				}

				// relations
				if (result['relations']) {
					self.buildRelations(result['relations']);
				} else {
					self.showMsg("Can't load relations");
				}

			});

		},

		loadResultData: function(id, formValues) {

			log(id);
			var self = this,
				params = [];

			// add test_id
			params.push("test_id=" 	+ id);

			// get tpe codes
			while (this._result._tpe.size() != 0)
				params.push("tpe[]=" + this._result._tpe.pop());

			// get profile codes
			while (this._result._profile.size() != 0)
				params.push("profile[]=" + this._result._profile.pop());

			params.push("action=nonverbal_test_get_result");

			$.ajax({
				type: "POST",
				url : glob.ajaxurl,
				data: params.join("&") + "&" + formValues
			}).done(function(result) {

				if (result) {
					self._resultSpace.html(result);
					self._debugBlock.show();
					self._repeatTestBlock.show();
				} else {
					this.showMsg(tr.__failed_load_result);
				}
			});

		},
		
		/* Builders */
		buildSingsGroups: function(groups) {
			for(var i=0; i < groups.length; i+=1) {

				var group = new mSignGroup(
					groups[i].shortName,
					groups[i].gType
				);
				group.firstSign = groups[i].firstSign;
				group.secondSign = groups[i].secondSign;
				this._signsList.push(group.firstSign);
				this._signsList.push(group.secondSign);
				this._signsGroups.push(group);
			}
			// this.connectSignGroupViews();
		},

		buildTpeList: function(list) {

			for(var i=0; i < list.length; i+=1) {

				var tpe = new mTpe(
					list[i].code,
					list[i].name,
					list[i].sequenceSign.split(',')
				);

				//connect sign to tpe if this sign in sings sequence of profile
				//for (var j=0; j < this._signsList.length; j+=1) {
					//if (list[i].sequenceSign.indexOf(this._signsList[j].code) != -1) {
					//	tpe.connectSign(this._signsList[j]);
					//}
				//}
				this._tpeList.addTpe(tpe);
				this._tpeListData.addTpe(tpe);
			}

			//this.connectTpeList();
		},

		buildRelations: function(list){

			this._mRelations = new mRelations();
			this._mRelations.loadRelations(list);
			log(this._mRelations);
		},

		buildProfiles: function(list) {

			for (var i = 0; i < list.length; i += 1){

				var profile = new mProfile(
					list[i].code,
					list[i].name,
					list[i].pType,
					list[i].sequenceSign.split(',')
				);

				this._profileList.push(profile);
			}

			log(this._profileList);
		}

	});

	/* Init test and connect ui */
	function getTestId() {
		return $('.treetest').attr('id');
	}

	/* Main Test */
	var Test = new NonverbalTest(getTestId());

	// load data
	Test.loadTestData();


	/* Ui */
	$('.treetest-start-test').click( function () {
		$(this).hide();
		Test.start();
	});


	$("button#treetest-answer-button").click(function () {
		//log("answer click");
		Test.setAnswer({
			id: $(this).val(),
			profiletype: $(this).attr('profiletype')
		});
		Test.addPoint();
		Test.nextQuestion();
	});

	// SurveyFrom
	$('form#survey-form').submit(function(e) {

		var testId = $('.submit-form').attr('id');
		log(testId);

		if (testId) {
			Test.loadResultData(testId, $(this).serialize());
		} else {
			alert(tr.__failed_load_result);
		}

		setTimeout(function() {
			$.TreeTestfancybox.close();
		}, 1000);
		e.preventDefault();
	})

});