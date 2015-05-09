<?php
/*
Plugin Name: WP Tree Test
Plugin URI: http://www.stellio.org.ua
Description: A simple and powerfull plugin to make tree tests
Author: Lisovoy Igor
Author URI: http://www.stellio.org.ua
*/

class View_nvQuestionList extends NV_View {
	
	public $content;
    public $testId;
    public $test;
    public $answers;

	function show() {

?>
<!-- <h2 class="nav-tab-wrapper"> -->
<!-- Question Settings -->
<!-- <a href="#" class="nav-tab nav-tab-active">Tab 1</a> -->
<!-- <a href="admin.php?page=TreeTest" class="nav-tab">TreeTest</a> -->
<!-- </h2> -->
<div class="wrap">
    <?php $this->tabs($this->test, $this::TAB_QUESTIONS); ?>
    <p></p>
    <a class="button-secondary" href="admin.php?page=nvTest&module=nvQuestion&action=add&test_id=<?=$this->testId;?>">Добавить</a>
    <p></p>
    <table class="wp-list-table widefat" id="">
        <thead>
            <tr>
                <th scope="col">№</th>
                <th scope="col">Текст вопроса</th>
                <th scope="col">Что определяет</th>
                <th scope="col">Ответы (код : текст)</th>
                <th scope="col">Действия</th>
                <!-- <th scope="col">Статус</th> -->
            </tr>
        </thead>
        <tbody id="the-list">
        <?php
            if (count($this->content)) {
                $counter = 0;
                foreach ($this->content as $key => $value) { $counter++; ?>

                    <tr>
                        <td><?=$counter?></td>
                        <td> <?=$this->shorten($value['text']);?></td>
                        <td>
                            <?php
                                if ($value['type'] == Model_nvSign::TYPE_TPE)
                                    echo "ТПЭ";
                                else if ($value['type'] == Model_nvSign::TYPE_FUNCTIONAL)
                                    echo "Функциональность";
                                else
                                    echo "-";
                            ?>
                        </td>
                        <td>
                            <?php foreach ($this->answers->getListByQuestionIdAndTestId($value['id'], $this->testId) as $key => $answr) {
                                echo $answr['value'] . " : " . $answr['text'] . "<br>";
                            } ?>
                        </td>                        
                        <td>
                            <?=$this->link(array(
                                'module' => 'nvQuestion',
                                'action' => 'edit',
                                'test_id' => $this->testId,
                                'id' => $value['id']
                            ),
                                $this->imgEdit(),
                                "Редактировать"
                            );
                            ?>
                            <?=$this->link(array(
                                'module' => 'nvQuestion',
                                'action' => 'delete',
                                'test_id' => $this->testId,
                                'id' => $value['id']
                            ),
                                $this->imgDelete(),
                                "Удалить"
                            );
                            ?>
                        </td>
                    </tr>
            <?php } 
            } else { ?>
                <tr>
                     <td colspan="6">Вопросов пока еще нет.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <a class="button-secondary" href="admin.php?page=nvTest&module=nvQuestion&action=add&test_id=<?=$this->testId;?>">Добавить</a>
</div>
    <?php
    }
}
?>