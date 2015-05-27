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

	/**
	 *
	 *
	 *
	 */



	// Enums
	var Type = { tpe: "1", func: "2"};

	// Globals
	var glob = localize;
	var tr = localize;

	// Debug
	var log = function(msg) {
		console.log(msg);
	};

	function getTestId() {
		return $('.treetest').attr('id');
	}
	/*
	 SignGroup Model
	 */
	function MSignGroup(shortName, gType) {
		this.shortName = shortName;
		this.gType = gType;
		this.firstSign = null;
		this.secondSign = null;
		this.observers = [];
		this.isEqual = false;
		this.leadSign = [];

		this.addPoint = function(code) {
			if (this.shortName.indexOf(code) != -1) {
				if (this.firstSign.code == code) {
					this.firstSign.points += 1;

				} else if (this.secondSign.code == code) {
					this.secondSign.points += 1;
				}

				/* check is point equal */
				if (this.firstSign.points == this.secondSign.points)
					this.isEqual = true;
				else
					this.isEqual = false;

				/* find lead sign */
				this.leadSign = []; // clear

				if (this.firstSign.points < this.secondSign.points) {
					this.leadSign.push(this.secondSign);
				} else if (this.firstSign.points > this.secondSign.points) {
					this.leadSign.push(this.firstSign);
				} else {
					this.leadSign.push(this.firstSign);
					this.leadSign.push(this.secondSign);
				}

				this.notify();
			}
		};

		this.notify = function() {
			this.observers.forEach(function(observer) { observer.update(); })
		};

		this.addObserver = function(observer) {
			this.observers.push(observer);
		};
	}

	/*
	 SignGroup View
	 */
	function VSignGroup(model, container) {
		this.model = model;
		this.conteiner = container;
		this.fSize = 0;
		this.sSize = 0;

		this.countSize = function() {
			var sizeRation = (model.firstSign.points + model.secondSign.points) / 100;
			this.fSize = (model.firstSign.points != 0) ? model.firstSign.points / sizeRation: 0;
			this.sSize = (model.secondSign.points != 0) ? model.secondSign.points / sizeRation : 0;
		};

		this.render = function () {
			var group = "<div class='progress-bar progress-bar-info' style='float: left; width: "+this.fSize+"%; color: rgb(72, 85, 86); background-color: #ecf0f1;'>" +
				this.fSize.toFixed(0) + "% - " + this.model.firstSign.name +"</div>" +
				"<div class='progress-bar progress-bar-danger' style='float: right;width: "+this.sSize+"%; color: white;background-color: #7f8c8d;'>" +
				this.sSize.toFixed(0) + "% - " + this.model.secondSign.name +"</div>" +
				"<div style='clear: both;'></div>";
			this.conteiner.html(group);
		};

		this.update = function() {
			this.countSize();
			this.render();
		}
	}

	/**
	 * Model Tpe
	 */
	function MTpe(code, name, components) {
		this.componentList = [];
		this.sequenceOfComponents = components;
		this.code = code;
		this.name = name;
		this.points = 0;

		this.connectSign = function(sign) {
			this.componentList.push(sign);
		};

		this.countPoint = function() {
			this.points = 0;
			for (var i =0; i < this.componentList.length; i+=1) {
				this.points += this.componentList[i].points;
			}
			return this.points;
		}
	}

	/**
	 * List of Tpe Models
	 */
	function MTpeList() {
		this.tpeList = [];
		this.observers = [];
		this.isLeadTpeFind = true;
		this.isSubTpeFind = true;

		this.addTpe = function(tpe) {
			this.tpeList.push(tpe);
		}

		this.addObserver = function(observer) {
			this.observers.push(observer);
		}

		this.notify = function() {
			this.observers.forEach(function (observer) { observer.update();});
		}

		this.countPoint = function() {
			for (var i=0; i < this.tpeList.length; i+=1) {
				this.tpeList[i].countPoint();
			}
		}

		this.findLeadTpe = function() {
			/* clean */

			var bigestPoint = 0,
				list = this.tpeList,
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


			// check if exist lead, but not present lead tpe with same points
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
		};


		this.getAllTpe = function() { return this.tpeList };

		this.update = function() {
			this.countPoint();
			this.findLeadTpe();
			this.notify();
		}
	}

	/*
	 Profile Model
	 */
	function MProfile(code, name, pType, sequence) {
		this.signList = [];
		this.sequenceOfSign = sequence;
		this.code = code;
		this.name = name;
		this.pType = pType;
		this.points = 0;

		this.connectSign = function(sign) {
			this.signList.push(sign);
		};

		this.connectProfile = function(profile) {
			this.signList.push(profile);
		}

		this.connectTpe = function(item) {
			this.signList.push(item);
		}

		this.countPoint = function() {
			this.points = 0;
			for (var i =0; i < this.signList.length; i+=1) {
				this.points += this.signList[i].points;
			}
			return this.points;
		}
	}

	/*
	 Profiles Model
	 */
	function MProfiles() {
		this.profiles = [];
		this.observers = [];
		this.leadTpeProfile = [];
		this.leadFuncProfile = [];

		this.addProfile = function(profile) {
			this.profiles.push(profile);
		}

		this.addObserver = function(observer) {
			this.observers.push(observer);
		}

		this.notify = function() {
			this.observers.forEach(function (observer) { observer.update();});
		}

		this.countPoint = function() {
			for (var i=0; i < this.profiles.length; i+=1) {
				this.profiles[i].countPoint();
			}
			this.findLeadTpeProfile();
			this.findLeadFuncProfile();
		}

		this.findLeadTpeProfile = function() {
			/* clean */
			this.leadTpeProfile = [];

			var bigestPoint = 0;
			var profile = null;

			/* find bigest tpe profile */
			for (var i=0; i < this.profiles.length; i+=1){
				if (this.profiles[i].pType == Type.tpe) {
					if (this.profiles[i].points > bigestPoint){
						profile = this.profiles[i];
						bigestPoint = profile.points;
					}
				}
			}

			/* wind other equal profiles to bigest profile */
			for (var i=0; i < this.profiles.length; i+=1) {
				if (this.profiles[i].pType == Type.tpe) {
					if (this.profiles[i].points == bigestPoint) {
						this.leadTpeProfile.push(this.profiles[i]);
					}
				}
			}

			return this.leadTpeProfile;
		};

		this.findLeadFuncProfile = function() {

			/* clean */
			this.leadFuncProfile = [];

			var bigestPoint = 0;
			var profile = null;

			/*  find bigest func profile */
			for (var i=0; i < this.profiles.length; i+=1) {
				if (this.profiles[i].pType == Type.func) {
					if (this.profiles[i].points > bigestPoint){
						profile = this.profiles[i];
						bigestPoint = profile.points;
					}
				}
			}
			/* find other equal profiles to bigest profile */
			for (var i=0; i < this.profiles.length; i+=1) {
				if (this.profiles[i].pType == Type.func) {
					if (this.profiles[i].points == bigestPoint) {
						this.leadFuncProfile.push(this.profiles[i]);
					}
				}
			}
			return this.leadFuncProfile;
		};

		this.update = function() {
			this.countPoint();
			this.notify();
		}
	}

	/*
	 	Tpe quadras view
	 */
	function VTpeList(model, block) {
		this.model = model;
		this.tpeBlock = block;

		this.update = function() {
			//this.render();
			//this.renderAll();
			// this.renderAsBar();
			this.renderAsColorBar();
		}

		this.render = function() {
			var view = '';
			for (var i=0; i < this.model.leadTpe.length; i+=1) {
				view += "<div>"+this.model.leadTpe[i].name +":<b>"+this.model.leadTpe[i].points+"</b></div>";
			}

			this.tpeBlock.html(view);
		}

		this.renderAll = function() {

			var view = '',
				list = this.model.getAllTpe();

			for (var i=0; i < list.length; i+=1) {
				view += "<div>" + list[i].name + ":<b>" + list[i].points + "</b></div>";
			}

			this.tpeBlock.html(view);
		}

		this.renderAsBar = function() {

			var ration = 0,
				totalPoints = 0,
				charts = '',
				list = model.getAllTpe();


			/* count summ of points */
			for (var i=0; i < list.length; i++) {
				totalPoints += list[i].points;
			}
			ration = totalPoints / 100;

			charts += "<div class='progress'>";
			for (var i=0; i < list.length; i++) {
				var percent = list[i].points / ration;
				var barType = (i % 2)? "bar-success" : "bar-warning";
				charts +=	"<div class='progress-bar progress-"+barType+"' role='progressbar' style='width: "+(percent)+"%'>" +
				percent.toFixed(0) + "% - " + list[i].name +
				"</div>";

			}
			charts += "</div>";
			this.tpeBlock.html(charts);
		}

		this.renderAsColorBar = function() {

			var ration = 0,
				totalPoints = 0,
				charts = '',
				list = model.getAllTpe(),
				color = "#3f5d88",
				tpeColors = {
				};

			/* count summ of points */
			for (var i=0; i < list.length; i++) {
				totalPoints += list[i].points;
			}
			ration = totalPoints / 100;

			charts += "<div class='progress'>";
			for (var i=0; i < list.length; i++) {
				var percent = list[i].points / ration;
				
				log(list[i].code);

				if (list[i].code.indexOf("TEG") != -1) {
					color = "#e74c3c";
				}
				if (list[i].code.indexOf("TID") != -1) {
					color = "#2ecc71";
				}
				if (list[i].code.indexOf("TSEG") != -1) {
					color = "#9b59b6";
				}
				if (list[i].code.indexOf("TSID") != -1) {
					color = "#2980b9";
				}

				charts +=	"<div class='progress-bar progress-bar-info' role='progressbar' style='width: "+(percent)+"%; background-color:"+ color +"'>" +
				percent.toFixed(0) + "% - " + list[i].name +
				"</div>";

			}
			charts += "</div>";
			this.tpeBlock.html(charts);
		}
	}

	/*
	 Profiles View
	 */
	function VProfiles(model, block) {
		this.model = model;
		this.profilesBlock = block;

		this.update = function() {
			this.render();
		}

		this.render = function() {
			var profiles = '';
			for (var i=0; i < this.model.leadTpeProfile.length; i+=1) {

				/* if (this.model.profiles[i].pType == Type.tpe) */
				if (true)
					profiles += "<div>"+this.model.leadTpeProfile[i].name +":"+this.model.leadTpeProfile[i].points+"</div>";
			}

			for (var i=0; i < this.model.profiles.length; i+=1) {
				if (this.model.profiles[i].pType == Type.func)
					profiles += "<div>"+this.model.profiles[i].name +":"+this.model.profiles[i].points+"</div>";
			}
			this.profilesBlock.html(profiles);
		}
	}

	/*
	 Progress bar chart
	 */
	function VProfilesChart(model, block) {
		this.model = model;
		this.profilesBlock = block;

		this.update = function() {
			this.render();
		}

		this.render = function() {
			var ration = 0;
			var totalPoints = 0;
			var charts = '';
			var profiles = [];

			/* find all tpe profiles */
			for (var i=0; i < this.model.profiles.length; i+=1) {

				if (this.model.profiles[i].pType == Type.tpe)
					profiles.push(this.model.profiles[i]);
				/* charts += "<div>"+this.model.profiles[i].name +":"+this.model.profiles[i].points+"</div>"; */
			}

			/* count summ of points */
			for (var i=0; i < profiles.length; i++) {
				totalPoints += profiles[i].points;
			}
			ration = totalPoints / 100;

			charts += "<div class='progress'>";
			for (var i=0; i < profiles.length; i++) {
				var percent = profiles[i].points / ration;
				var barType = (i % 2)? "bar-success" : "bar-warning";
				charts +=	"<div class='progress-bar progress-"+barType+"' role='progressbar' style='width: "+(percent)+"%'>" +
				profiles[i].name +
				"</div>";

			}
			charts += "</div>";
			this.profilesBlock.html(charts);
		}
	}

	/* Questions Iterator */
	function QuestionIter(block, prefix) {
		this.block = block;
		this.itemClassPrefix = prefix;
		this.currentQuestionNumber = 0;
		this.questionIdSequence = [];

		var self = this;
		block.children('div').each(function() {
			self.questionIdSequence.push($(this).attr('id'));
		});

		this.showFirst = function() {
			this.block.find('.'+this.itemClassPrefix+this.questionIdSequence[this.currentQuestionNumber]).show('slow');
		}

		this.next = function() {
			this.block.find('.'+this.itemClassPrefix+this.questionIdSequence[this.currentQuestionNumber]).hide('slow');
			this.currentQuestionNumber +=1;
			this.block.find('.'+this.itemClassPrefix+this.questionIdSequence[this.currentQuestionNumber]).show('slow');
			/* check is end of questions */
			if (this.questionIdSequence.length > this.currentQuestionNumber)
				return true;
			else
				return false;
		}

		this.back = function () {
			this.currentQuestionNumber -=1;
		}

		this.isAnswerSet = function() {
			var questId = this.itemClassPrefix + this.questionIdSequence[this.currentQuestionNumber];
			// check if radio button checked
			if ($("input:radio[name='" + questId + "']").is(':checked')) {
				return true;
			} else {
				return false;
			}
		}
	}

	/*
	 TheTest - class to process test relations presented in json
	 */
	function TheTest(testId) {
		this.testId = testId;
		this.answer = { id: "", profiletype: ""};
		this.resultsBlock = $('.treetest-result-block');
		this.resultSpace = $('.treetest-result-space');
		this.descriptionBlock = $('.treetest-description');
		this.debugBlock = $('.treetest-debug-block');
		this.repeatTestBlock = $('.treetest-repeat-test');
		this.questionBlock = $('.treetest-question-block');
		this.msgBlock = $('.treetest-msg-block');
		this.debugMode = false;

		this.signsBlock = null;
		this.questionIter = null
		this.isAnswerSet = false;

		this.signsList = [];
		this.signsGroups = [];
		this.questionIdSequence = [];
		this.signsGroupsViewList = [];

		this.tpeList = new MTpeList();
		this.profiles = new MProfiles();
		this.viewTpeList = new VTpeList(this.tpeList, $('.treetest-tpe-block'));
		//this.profilesView = new VProfiles(this.profiles, $('.treetest-profiles-block'));
		/* this.profilesViewChart = new VProfilesChart(this.profiles, $('.treetest-profiles-block')); */

		this.tpeList.addObserver(this.viewTpeList);
		this.profiles.addObserver(this.profilesView);
		/* this.profiles.addObserver(this.profilesViewChart); */

		this.setIterator = function(iterator) {
			this.questionIter = iterator;
		}


		this.connectTpeList = function() {
			for (var i=0; i < this.signsGroups.length; i+=1) {
				this.signsGroups[i].addObserver(this.tpeList);
			}
		}

		this.hideTestDescription = function() {
			this.descriptionBlock.hide();
		};

		this.showMsg = function(text) {
			this.msgBlock.html("<div class='alert alert-danger' role='alert'>"+text+"</div>");
		}

		this.setAnswer = function(answer) {
			if (answer.id && answer.profiletype) {
				this.answer.id = answer.id;
				this.answer.profiletype = answer.profiletype;
				this.isAnswerSet = true;

			}
		}

		this.terminateTest = function() {
			this.questionBlock.hide();
			this.repeatTestBlock.show();
		}

		this.finnished = function() {
			this.resultsBlock.show();
		}

		this.loadTestStructure = function() {
			var self = this;
			$.post(glob.ajaxurl, { id: this.testId, action: "wp_treetest_get_test_structure"}, function(result, status) {
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
					//self.buildProfiles(result['profiles']);
				} else {
					log('cant load profiles');
				}

				// is debug set
				if (result['debugMode'] == 1) {
					self.debugMode = true;
				}
			});
		};

		this.loadResult = function(id, formValues) {

			log(id);
			var self = this;

			var leadFuncSing = [];
			var tpe = this.tpeList.findLeadTpe();
			for (var i=0; i < this.signsGroups.length; i+=1) {
				if (this.signsGroups[i].gType == Type.func) {
					for (var j=0; j < this.signsGroups[i].leadSign.length; j +=1) {
						leadFuncSing.push(this.signsGroups[i].leadSign[j].code);
					}
				}
			}

			leadFuncSing = leadFuncSing.join();

			/*
			$.post(glob.ajaxurl, {
				leadtpe: tpe[0], // lead tpe type
				subtpe: tpe[1], // second tpe type
				func: leadFuncSing,
				test_id: id,
				action: "wp_treetest_get_result"
			}, function(result, status) {
				//log(status);
				if (status == "success") {
					if (result) {
						self.resultSpace.html(result);
						self.debugBlock.show();
						self.repeatTestBlock.show();
					}
				} else {
					this.showMsg(tr.__failed_load_result);
				}
			});

			*/

			params = [];
			params.push("test_id=" 	+ id);
			params.push("subtpe=" 	+ tpe[1]);
			params.push("leadtpe=" 	+ tpe[0]);
			params.push("func="		+ leadFuncSing);
			params.push("action=wp_treetest_get_result");

			$.ajax({
				type: "POST",
				url : glob.ajaxurl,
				data: params.join("&") + "&" + formValues
			}).done(function(result) {

				if (result) {
					self.resultSpace.html(result);
					self.debugBlock.show();
					self.repeatTestBlock.show();
				} else {
					this.showMsg(tr.__failed_load_result);
				}
			});
		};

		this.buildSingsGroups = function(groups) {
			for(var i=0; i < groups.length; i+=1) {

				var group = new MSignGroup(
					groups[i].shortName,
					groups[i].gType
				);
				group.firstSign = groups[i].firstSign;
				group.secondSign = groups[i].secondSign;
				this.signsList.push(group.firstSign);
				this.signsList.push(group.secondSign);
				this.signsGroups.push(group);
			}
			this.connectSignGroupViews();
		}

		this.buildTpeList = function(list) {

			for(var i=0; i < list.length; i+=1) {

				var tpe = new MTpe(
					list[i].code,
					list[i].name,
					list[i].sequenceSign.split(',')
				);

				// connect sign to tpe if this sign in sings sequence of profile
				for (var j=0; j < this.signsList.length; j+=1) {
					if (list[i].sequenceSign.indexOf(this.signsList[j].code) != -1) {
						tpe.connectSign(this.signsList[j]);
					}
				}
				this.tpeList.addTpe(tpe);
			}

			this.connectTpeList();
		}

		this.buildProfiles = function(list) {

			for(var i=0; i < list.length; i+=1) {

				var profile = new MProfile(
					list[i].code,
					list[i].name,
					list[i].pType,
					list[i].sequenceSign.split(',')
				);

				// connect sign to profile if sign in sings sequence of profile
				for (var j=0; j < this.signsList.length; j+=1) {
					if (list[i].sequenceSign.indexOf(this.signsList[j].code) != -1) {
						profile.connectSign(this.signsList[j]);
					}
				}

				// connect tpe to profile if sign in sings sequence of profile
				for (var j=0; j < this.tpeList.length; j+=1) {
					if (list[i].sequenceSign.indexOf(this.tpeList[j].code) != -1) {
						profile.connectTpe(this.tpeList[j]);
					}
				}

				this.profiles.addProfile(profile);
			}

			var profilesObs = this.profiles.profiles;
			// connect tpe to profile if tpe in components sequence of profile
			for (var p=0; p < profilesObs.length; p+=1) {
				for (var j=0; j < profilesObs.length; j+=1) {
					if (profilesObs[p].sequenceOfSign.indexOf(profilesObs[j].code) != -1) {
						profilesObs[p].connectProfile(profilesObs[j]);
					}
				}
			}

			//this.connectProfilesView();
		}

		this.setSignsBlock = function(block) {
			this.signsBlock = block;
		}

		this.addPoint = function() {

			if (this.isAnswerSet) {
				var code = this.answer.id;
				var type = this.answer.profiletype;

				if (type == Type.tpe) {
					this.signsGroups.forEach(function(group) {
						group.addPoint(code);
					});
				} else if (type == Type.func) {

					var tpeGroupAmount = 0,
						equalGroupAmount = 0;

					for (var i=0; i < this.signsGroups.length; i+=1) {
						if (this.signsGroups[i].gType == Type.tpe) {

							tpeGroupAmount +=1;
							if (this.signsGroups[i].isEqual) {
								equalGroupAmount +=1;
							}
						}
					}

					if (!this.tpeList.isLeadTpeFind)
						this.errorSelectLeadTpe();
					else
						if (!this.tpeList.isSubTpeFind)
							this.errorSelectSubTpe();




					if ((equalGroupAmount > (tpeGroupAmount - equalGroupAmount))) {
						this.errorSelectLeadTpe();
					} else {
						this.signsGroups.forEach(function(group) {
							group.addPoint(code);
						});
					}
				}
			}
		};

		this.errorSelectLeadTpe = function() {
			this.terminateTest();
			this.showMsg(tr.__cant_find_leading_tpe);
			this.repeatTestBlock.show();
		}

		this.errorSelectSubTpe = function () {
			this.terminateTest();
			this.showMsg(tr.__cant_find_tpe_subtype);
			this.repeatTestBlock.show();
		}

		this.connectSignGroupViews = function() {
			var self = this;

			self.signsBlock.append("<div>" + tr.__TPE + "</div>");
			this.signsGroups.forEach(function (group) {
				if (group.gType == Type.tpe) {
					var divClassName = group.shortName.replace(':', "");
					var divElement = "<div style='width: 100%;' id='"+divClassName+"' class='progress treetest-sign-group-percentline'></div>";

					self.signsBlock.append(divElement);
					var view = new VSignGroup(group, $('#'+divClassName));

					view.render();
					group.addObserver(view);
					self.signsGroupsViewList.push(view);
				}
			});

			self.signsBlock.append("<div>" + tr.__Functional + "</div>");
			this.signsGroups.forEach(function (group) {
				if (group.gType == Type.func) {
					var divClassName = group.shortName.replace(':', "");
					var divElement = "<div style='width: 100%;' id='"+divClassName+"' class='progress treetest-sign-group-percentline'></div>";

					self.signsBlock.append(divElement);
					var view = new VSignGroup(group, $('#'+divClassName));

					view.render();
					group.addObserver(view);
					self.signsGroupsViewList.push(view);
				}
			})
		}

		this.connectProfilesView = function() {
			for (var i=0; i < this.signsGroups.length; i+=1) {
				this.signsGroups[i].addObserver(this.profiles);
			}
		}

		this.startTest = function() {
			this.hideTestDescription();

			if (this.debugMode) {
				this.debugBlock.show();
			}

			this.questionIter.showFirst();
		}

		this.nextQuestion = function() {
			if (this.isAnswerSet) {
				if (this.questionIter.next()) {
				} else {
					this.finnished();
				}
				this.isAnswerSet = false;
			} else {
				alert("Выберите ответ!");
			}
		}
	};
	/*
	 End of TestWalker class
	 */

	// global var
	var questionIter = new QuestionIter(
		$('.treetest-question-block'),
		'question_id_'
	);

	var block = $('.treetest-signs-block');

	var test =  new TheTest(getTestId());
	test.setIterator(questionIter);
	test.setSignsBlock(block);
	test.loadTestStructure();


	/* Connecti to ui */
	$('.treetest-show-result').click( function () {

		var testId = $(this).attr('id');
		if(testId) {
			test.loadResult(testId);
		} else {
			alert(tr.__failed_load_result);
		}
	});


	$('.treetest-start-test').click( function () {
		$(this).hide();
		test.startTest();
	});


	$('form#survey-form').submit(function(e) {

		var testId = $('.submit-form').attr('id');
		log(testId);

		if (testId) {
			test.loadResult(testId, $(this).serialize());
		} else {
			alert(tr.__failed_load_result);
		}

		setTimeout(function() {
			$.TreeTestfancybox.close();
		}, 1000);
		e.preventDefault();
	})


	$("button#treetest-answer-button").click(function () {
		log("answer click");
		test.setAnswer({
			id: $(this).val(),
			profiletype: $(this).attr('profiletype')
		});
		test.addPoint();
		test.nextQuestion();
	});
});