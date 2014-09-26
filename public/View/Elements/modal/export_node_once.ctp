<!-- Modal -->
<?php echo $this->Form->create('Book', array(
        'url' => array('controller' => 'books', 'action' => 'export'),
        'id' => 'node-export-form',
        'inputDefaults' => array(
            'div' => 'form-group',
            'required' => false,
            'class' => 'form-control',
            'wrapInput' => 'col',
        )
    )); 
    echo $this->Form->unlockField('Book.book_id');
    echo $this->Form->input('Book.book_id', array('type' => 'hidden', 'id' => 'book-id'));
?>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modal-label">Export Global Content To Local Content</h4>
            </div>
            <div class="modal-body">
                <p>Do you want to replace existing local content with the current global content?</p>
                <?php 
                    $i = 0;
                    foreach ($countryList as $countryId => $value) : ?>
                        <?php
                            foreach ($languageList as $languageId => $languageName) :
                                $key = $countryId . '-' . $languageId;
                                echo $this->Form->input('Book.language_id', array(
                                    'type' => 'hidden',
                                    'value' => $key,
                                    'id' => 'country-language-hidden'
                                ));
                                $i += 1;
                            endforeach;
                        ?>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <?php echo $this->Form->button('Export', array('type' => 'button', 'class' => 'btn btn-primary', 'id' => 'submit-export-btn')); ?>
            </div>
      </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>