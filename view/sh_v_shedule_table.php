<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<div class="wrap">
    <h2><?php _e('Shedule tables', 'shedule');?>
        <a href="admin.php?page=sh_shedule_table&action=add" class="add-new-h2">
            <?php _e('Add new', 'shedule');?>
        </a>
    </h2>
    <table class="wp-list-table widefat fixed posts" cellspacing="0">
    <thead>
    <tr>
            <th scope="col" id="title" class="manage-column column-title sortable desc" style="width: 230px; padding-left: 20px;">
                <?php _e('Title', 'shedule');?>
            </th>
            <th scope="col" id="author" class="manage-column column-author" style="width: 250px;">
                <?php _e('Description', 'shedule');?>
            </th>
            <th scope="col" id="categories" class="manage-column column-categories" style="">
                <?php _e('Date begin', 'shedule');?>
            </th>
            <th scope="col" id="tags" class="manage-column column-tags" style="">
                <?php _e('Date end', 'shedule');?>
            </th>
            <th scope="col" id="date" class="manage-column column-date sortable asc" style="width: 200px">
                <?php _e('Shortcode', 'shedule');?>
            </th>
    </tr>
    </thead>
    <tfoot>
    <tr>
            <th scope="col" id="title" class="manage-column column-title sortable desc" style="width: 230px; padding-left: 20px;">
                <?php _e('Title', 'shedule');?>
            </th>
            <th scope="col" id="author" class="manage-column column-author" style="">
                <?php _e('Description', 'shedule');?>
            </th>
            <th scope="col" id="categories" class="manage-column column-categories" style="">
                <?php _e('Date begin', 'shedule');?>
            </th>
            <th scope="col" id="tags" class="manage-column column-tags" style="">
                <?php _e('Date end', 'shedule');?>
            </th>
            <th scope="col" id="date" class="manage-column column-date sortable asc" style="">
                <?php _e('Shortcode', 'shedule');?>
            </th>
    </tr>
    </tfoot>
    <tbody id="the-list">
    <?php foreach($shedule_tables as $shedule_table):?>
    <tr id="<?php echo $shedule_table->id;?>">
    <td class="post-title page-title column-title">
        <strong>
            <a class="row-title" href="admin.php?page=sh_shedule_table&action=edit&id=<?php echo $shedule_table->id;?>" title="<?php printf(__('Edit shedule "%s"'), $shedule_table->title);?>">
                <?php echo $shedule_table->title;?>
            </a>
        </strong>
        <div class="row-actions">
            <span class="edit">
                <a href="admin.php?page=sh_shedule_table&action=edit&id=<?php echo $shedule_table->id;?>" title="<?php _e('Edit this element', 'shedule');?>">
                    <?php _e('Edit', 'shedule');?>
                </a>
                | 
            </span>
            <span class="inline hide-if-no-js">
                <a href="admin.php?page=sh_shedule_table&action=index&id=<?php echo $shedule_table->id;?>" title="<?php _e('Add event', 'shedule');?>">
                    <?php _e('Add event', 'shedule');?>
                </a> | 
            </span>
            <span class="inline hide-if-no-js">
                <span class="sh-delete-table" style="color: red;" data-url="<?php echo SHEDULE_ADM_URL; ?>admin.php" title="<?php _e('Delete', 'shedule');?>" >
                    <?php _e('Delete', 'shedule');?>
                </span>
            </span>
        </div>
    </td>
    <td class="post-title page-title column-title">
        <?php echo $shedule_table->description;?>
    </td>
    <td class="date column-date">
        <abbr title="<?php echo date('d-m-Y',strtotime($shedule_table->date_time_begin))?>">
        <?php echo date('d-m-Y',strtotime($shedule_table->date_time_begin))?>
        </abbr>
        <br>
        <?php _e('Date begin', 'shedule');?>
    </td>
    <td class="date column-date">
        <abbr title="<?php echo date('d-m-Y',strtotime($shedule_table->date_time_end))?>">
        <?php echo date('d-m-Y',strtotime($shedule_table->date_time_end))?>
        </abbr>
        <br>
        <?php _e('Date end', 'shedule');?>
    </td>    
    <td class="post-title page-title column-title">
        [ shedule_table id="<?php echo $shedule_table->id;?>"]
    </td>    
    </tr>
    <?php endforeach;?>
    </tbody>
    </table>
</div>
