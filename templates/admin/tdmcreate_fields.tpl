<!-- Header -->
<{includeq file="db:tdmcreate_header.tpl"}>
<script type="text/javascript">
    IMG_ON = '<{xoModuleIcons16 1.png}>';
    IMG_OFF = '<{xoModuleIcons16 0.png}>';
</script>
<!-- Display tables list -->
<{if $tables_list}>
<pre><div id="info">In attesa di aggiornamento post-riordinamento</div></pre>
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
       <tbody id="sortable">
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
             <{foreach item=field from=$table.fields}>
              <{if $field.id > 0}>
               <tr id="fieldItem_<{$field.lid}>" class="<{cycle values='even,odd'}> sortable toggleChild">
    	        <td class='center'>&#91;<{$field.lid}>&#93;&nbsp;<img class="move" src="<{$modPathIcon16}>/drag.png" alt="<{$field.name}>" /></td>
                <td class='center'><{$field.name}></td>
                <td class='center'><img src="<{$modPathIcon16}>/tables.png" alt="Empty" /></td>
                <td class='center'><img src="<{$modPathIcon16}>/tables.png" alt="Empty" /></td>
                <td class='center'><img id="loading_img_parent<{$field.id}>" src="<{$modPathIcon16}>/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>" alt="<{$smarty.const._AM_SYSTEM_LOADING}>" /><img style="cursor:pointer;" class="tooltip" id="img_parent<{$field.id}>" onclick="tdmcreate_setStatus( { op: 'display', field_id: <{$field.id}>, field_parent: <{if $field.parent}>0<{else}>1<{/if}> }, 'img_parent<{$field.id}>', 'fields.php' )" src="<{xoModuleIcons16}><{$field.parent}>.png" alt="<{$smarty.const._AM_TDMCREATE_CHANGE_DISPLAY}>&nbsp;<{$field.name}>" title="<{$smarty.const._AM_TDMCREATE_CHANGE_DISPLAY}>&nbsp;<{$field.name}>" />
                </td>                
				<td class='center'><img id="loading_img_inlist<{$field.id}>" src="<{$modPathIcon16}>/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>" alt="<{$smarty.const._AM_SYSTEM_LOADING}>" /><img style="cursor:pointer;" class="tooltip" id="img_inlist<{$field.id}>" onclick="tdmcreate_setStatus( { op: 'display', field_id: <{$field.id}>, field_inlist: <{if $field.inlist}>0<{else}>1<{/if}> }, 'img_inlist<{$field.id}>', 'fields.php' )" src="<{xoModuleIcons16}><{$field.inlist}>.png" alt="<{$smarty.const._AM_TDMCREATE_CHANGE_DISPLAY}>&nbsp;<{$field.name}>" title="<{$smarty.const._AM_TDMCREATE_CHANGE_DISPLAY}>&nbsp;<{$field.name}>" />
				</td>
				<td class='center'><img id="loading_img_inform<{$field.id}>" src="<{$modPathIcon16}>/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>" alt="<{$smarty.const._AM_SYSTEM_LOADING}>" /><img style="cursor:pointer;" class="tooltip" id="img_inform<{$field.id}>" onclick="tdmcreate_setStatus( { op: 'display', field_id: <{$field.id}>, field_inform: <{if $field.inform}>0<{else}>1<{/if}> }, 'img_inform<{$field.id}>', 'fields.php' )" src="<{xoModuleIcons16}><{$field.inform}>.png" alt="<{$smarty.const._AM_TDMCREATE_CHANGE_DISPLAY}>&nbsp;<{$field.name}>" title="<{$smarty.const._AM_TDMCREATE_CHANGE_DISPLAY}>&nbsp;<{$field.name}>" />
				</td>
				<td class='center'><img id="loading_img_admin<{$field.id}>" src="<{$modPathIcon16}>/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>" alt="<{$smarty.const._AM_SYSTEM_LOADING}>" /><img style="cursor:pointer;" class="tooltip" id="img_admin<{$field.id}>" onclick="tdmcreate_setStatus( { op: 'display', field_id: <{$field.id}>, field_admin: <{if $field.admin}>0<{else}>1<{/if}> }, 'img_admin<{$field.id}>', 'fields.php' )" src="<{xoModuleIcons16}><{$field.admin}>.png" alt="<{$smarty.const._AM_TDMCREATE_CHANGE_DISPLAY}>&nbsp;<{$field.name}>" title="<{$smarty.const._AM_TDMCREATE_CHANGE_DISPLAY}>&nbsp;<{$field.name}>" />
				</td>
				<td class='center'><img id="loading_img_user<{$field.id}>" src="<{$modPathIcon16}>/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>" alt="<{$smarty.const._AM_SYSTEM_LOADING}>" /><img style="cursor:pointer;" class="tooltip" id="img_user<{$field.id}>" onclick="tdmcreate_setStatus( { op: 'display', field_id: <{$field.id}>, field_user: <{if $field.user}>0<{else}>1<{/if}> }, 'img_user<{$field.id}>', 'fields.php' )" src="<{xoModuleIcons16}><{$field.user}>.png" alt="<{$smarty.const._AM_TDMCREATE_CHANGE_DISPLAY}>&nbsp;<{$field.name}>" title="<{$smarty.const._AM_TDMCREATE_CHANGE_DISPLAY}>&nbsp;<{$field.name}>" />
				</td>
				<td class='center'><img id="loading_img_block<{$field.id}>" src="<{$modPathIcon16}>/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>" alt="<{$smarty.const._AM_SYSTEM_LOADING}>" /><img style="cursor:pointer;" class="tooltip" id="img_block<{$field.id}>" onclick="tdmcreate_setStatus( { op: 'display', field_id: <{$field.id}>, field_block: <{if $field.block}>0<{else}>1<{/if}> }, 'img_block<{$field.id}>', 'fields.php' )" src="<{xoModuleIcons16}><{$field.block}>.png" alt="<{$smarty.const._AM_TDMCREATE_CHANGE_DISPLAY}>&nbsp;<{$field.name}>" title="<{$smarty.const._AM_TDMCREATE_CHANGE_DISPLAY}>&nbsp;<{$field.name}>" />
				</td>
				<td class='center'><img id="loading_img_main<{$field.id}>" src="<{$modPathIcon16}>/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>" alt="<{$smarty.const._AM_SYSTEM_LOADING}>" /><img style="cursor:pointer;" class="tooltip" id="img_main<{$field.id}>" onclick="tdmcreate_setStatus( { op: 'display', field_id: <{$field.id}>, field_main: <{if $field.main}>0<{else}>1<{/if}> }, 'img_main<{$field.id}>', 'fields.php' )" src="<{xoModuleIcons16}><{$field.main}>.png" alt="<{$smarty.const._AM_TDMCREATE_CHANGE_DISPLAY}>&nbsp;<{$field.name}>" title="<{$smarty.const._AM_TDMCREATE_CHANGE_DISPLAY}>&nbsp;<{$field.name}>" />
				</td>
				<td class='center'><img id="loading_img_search<{$field.id}>" src="<{$modPathIcon16}>/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>" alt="<{$smarty.const._AM_SYSTEM_LOADING}>" /><img style="cursor:pointer;" class="tooltip" id="img_search<{$field.id}>" onclick="tdmcreate_setStatus( { op: 'display', field_id: <{$field.id}>, field_search: <{if $field.search}>0<{else}>1<{/if}> }, 'img_search<{$field.id}>', 'fields.php' )" src="<{xoModuleIcons16}><{$field.search}>.png" alt="<{$smarty.const._AM_TDMCREATE_CHANGE_DISPLAY}>&nbsp;<{$field.name}>" title="<{$smarty.const._AM_TDMCREATE_CHANGE_DISPLAY}>&nbsp;<{$field.name}>" />
				</td>
				<td class='center'>
					<img id="loading_img_required<{$field.id}>" src="<{$modPathIcon16}>/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>" alt="<{$smarty.const._AM_SYSTEM_LOADING}>" /><img style="cursor:pointer;" class="tooltip" id="img_required<{$field.id}>" onclick="tdmcreate_setStatus( { op: 'display', field_id: <{$field.id}>, field_required: <{if $field.required}>0<{else}>1<{/if}> }, 'img_required<{$field.id}>', 'fields.php' )" src="<{xoModuleIcons16}><{$field.required}>.png" alt="<{$smarty.const._AM_TDMCREATE_CHANGE_DISPLAY}>&nbsp;<{$field.name}>" title="<{$smarty.const._AM_TDMCREATE_CHANGE_DISPLAY}>&nbsp;<{$field.name}>" />   
                </td>
                <td class='center'><img src="<{$modPathIcon16}>/left_right.png" alt="Empty" /></td>
               </tr>
             <{/if}>
            <{/foreach}>
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