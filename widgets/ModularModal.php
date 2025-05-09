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
    const modal = $('#{$this->id}');
    const content = $('#{$this->contentId}');
    
    modal.modal('show');
    content.html('<div class="text-center p-5">Loading...</div>');
    content.load(url);
});

$(document).on('beforeSubmit', 'form#modal-form', function (e) {
    e.preventDefault();
    var form = $(this);
    if (form.data('submitted')) return false;
    form.data('submitted', true);

    $.post(form.attr('action'), form.serialize())
        .done(function (response) {
            if (response === 'success') {
                $('#universal-modal').modal('hide');
                location.reload();
            } else {
                $('#universal-modal-content').html(response);
            }
        })
        .fail(function () {
            alert('Hiba lépett a modal megjelenítése közben.');
        })
        .always(function () {
            form.data('submitted', false);
        });

    return false;
});
JS;

        Yii::$app->view->registerJs($js);
    }
}