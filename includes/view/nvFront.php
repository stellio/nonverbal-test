<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class View_nvFront extends NV_View {

    public $lang;
    // show
    public $test;
    public $questions;

    // showresults
    public $results;

    function show() {

        ?>
        <div class="container-fluid treetest" id="<?=$this->test->getId();?>">
            <div class="row treetest-description">
                <div class="col-md-12">
                    <?php echo $this->test->getDescription(); ?>
                </div>
            </div>
            <div class="row treetest-result-block" style="display: none;">
                <div class="col-md-12 treetest-result-space">
                    <div class="jumbotron">
                        <h2><?=__('Testing completed!', 'wp-treetest')?></h2>
                        <p><?=__('Congratulations!', 'wp-treetest')?></p>
                        <br><?=__('To view results please, answer the following questions for the confidential collection of test statistics', 'wp-treetest')?></p>
                        <p><a class="btn btn-primary btn-lg fancybox" href="#survey-form">Ok</a></p>
                    </div>
                </div>
            </div>
            <div class="row treetest-debug-block" style="display: none;">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading"><?=__('Graphs of the distribution of signs', 'wp-treetest')?></div>
                        <div class="panel-body">
                            <div class="treetest-signs-block"></div>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading"><?=__('TPE graphics domination', 'wp-treetest')?></div>
                        <div class="panel-body">
                            <div class="treetest-tpe-block"></div>
                        </div>
                    </div>
                    <div class="treetest-profiles-block"></div>
                </div>
            </div>
            <div class="treetest-msg-block"></div>
            <div class="row">
                <div class="col-md-12 treetest-question-block" >
                    <?php foreach($this->questions as $question) { ?>
                        <div class="question_id_<?=$question->id;?>" id="<?=$question->id;?>" type="<?=$question->type?>" style="display: none">
                            <?=$question->text;?>
                            <p></p>
                            <div class="answer-block">
                                <div class="btn-group" role="group" aria-label="">
                                    <?php foreach ($question->answers as $answer) { ?>
                                                <button type="button" value="<?=$answer->value;?>" name="question_id_<?=$question->id;?>" id="treetest-answer-button" profiletype="<?=$question->type?>" class="btn btn-lg btn-default">
                                                    <?=$answer->text;?>
                                                </button>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="nav-block">
                            </div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row" style="margin: 10px 0 20px 0;">
                <div class="col-md-12">
                    <input type="button" class="treetest-start-test"  value="<?=__('Start testing', 'wp-treetest');?>"/>
                </div>
            </div>
            <div class="row treetest-repeat-test" style="display: none">
                <div class="col-md-12">
                    <input type="button" class="btn btn-info btn-lg" onclick="location.reload();" value="<?=__('Repeat testing', 'wp-treetest')?>">
                </div>
            </div>
        </div>

        <!-- form -->
        <div class="survey-form treetest hidden">
            <?=__('Please, answer the following questions for the confidential collection of test statistics:', 'wp-treetest')?>
            <form id="survey-form">
                <div class="form-group">
                    <label for="sf-type">
                        <?=__('How do you type yourself?', 'wp-treetest')?>
                    </label>
<!--                    <input type="text" name="type" class="form-control" id="sf-type" required>-->
                    <select class="form-control" name="type" id="sf-type" required>
                        <option><?=__('(ILI) Honore de Balzac', 'wp-treetest')?></option>
                        <option><?=__('(SLI) Jean Gabin', 'wp-treetest')?></option>
                        <option><?=__('(EIE) Hamlet', 'wp-treetest')?></option>
                        <option><?=__('(IEE) Aldous Huxley', 'wp-treetest')?></option>
                        <option><?=__('(LSI) Gorky', 'wp-treetest')?></option>
                        <option><?=__('(ESE) Victor Hugo', 'wp-treetest')?></option>
                        <option><?=__('(LIE) Jack London', 'wp-treetest')?></option>
                        <option><?=__('(ILE) Don Quixote', 'wp-treetest')?></option>
                        <option><?=__('(EII) Fyodor Dostoyevsky', 'wp-treetest')?></option>
                        <option><?=__('(ESI) Dreiser', 'wp-treetest')?></option>
                        <option><?=__('(SEI) Dumas', 'wp-treetest')?></option>
                        <option><?=__('(IEI) Sergei Yesenin', 'wp-treetest')?></option>
                        <option><?=__('(SLE) Georgy Zhukov', 'wp-treetest')?></option>
                        <option><?=__('(SEE) Napoleon I.', 'wp-treetest')?></option>
                        <option><?=__('(LII) Maximilien Robespierre', 'wp-treetest')?></option>
                        <option><?=__('(LSE) Stierlitz', 'wp-treetest')?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sf-type-another">
                        <?=__('If you are not sure, please, indicate another type(s) as a most probable option.', 'wp-treetest')?>
                    </label>
                    <select class="form-control" name="typeanother" id="sf-type-another" required>
                        <option><?=__('(ILI) Honore de Balzac', 'wp-treetest')?></option>
                        <option><?=__('(SLI) Jean Gabin', 'wp-treetest')?></option>
                        <option><?=__('(EIE) Hamlet', 'wp-treetest')?></option>
                        <option><?=__('(IEE) Aldous Huxley', 'wp-treetest')?></option>
                        <option><?=__('(LSI) Gorky', 'wp-treetest')?></option>
                        <option><?=__('(ESE) Victor Hugo', 'wp-treetest')?></option>
                        <option><?=__('(LIE) Jack London', 'wp-treetest')?></option>
                        <option><?=__('(ILE) Don Quixote', 'wp-treetest')?></option>
                        <option><?=__('(EII) Fyodor Dostoyevsky', 'wp-treetest')?></option>
                        <option><?=__('(ESI) Dreiser', 'wp-treetest')?></option>
                        <option><?=__('(SEI) Dumas', 'wp-treetest')?></option>
                        <option><?=__('(IEI) Sergei Yesenin', 'wp-treetest')?></option>
                        <option><?=__('(SLE) Georgy Zhukov', 'wp-treetest')?></option>
                        <option><?=__('(SEE) Napoleon I.', 'wp-treetest')?></option>
                        <option><?=__('(LII) Maximilien Robespierre', 'wp-treetest')?></option>
                        <option><?=__('(LSE) Stierlitz', 'wp-treetest')?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sf-type-basis">
                        <?=__('On what basis did you decide about your type?', 'wp-treetest')?>
                    </label>
                    <select class="form-control" name="typebasis" id="sf-type-basis" required>
                        <option><?=__('Test results', 'wp-treetest')?></option>
                        <option><?=__('Forum’s discussion', 'wp-treetest')?></option>
                        <option><?=__('Friend’s help', 'wp-treetest')?></option>
                        <option><?=__('Consultancy', 'wp-treetest')?></option>
                        <option><?=__('Other', 'wp-treetest')?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sf-age"><?=__('What is your age?', 'wp-treetest')?></label>
                    <input type="text" class="form-control" id="sf-age" name="age" required/>
                </div>
                <div class="form-group">
                    <label for="sf-gender"><?=__('What is your gender?', 'wp-treetest')?></label>
                    <select class="form-control" id="sf-gender" name="gender">
                        <option><?=__('Male', 'wp-treetest')?></option>
                        <option><?=__('Female', 'wp-treetest')?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sf-nickname"><?=__('What is your name or nickname?', 'wp-treetest')?></label>
                    <input type="text" class="form-control" id="sf-nickname" name="nickname" required/>
                </div>
                <div class="form-group">
                    <p class="help-block">
                        <?=__('Please review your responses and click submit to view results.', 'wp-treetest')?>
                    </p>
                </div>
                <button type="submit" id="<?=$this->test->getId();?>" class="btn btn-primary submit-form"><?=__('Submit', 'wp-treetest')?></button>
            </form>
        </div>
    <?php
    }

    function showResults() {

        $lEn = ($this->lang == 'en_US')? True : False;

        ?>
        <div class="treetest-results"></div>
            <div class="panel panel-primary">
                <div class="panel-heading"><?=($lEn)? 'Result': 'Результат'?></div>
                <div class="panel-body">
                    <div><b><?=($lEn)? 'Type' : 'Тип'?>: </b><?=$this->results['lead']['typeName']?>, <?=$this->results['lead']['tpeName']?></div>
                    <div><b><?=($lEn)? 'Subtype' : 'Подтип'?>: </b><?=$this->results['sub']['typeName']?>, <?=$this->results['sub']['tpeName']?></div>
                    <div><b><?=($lEn)? 'Profile' : 'Профиль'?>: </b><?=$this->results['profile']?></div>
                    <p></p>
                    <div>
                        <?php foreach($this->results['moreTypeInfo'] as $result) { ?>
                            <div><b><?=$result->title?></b></div>
                            <p></p>
                            <div>
                                <?=$result->text?>
                            </div>
                        <p></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    function showMsg($msg) {
    ?>
        <div class="alert alert-danger" role="alert"><?=$msg?></div>
    <?php
    }
}
?>