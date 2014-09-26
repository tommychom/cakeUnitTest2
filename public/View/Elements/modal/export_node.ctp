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
                <div class="alert alert-danger" style="display:none;">
                    
                </div>
                <p>Choose language on country that you want to export to.</p>
                <?php 
                    $i = 0;
                    $warning = false;
                    foreach ($countryList as $countryId => $value) : ?>
                    <div class="form-group">
                        <label>Country : <?php echo $value; ?></label>
                        <?php
                            foreach ($languageList as $languageId => $languageName) :
                                $key = $countryId . '-' . $languageId;
                                if (!empty($bookList[$key])) {
                                    $languageName .= '*';
                                    $warning = true;
                                }
                                echo $this->Form->input('Book.language_id.' . $i, array(
                                    'div' => false,
                                    'type' => 'checkbox',
                                    'label' => $languageName,
                                    'wrapInput' => false,
                                    'class' => false,
                                    'value' => $key
                                ));
                                $i += 1;
                            endforeach;
                        ?>
                    </div>
                <?php endforeach; ?>
                <?php if($warning): ?>
                <div class="alert alert-warning">
                    ( * ) Existing content will be replace with the new one.
                </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <?php echo $this->Form->button('Export', array('type' => 'button', 'class' => 'btn btn-primary', 'id' => 'submit-export-btn')); ?>
            </div>
      </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>