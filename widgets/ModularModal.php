<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\bootstrap5\Modal;

class ModularModal extends Widget
{
    public $id = 'universal-modal';
    public $size = Modal::SIZE_LARGE;
    public $title = '<h4 class="modal-title">Hozzáadás</h4>';
    public $contentId = 'universal-modal-content';

    public function run()
    {
        Modal::begin([
            'id' => $this->id,
            'title' => $this->title,
            'size' => $this->size,
            'options' => ['tabindex' => false],
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => true],
        ]);

        echo "<div id='{$this->contentId}'><div class='text-center p-5'>Loading...</div></div>";

        Modal::end();

        $this->registerScript();
    }

    protected function registerScript()
    {
        $js = <<<JS
$(document).on('click', '[data-toggle="universal-modal"]', function (e) {
    e.preventDefault();
    const url = $(this).attr('href');
    const target = $(this).data('target'); // Save which dropdown we are targeting
    const modal = $('#{$this->id}');
    
    modal.data('target-select', target); // Store it in the modal's data
    modal.modal('show');
    $('#{$this->contentId}').load(url);
});

$(document).on('beforeSubmit', 'form', function (e) {
    var form = $(this);
    // Only intercept if inside our modal
    if (form.closest('#{$this->contentId}').length === 0) return true;

    e.preventDefault();
    $.post(form.attr('action'), form.serialize())
        .done(function (response) {
            if (response.status === 'success') {
                const modal = $('#{$this->id}');
                const targetSelectId = modal.data('target-select');
                
                if (targetSelectId) {
                    // 1. Add the new option to the dropdown
                    const newOption = new Option(response.name, response.id, true, true);
                    $('#' + targetSelectId).append(newOption).trigger('change');
                }
                
                modal.modal('hide');
            } else {
                $('#{$this->contentId}').html(response);
            }
        });
    return false;
});
JS;

        Yii::$app->view->registerJs($js);
    }
}