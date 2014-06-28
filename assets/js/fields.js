// Jquery function for side fields
$(document).ready( function() {
		// Controls Drag & Drop
		$('tbody tr.sortable td:nth-child(1) img').sortable({					
				update: function(event, ui) {
                    var list = $(this).sortable( 'serialize');
                    $.post( 'fields.php?op=order', list );
                },
				receive: function(event, ui) {                    
                    var field_id = $(ui.item).attr('field_id');
                    var list = $(this).sortable( 'serialize');                    
                    $.post( 'fields.php', { op: 'drag', field_id: field_id } );                    
                    $.post( 'fields.php?op=order', list );                      
                }
			}
		);
		$('tr.sortable').disableSelection();
	},
	function() {
		$( ".portlet" )
		  .addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
		  .find( ".portlet-header" )
			.addClass( "ui-widget-header ui-corner-all" )
			.prepend( "<span class='ui-icon ui-icon-minusthick portlet-toggle'></span>");
	 
		$( ".portlet-toggle" ).click(function() {
		  var icon = $( this );
		  icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
		  icon.closest( ".portlet" ).find( ".portlet-content" ).toggle();
		});
	}	
);
