(function ($) {
	$(function () {
		var frame;
		var $preview = $('#personalblog-user-avatar-preview');
		var $field = $('#personalblog-user-avatar-id');
		var $upload = $('#personalblog-upload-avatar');
		var $remove = $('#personalblog-remove-avatar');

		function renderPreview(attachment) {
			if (!attachment) {
				$preview.html('<span>' + $upload.data('placeholder') + '</span>');
				$field.val('');
				$remove.prop('disabled', true);
				return;
			}

			var url = attachment.get('url');
			var id = attachment.get('id');

			$preview.html('<img src="' + url + '" alt="" width="96" height="96" style="border-radius:50%;" />');
			$field.val(id);
			$remove.prop('disabled', false);
		}

		$upload.on('click', function (event) {
			event.preventDefault();

			if (frame) {
				frame.open();
				return;
			}

			frame = wp.media({
				title: $upload.data('title') || 'Select avatar',
				multiple: false,
				library: {
					type: ['image']
				}
			});

			frame.on('select', function () {
				var attachment = frame.state().get('selection').first();
				renderPreview(attachment);
			});

			frame.open();
		});

		$remove.on('click', function (event) {
			event.preventDefault();
			renderPreview(null);
		});
	});
})(jQuery);
