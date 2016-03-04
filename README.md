### Usage Examples ###

#### Form Input ####

    <?= $form->field($profile, 'timeZone')->widget(\yiidreamteam\widgets\timezone\Picker::className(), [
        'options' => ['class' => 'form-control'],
        'zones' => \yiidreamteam\widgets\timezone\Picker::PER_COUNTRY,
        'country' => 'US',
    ]) ?>