<!-- Header -->
<{includeq file="db:tdmcreate_header.tpl"}>
<script type="text/javascript">
    IMG_ON = '<{xoModuleIcons16 1.png}>';
    IMG_OFF = '<{xoModuleIcons16 0.png}>';
</script>
<!-- Display tables list -->
<{if $tables_list}>
   <table class='outer width100'>
     <thead>
       <tr>
	 <th class='center'><{$smarty.const._AM_TDMCREATE_ID_LIST}></th>
	 <th class='center'><{$smarty.const._AM_TDMCREATE_NAME_LIST}></th>
	 <th class='center'><{$smarty.const._AM_TDMCREATE_IMAGE_LIST}></th>
	 <th class='center'><{$smarty.const._AM_TDMCREATE_NBFIELDS_LIST}></th>
         <th class='center'><{$smarty.const._AM_TDMCREATE_PARENT_LIST}></th>
	 <th class='center'><{$smarty.const._AM_TDMCREATE_INLIST_LIST}></th>
         <th class='center'><{$smarty.const._AM_TDMCREATE_INFORM_LIST}></th>
	 <th class='center'><{$smarty.const._AM_TDMCREATE_ADMIN_LIST}></th>
	 <th class='center'><{$smarty.const._AM_TDMCREATE_USER_LIST}></th>
	 <th class='center'><{$smarty.const._AM_TDMCREATE_BLOCK_LIST}></th>
         <th class='center'><{$smarty.const._AM_TDMCREATE_MAIN_LIST}></th>
         <th class='center'><{$smarty.const._AM_TDMCREATE_SEARCH_LIST}></th>
	 <th class='center'><{$smarty.const._AM_TDMCREATE_REQUIRED_LIST}></th>
	 <th class='center width6'><{$smarty.const._AM_TDMCREATE_FORMACTION}></th>
       </tr>
     </thead>
       <tbody>
         <{foreach item=table from=$tables_list}>
             <tr id="table<{$table.id}>" class="fields toggleMain">
    	        <td class='center bold width5'>&#40;<{$table.id}>&#41;
                    <a href="#" title="Toggle"><img class="imageToggle" src="<{$modPathIcon16}>/toggle.png" alt="Toggle" /></a>
                </td>
                <td class='center'><u class='bold'><{$table.name}></u></td>
                <td class='center'><img src="<{xoModuleIcons32}><{$table.image}>" alt="<{$table.name}>" height="22" /></td>
    	        <td class='center bold'><{$table.nbfields}></td>
    	        <td class='center'><img src="<{$modPathIcon16}>/fields.png" /></td>
                <td class='center'><img src="<{$modPathIcon16}>/fields.png" /></td>
                <td class='center'><img src="<{$modPathIcon16}>/fields.png" /></td>
                <td class='center'><img src="<{$modPathIcon16}>/fields.png" /></td>
                <td class='center'><img src="<{$modPathIcon16}>/fields.png" /></td>
                <td class='center'><img src="<{$modPathIcon16}>/fields.png" /></td>
                <td class='center'><img src="<{$modPathIcon16}>/fields.png" /></td>
                <td class='center'><img src="<{$modPathIcon16}>/fields.png" /></td>
                <td class='center'><img src="<{$modPathIcon16}>/fields.png" /></td>
    	        <td class='xo-actions txtcenter width6'>
		    <a href="tables.php?op=edit&amp;table_mid=<{$table.mid}>&amp;table_id=<{$table.id}>" title="<{$smarty.const._AM_TDMCREATE_EDIT_TABLE}>">
                       <img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._AM_TDMCREATE_EDIT_TABLE}>" />
                    </a>  
                    <a href="fields.php?op=edit&amp;field_mid=<{$table.mid}>&amp;field_tid=<{$table.id}>" title="<{$smarty.const._AM_TDMCREATE_EDIT_FIELDS}>">
                       <img src="<{xoModuleIcons16 inserttable.png}>" alt="<{$smarty.const._AM_TDMCREATE_EDIT_FIELDS}>" />
                    </a>
                    <a href="fields.php?op=delete&amp;field_tid=<{$table.id}>" title="<{$smarty.const._DELETE}>">
                       <img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}>" />
                    </a>
    	        </td>
             </tr>             
			 <tr class="toggleChild">
				<td id="sortable" colspan="14" class='center'><{includeq file="db:tdmcreate_fields_item.tpl" table=$table}></td>
			 </tr>             
         <{/foreach}>
      </tbody>
   </table><br /><br />
<!-- Display modules navigation -->
<div class="clear">&nbsp;</div>
<{if $pagenav}><div class="xo-pagenav floatright"><{$pagenav}></div><div class="clear spacer"></div><{/if}>
<{/if}>
<{if $error}>
<div class="errorMsg">
    <strong><{$error}></strong>
</div>
<{/if}>
<!-- Display module form (add,edit) -->
<{if $form}>
   <div class="spacer"><{$form}></div>
<{/if}>
<!-- Footer -->
<{includeq file="db:tdmcreate_footer.tpl"}>