//Google QR-Code generator plugin by zmmaj from zmajsoft-team
//blah... version 1.1.
//problems? write to zmajsoft@zmajsoft.com

CKEDITOR.plugins.add( 'qrc',
{
	init: function( editor )
	{
		editor.addCommand( 'qrc', new CKEDITOR.dialogCommand( 'qrc' ) );
		editor.ui.addButton( 'qrc',
		{
			label: 'Insert a ZS Google QR-Code picture',
			command: 'qrc',
			icon: this.path + 'images/qrc.png'
		} );
 
		CKEDITOR.dialog.add( 'qrc', function( editor )
		{
			return {
				title : 'QR-Code 生成器',
				minWidth : 400,
				minHeight : 200,
				contents :
				[
					{
						id : 'qrc_general',
						label : 'QR Settings',
						elements :
						[
							{
								type : 'html',
								html : ''
							},
							{
								type : 'text',
								id : 'txt',
								label : '請輸入文字或網址',
								validate : CKEDITOR.dialog.validate.notEmpty( 'Can NOT be empty.' ),
								required : true,
								commit : function( data )
								{
									data.txt = this.getValue();
								}
							},
					
														{
								type : 'text',
								id : 'siz',
								label : '請輸入圖片大小 ( 例如 300)',
								validate : CKEDITOR.dialog.validate.notEmpty( 'Can NOT be empty.' ),
								required : true,
								commit : function( data )
								{
									data.siz= this.getValue();
								}
							},


		           	{
								type : 'html',
							html : ''
							}
						]
					}
				],
				onOk : function()
				{
			var dialog = this,
						data = {},
						link = editor.document.createElement( 'a' );
					this.commitContent( data );

					editor.insertHtml('<img src="https://chart.googleapis.com/chart?cht=qr&chs='+data.siz+'x'+data.siz+ '&chl='+data.txt+'&choe=UTF-8 &chld=H |4"/>');
				}
			};
		} );
	}
} );