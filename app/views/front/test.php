<div class="container-fluid treetest" id="<?=$test->getId();?>">
    <div class="row treetest-description">
        <div class="col-md-12">
            <?php echo $test->getDescription(); ?>
        </div>
    </div>
    <div class="row treetest-result-block" style="display: none;">
        <div class="col-md-12 treetest-result-space">
            <div class="jumbotron">
                <h2><?=__('Testing completed!', 'nonverbal-test')?></h2>
                <p><?=__('Congratulations!', 'nonverbal-test')?></p>
                <br><?=__('To view results please, answer the following questions for the confidential collection of test statistics', 'nonverbal-test')?></p>
                <p><a class="btn btn-primary btn-lg fancybox" href="#survey-form">Ok</a></p>
            </div>
        </div>
    </div>
    <div class="row treetest-debug-block" style="display: none;">
        <div class="col-md-12">
            <div class="panel panel-info" style="display: none;">
                <div class="panel-heading"><?=__('Graphs of the distribution of signs', 'nonverbal-test')?></div>
                <div class="panel-body">
                    <div class="treetest-signs-block"></div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading"><?=__('TPE graphics domination', 'nonverbal-test')?></div>
                <div class="panel-body">
                    <div class="treetest-tpe-block"></div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading"><?=__('Functionality profiles domination', 'nonverbal-test')?></div>
                <div class="panel-body">
                    <div class="treetest-profiles-block"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="treetest-msg-block"></div>
    <div class="row">
        <div class="col-md-12 treetest-question-block" >
            <?php foreach($questions as $question) { ?>
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
            <input type="button" class="treetest-start-test"  value="<?=__('Start testing', 'nonverbal-test');?>"/>
        </div>
    </div>
    <div class="row treetest-repeat-test" style="display: none">
        <div class="col-md-12">
            <input type="button" class="btn btn-info btn-lg" onclick="location.reload();" value="<?=__('Repeat testing', 'nonverbal-test')?>">
        </div>
    </div>
</div>

<!-- form -->
<div class="survey-form treetest hidden">
    <?=__('Please, answer the following questions for the confidential collection of test statistics:', 'nonverbal-test')?>
    <form id="survey-form">
        <div class="form-group">
            <label for="sf-type">
                <?=__('How do you type yourself?', 'nonverbal-test')?>
            </label>
<!--                    <input type="text" name="type" class="form-control" id="sf-type" required>-->
            <select class="form-control" name="type" id="sf-type" required>
                <option><?=__('(ILI) Honore de Balzac', 'nonverbal-test')?></option>
                <option><?=__('(SLI) Jean Gabin', 'nonverbal-test')?></option>
                <option><?=__('(EIE) Hamlet', 'nonverbal-test')?></option>
                <option><?=__('(IEE) Aldous Huxley', 'nonverbal-test')?></option>
                <option><?=__('(LSI) Gorky', 'nonverbal-test')?></option>
                <option><?=__('(ESE) Victor Hugo', 'nonverbal-test')?></option>
                <option><?=__('(LIE) Jack London', 'nonverbal-test')?></option>
                <option><?=__('(ILE) Don Quixote', 'nonverbal-test')?></option>
                <option><?=__('(EII) Fyodor Dostoyevsky', 'nonverbal-test')?></option>
                <option><?=__('(ESI) Dreiser', 'nonverbal-test')?></option>
                <option><?=__('(SEI) Dumas', 'nonverbal-test')?></option>
                <option><?=__('(IEI) Sergei Yesenin', 'nonverbal-test')?></option>
                <option><?=__('(SLE) Georgy Zhukov', 'nonverbal-test')?></option>
                <option><?=__('(SEE) Napoleon I.', 'nonverbal-test')?></option>
                <option><?=__('(LII) Maximilien Robespierre', 'nonverbal-test')?></option>
                <option><?=__('(LSE) Stierlitz', 'nonverbal-test')?></option>
            </select>
        </div>
        <div class="form-group">
            <label for="sf-type-another">
                <?=__('If you are not sure, please, indicate another type(s) as a most probable option.', 'nonverbal-test')?>
            </label>
            <select class="form-control" name="typeanother" id="sf-type-another" required>
                <option><?=__('(ILI) Honore de Balzac', 'nonverbal-test')?></option>
                <option><?=__('(SLI) Jean Gabin', 'nonverbal-test')?></option>
                <option><?=__('(EIE) Hamlet', 'nonverbal-test')?></option>
                <option><?=__('(IEE) Aldous Huxley', 'nonverbal-test')?></option>
                <option><?=__('(LSI) Gorky', 'nonverbal-test')?></option>
                <option><?=__('(ESE) Victor Hugo', 'nonverbal-test')?></option>
                <option><?=__('(LIE) Jack London', 'nonverbal-test')?></option>
                <option><?=__('(ILE) Don Quixote', 'nonverbal-test')?></option>
                <option><?=__('(EII) Fyodor Dostoyevsky', 'nonverbal-test')?></option>
                <option><?=__('(ESI) Dreiser', 'nonverbal-test')?></option>
                <option><?=__('(SEI) Dumas', 'nonverbal-test')?></option>
                <option><?=__('(IEI) Sergei Yesenin', 'nonverbal-test')?></option>
                <option><?=__('(SLE) Georgy Zhukov', 'nonverbal-test')?></option>
                <option><?=__('(SEE) Napoleon I.', 'nonverbal-test')?></option>
                <option><?=__('(LII) Maximilien Robespierre', 'nonverbal-test')?></option>
                <option><?=__('(LSE) Stierlitz', 'nonverbal-test')?></option>
            </select>
        </div>
        <div class="form-group">
            <label for="sf-type-basis">
                <?=__('On what basis did you decide about your type?', 'nonverbal-test')?>
            </label>
            <select class="form-control" name="typebasis" id="sf-type-basis" required>
                <option><?=__('Test results', 'nonverbal-test')?></option>
                <option><?=__('Forum’s discussion', 'nonverbal-test')?></option>
                <option><?=__('Friend’s help', 'nonverbal-test')?></option>
                <option><?=__('Consultancy', 'nonverbal-test')?></option>
                <option><?=__('Other', 'nonverbal-test')?></option>
            </select>
        </div>
        <div class="form-group">
            <label for="sf-age"><?=__('What is your age?', 'nonverbal-test')?></label>
            <input type="text" class="form-control" id="sf-age" name="age" required/>
        </div>
        <div class="form-group">
            <label for="sf-gender"><?=__('What is your gender?', 'nonverbal-test')?></label>
            <select class="form-control" id="sf-gender" name="gender">
                <option><?=__('Male', 'nonverbal-test')?></option>
                <option><?=__('Female', 'nonverbal-test')?></option>
            </select>
        </div>
        <div class="form-group">
            <label for="sf-nickname"><?=__('What is your name or nickname?', 'nonverbal-test')?></label>
            <input type="text" class="form-control" id="sf-nickname" name="nickname" required/>
        </div>
        <div class="form-group">
            <p class="help-block">
                <?=__('Please review your responses and click submit to view results.', 'nonverbal-test')?>
            </p>
        </div>
        <button type="submit" id="<?=$test->getId();?>" class="btn btn-primary submit-form"><?=__('Submit', 'nonverbal-test')?></button>
    </form>
</div>