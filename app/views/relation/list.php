<div class="wrap">
      <?=nvHtml::button(array(
                'module' => 'nvRelation',
                'call' => 'add',
                'test_id' => $test->getId(),
             ),
            "Добавить",
            'ajax-call button-secondary'
        );?>
</div>