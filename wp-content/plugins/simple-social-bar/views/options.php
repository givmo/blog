<script type="text/javascript">var __namespace = '<?php echo $namespace; ?>';</script>
<div class="wrap">

    <h2><?php echo $friendly_name; ?> Options</h2>
        
    <?php if( isset( $_GET['message'] ) ): ?>
        <div id="message" class="updated below-h2"><p>Options successfully updated!</p></div>
    <?php endif; ?>

    <form action="" method="post" id="<?php echo $namespace; ?>-form">
        <?php wp_nonce_field( $namespace . "_options", $namespace . '_update_wpnonce' ); ?>
        
        <p>Setup the buttons you wish to display on your bars. Buttons that are checked will be shown. You can re-order the buttons by dragging them by the handle (<img src="<?php echo $url_path; ?>/images/handle.png" alt="" />) on the left of each row. Choose which button style to use on the vertical bar and horizontal bar from the dropdown for each social button.</p>
        
        <ul id="button-list">
            
            <?php foreach( $buttons as $button ): ?>
                
                <li id="button-<?php echo $button['type']; ?>" class="button-row">
                    <div class="inner">
                        <span class="handle"></span>
                        
                        <input type="hidden" name="button[<?php echo $button['type']; ?>][ID]" class="button-id" value="<?php echo $button['ID']; ?>" />
                        <input type="hidden" name="button[<?php echo $button['type']; ?>][order]" class="button-order" value="<?php echo $button['order']; ?>" />
                        <input type="hidden" name="button[<?php echo $button['type']; ?>][type]" class="button-type" value="<?php echo $button['type']; ?>" />
                        
                        <input type="checkbox" value="1" name="button[<?php echo $button['type']; ?>][enabled]" class="button-enabled"<?php if( $button['enabled'] == true ) echo ' checked="checked"'; ?> />
                        
                        <strong class="button-type"><?php echo $button['type']; ?></strong>
                        
                        <label>Vertical Display: 
                            <select name="button[<?php echo $button['type']; ?>][verticaldisplay]" class="button-verticaldisplay">
                                <option value="big"<?php if( $button['verticaldisplay'] == "big" ) echo ' selected="selected"'; ?>>Big Button</option>
                                <option value="small"<?php if( $button['verticaldisplay'] == "small" ) echo ' selected="selected"'; ?>>Small Button</option>
                            </select>
                        </label>
                        
                        <label>Horizontal Display: 
                            <select name="button[<?php echo $button['type']; ?>][horizontaldisplay]" class="button-horizontaldisplay">
                                <option value="big"<?php if( $button['horizontaldisplay'] == "big" ) echo ' selected="selected"'; ?>>Big Button</option>
                                <option value="small"<?php if( $button['horizontaldisplay'] == "small" ) echo ' selected="selected"'; ?>>Small Button</option>
                            </select>
                        </label>
                        
                        <a href="#" class="button-edit">Edit Code</a> 
                    </div>
                    
                    <div class="button-codesnippet" style="display:none;">
                        <label class="button-codesnippetbig">Big Button Code: <br />
                            <textarea rows="5" cols="80" name="button[<?php echo $button['type']; ?>][codesnippetbig]"><?php echo $button['codesnippetbig']; ?></textarea>
                        </label>
                        <label class="button-codesnippetsmall">Small Button Code: <br /> 
                            <textarea rows="5" cols="80" name="button[<?php echo $button['type']; ?>][codesnippetsmall]"><?php echo $button['codesnippetsmall']; ?></textarea>
                        </label>
                        <p><em>Get the code at: </em><a href="<?php echo $available_buttons[$button['type']]; ?>" target="_blank"><?php echo $available_buttons[$button['type']]; ?></a></p>
                    </div>
                </li>

            <?php endforeach; ?>
            
        </ul>
        
        <div id="<?php echo $namespace; ?>-data">
            <h3>Configuration Options</h3>
            <p>You can optionally include a horizontal version of the <?php echo $friendly_name; ?> just before the content of a post.</p>
            <p><label><input type="checkbox" name="data[show_horizontal]" value="1"<?php if( $data['show_horizontal'] ) echo ' checked="checked"'; ?> /> Display horizontal version of the <?php echo $friendly_name; ?>.</label></p>
            
            <p><strong>Position the vertical <?php echo $friendly_name; ?> on the:</strong><br />
                <select name="data[side]">
                    <option value="left"<?php if( $data['side'] == 'left' ) echo ' selected="selected"'; ?>>Left of the Post</option>
                    <option value="right"<?php if( $data['side'] == 'right' ) echo ' selected="selected"'; ?>>Right of the Post</option>
                </select>
            </p>
            
            <p><strong>Display in the following Post Types:</strong><br />
                
                <?php foreach( $post_types as $post_type ): ?>
                    <label><input type="checkbox" name="data[post_types][]" value="<?php echo $post_type->name; ?>"<?php if( in_array( $post_type->name, $data['post_types'] ) ) echo ' checked="checked"'; ?> /> <?php echo $post_type->label; ?></label>
                <?php endforeach; ?>
            </p>
        </div>
        
        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
        </p>
    </form>
    
</div>