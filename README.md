### Usage Examples ###

#### Form Input ####

    <?= $form->field($profile, 'timeZone')->widget(\yiidreamteam\widgets\timezone\Picker::className(), [
        'options' => ['class' => 'form-control'],
    ]) ?>