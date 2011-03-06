<div id="fileUpload"><p>File uploader failed to load.</p></div>
<script type="text/javascript">
jQuery(function($) {
    $("#fileUpload").uploadify({
        'uploader': '<?php echo $this->assetUrl; ?>/images/uploadify.swf',
        'cancelImg': '<?php echo $this->assetUrl; ?>/images/cancel.png',
        //'script': '/wpii/wp-content/plugins/wpii/uploadify.php',
		'script': '/WPii/wp-content/plugins/wpii/uploader.php',
		//'script': '/Wpii/wp-admin/',
		'scriptData': {
			auth_cookie : 'admin|1298709371|df1f7bf9b8aed0b5994bb08bc10ea89a',
			logged_in_cookie: 'admin|1298709371|33e3c29c3b97b3a2df4a38a310883a62',
			route: 'contacts/default/upload'
		},
        'fileDesc': 'Image Files',
        'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
        'multi': true,
		'auto': true,
        'buttonText': 'Upload',
        'onComplete': complete,
        onError: function (a, b, c, d) {
        if (d.status == 404)
            alert('Could not find upload script. Use a path relative to: '+'<?php echo getcwd(); ?>');
        else if (d.type === "HTTP")
           alert('error '+d.type+": "+d.status);
        else if (d.type ==="File Size")
           alert(c.name+' '+d.type+' Limit: '+Math.round(d.sizeLimit/1024)+'KB');
        else
           alert('error '+d.type+": "+d.text);
        }
    });

    function complete(evnt, queueID, fileObj, response, data) {
        alert(response);
    }
});
</script>