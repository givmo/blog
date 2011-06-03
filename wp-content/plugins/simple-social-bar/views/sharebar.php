<div class="<?php echo "{$namespace}-{$direction}"; ?><?php if( $direction == 'vertical' ) echo " {$namespace}-{$side}"; ?>"<?php if( $direction == 'vertical' ) echo ' style="display:none;"'; ?>>
    
    <?php foreach( $buttons as $button ): ?>
        
        <div class="<?php echo $namespace; ?>-button" id="<?php echo "{$namespace}-{$button['type']}"; ?>">
            
            <?php
                $codesnippet = 'codesnippet' . $button[$direction . 'display'];
                echo $button[$codesnippet];
            ?>
            
        </div>
        
    <?php endforeach; ?>
    
</div>